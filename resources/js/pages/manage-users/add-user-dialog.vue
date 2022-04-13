<template>
  <v-dialog v-model="dialog" max-width="500px">
    <template v-slot:activator="{ on, attrs }">
      <v-btn tile text depressed color="primary" v-bind="attrs" v-on="on">
        <v-icon left>
          mdi-plus
        </v-icon>
        New
      </v-btn>
    </template>
    <v-form ref="addUserForm">
      <v-card>
        <v-card-title>
          <span class="text-uppercase font-weight-regular">Add User</span>
        </v-card-title>
        <v-card-text>
          <v-text-field solo :rules="validation.required" placeholder="Username" label="Username" v-model="user.username"/>
          <v-row>
            <v-col>
              <v-text-field solo :rules="validation.required" type="password" placeholder="Password" v-model="user.password"/>
            </v-col>
            <v-col>
              <v-text-field solo :rules="rules.confirmPassword" type="password" placeholder="Confirm Password"/>
            </v-col>
          </v-row>

        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn tile text @click="close">Cancel</v-btn>
          <v-btn tile text color="green darken-1" @click="save">
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-dialog>
</template>
<script>


export default {
  data() {
    return {
      user: {
        username: '',
        password: '',
      },
      rules: {
        confirmPassword: [
          val => {
            return this.user.password === val || 'Passwords are not equal'
          }
        ]
      },
      dialog: false,
    }
  },
  methods: {
    save() {
      let isValid = this.$refs.addUserForm.validate()
      if (isValid) {
        this.loading = true;
        axios.post(this.apis.storeUser, this.user).then(response => {
          this.$emit('createdUser', response.data);
          this.close();
        }).finally(() => this.loading = false);
      }
    },
    refresh() {
      this.user = {
        username: '',
        password: '',
      };
      this.$refs.addUserForm && this.$refs.addUserForm.reset();
    },
    close() {
      this.dialog = false;
    }
  },
  watch: {
    dialog() {
      this.refresh();
    }
  }
}
</script>