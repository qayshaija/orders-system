<template>
  <div>
    <AddUser @createdUser="pushUser"/>
    <v-divider/>
    <div class="pa-4">
      <v-data-table class="elevation-1 rounded-0" :headers="headers" :items="users" :loading="loading">
        <template v-slot:item.actions="{ item }">
          <edit-user @updatedUser="updateUser" :editedItem="item"/>
          <delete-dialog @confirm="deleteItem(item)">
            <v-icon small>
              mdi-delete
            </v-icon>
          </delete-dialog>
        </template>
      </v-data-table>
    </div>
  </div>
</template>
<script>
import AddUser from './add-user-dialog'
import EditUser from './edit-user-dialog'

export default {
  components: {AddUser, EditUser},
  data: () => ({
    headers: [
      {text: 'Username', value: 'username'},
      {text: 'Created At', value: 'createdAt'},
      {text: 'Actions', value: 'actions', sortable: false},
    ],
    users: [],
    loading: false,
  }),


  created() {
    this.initialize()
  },

  methods: {
    initialize() {
      this.loading = true;
      axios.get(this.apis.getUsers).then(response => {
        this.users = response.data.reverse();
      }).finally(() => {
        this.loading = false;
      });
    },
    pushUser(user) {
      this.users.unshift(user);
    },
    updateUser(item) {
      let targetItem = this.users.findIndex((user) => {
        return user.id === item.id;
      });
      this.$set(this.users, targetItem, item);
    },
    deleteItem(item) {
      axios.delete(this.apis.deleteUser(item.id)).then(response => {
        let deletedIndex = this.users.indexOf(item)
        this.users.splice(deletedIndex, 1)
      })
    },
  },
}
</script>

<style>
.text-uppercase {
  text-transform: uppercase !important;
}

</style>