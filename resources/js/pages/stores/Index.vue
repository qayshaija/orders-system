<template>
  <div class="pa-2">
    <div class="d-flex justify-end mb-2">
      <add-store-dialog @newStore="addStore"/>
    </div>
    <v-data-table :items="$store.state.stores" :headers="headers" :loading="loading.getStores">
      <template v-slot:item.actions="{item}">
        <delete-dialog @confirm="deleteStore(item)">
          <v-icon>mdi-delete</v-icon>
        </delete-dialog>
        <edit-store-dialog :store="item" @updateStore="updateStore"/>
      </template>
    </v-data-table>
  </div>
</template>

<script>

import AddStoreDialog from "./add-store-dialog";
import EditStoreDialog from "./edit-store-dialog";

export default {
  components: {EditStoreDialog, AddStoreDialog},
  data() {
    return {
      headers: [
        {text: 'Name', value: 'name'},
        {text: 'Actions', value: 'actions'}
      ],
      loading: {
        getStores: false,
      }
    }
  },
  methods: {
    deleteStore(store) {
      axios.delete(this.apis.deleteStore(store.id)).then(res => {
        this.$store.state.stores.splice(this.stores.findIndex(el => el.id === store.id), 1);
      });
    },
    addStore(store) {
      this.$store.state.stores.push(store);
    },
    updateStore(store) {
      this.$store.state.stores.splice(this.stores.findIndex(el => el.id === store.id), 1, store);
    }
  },
  mounted() {
    this.getStores();
  }
}
</script>