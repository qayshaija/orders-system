<template>
  <v-dialog v-model="dialog" max-width="500">
    <template v-slot:activator="{on}">
      <v-icon v-on="on">mdi-pencil</v-icon>
    </template>
    <v-card v-if="dialog">
      <v-card-title>Store Data</v-card-title>
      <v-card-text>
        <v-form ref="storeForm">
          <v-text-field hide-details placeholder="Name" label="Name" v-model="tmpStore.name"/>
        </v-form>
      </v-card-text>
      <v-card-actions class="d-flex justify-end">
        <v-btn depressed color="primary" @click="saveStore">Save</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
export default {
  props: ['store'],
  data() {
    return {
      dialog: false,
      loading: false,
      tmpStore: null,
    }
  },
  methods: {
    saveStore() {
      this.loading = true;
      axios.post(this.apis.updateStore(this.store.id), this.tmpStore).then(res => {
        this.emitStore(res.data);
        this.dialog = false;
      }).finally(() => this.loading = false)
    },
    emitStore(store) {
      this.$emit('updateStore', store)
      this.$refs.storeForm.reset();
    },
    initValue(){
      this.tmpStore = _.cloneDeep(this.store);
    }
  },
  watch: {
    dialog(){
      this.initValue();
    }
  },
  mounted() {
    this.initValue();
  }
}
</script>