<template>
  <v-dialog v-model="dialog" max-width="500px">
    <template v-slot:activator="{ on, attrs }">
      <v-icon small v-on="on" v-bind="attrs" class="mr-2">
        mdi-pencil
      </v-icon>
    </template>
    <v-form ref="editUserForm" v-if="user">
      <v-card>
        <v-card-title>
          <span class="text-uppercase font-weight-regular">Edit User</span>
        </v-card-title>
        <v-card-text>
          <v-text-field solo :rules="validation.required" placeholder="Username" label="Username" v-model="user.username"/>
          <v-row>
            <v-col>
              <v-text-field solo type="password" :rules="rules.password" placeholder="Password" v-model="user.password"/>
            </v-col>
            <v-col>
              <v-text-field solo ref="confirmPassword" v-model="confirmPassword" :rules="rules.confirmPassword" type="password" placeholder="Confirm Password"/>
            </v-col>
          </v-row>

        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn tile text @click="close">Cancel</v-btn>
          <v-btn tile text color="green darken-1" :disabled="!canSave" @click="save" :loading="loading">
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </v-dialog>
</template>
<script>



export default {
  props: ['editedItem'],
  data() {
    return {
      confirmPassword: '',
      user: null,
      rules: {
        password: [
          val => {
            if (this.confirmPassword) {
              return (val || '').length > 0 || 'Required';
            }
            return true;
          }
        ],
        confirmPassword: [
          val => {
            return (!this.user.password || this.user.password === val) || 'Passwords are not equal'
          }
        ]
      },
      dialog: false,
      loading: false,
    }
  },
  methods: {
    initialize() {
      this.$refs.editUserForm && this.$refs.editUserForm.reset()
      this.user = null;
      this.$nextTick(() => {
        this.user = _.cloneDeep(this.editedItem)
      });
    },
    save() {
      let isValid = this.$refs.editUserForm.validate()
      if (isValid) {
        this.loading = true;
        let postData = _.cloneDeep(this.user);
        axios.post(this.apis.updateUser(this.user.id), postData).then(response => {
          this.$emit('updatedUser', response.data);
          this.close();
        }).finally(() => this.loading = false);
      }
    },
    close() {
      this.dialog = false;
    },

  },
  computed: {
    canSave() {
      return !_.isEqual(_.cloneDeep(this.editedItem), _.cloneDeep(this.user));
    }
  },
  watch: {
    dialog() {
      this.initialize();
    }
  },

}
</script>