<template>
  <v-dialog v-model="dialog" max-width="500">
    <template v-slot:activator="{on}">
      <v-btn depressed color="primary" small v-on="on">Add Store</v-btn>
    </template>
    <v-card>
      <v-card-title>Store Data</v-card-title>
      <v-card-text>
        <v-form ref="storeForm">
          <v-text-field hide-details placeholder="Name" label="Name" v-model="store.name"/>
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
  data() {
    return {
      dialog: false,
      loading: false,
      store: {
        name: '',
      }
    }
  },
  methods: {
    saveStore() {
      this.loading = true;
      axios.post(this.apis.storeStore, this.store).then(res => {
        this.emitStore(res.data);
        this.dialog = false;
      }).finally(() => this.loading = false)
    },
    emitStore(store) {
      this.$emit('newStore', store)
      this.$refs.storeForm.reset();
    }
  }
}
</script>