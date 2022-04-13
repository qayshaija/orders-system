<template>
  <v-app id="inspire">
    <v-main class="grey lighten-3 align-center">
      <v-container>
        <v-row class="justify-center pa-10">
          <v-card class="card-bg pa-8" dark max-width="450" min-width="300" width="100%">
            <v-form ref="loginForm" @submit="login" autocomplete="off">
              <v-card-title class="justify-center mb-2">
                <v-avatar color="white" size="115">
                  <v-icon size="55" color="grey darken-4">
                    mdi-account
                  </v-icon>
                </v-avatar>
              </v-card-title>
              <v-card-text class="white--text text-center app-combobox">
                <div class="text-h4 font-weight-light mb-8">LOGIN</div>
                <v-text-field au flat :rules="rules.username" solo-inverted placeholder="Username" label="Username" v-model="username" prepend-inner-icon="mdi-account"/>
                <v-text-field type="password" flat :rules="rules.password" solo-inverted placeholder="Password" label="Password" v-model="password" prepend-inner-icon="mdi-lock"/>
              </v-card-text>

              <v-card-actions class="justify-center">
                <v-btn :loading="isLoading" x-large color="white" depressed light rounded class="px-8 py-6" @click="login">Login</v-btn>
              </v-card-actions>

              <input type="submit" v-show="false">
            </v-form>
          </v-card>

        </v-row>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>

export default {
  data() {
    return {
      username: '',
      password: '',
      isLoading: false,
      rules: {
        username: [val => (val || '').length > 0 || 'This field is required'],
        password: [val => (val || '').length > 0 || 'This field is required'],
      },
    }
  },
  methods: {
    login(event) {
      event.preventDefault();
      let isValid = this.$refs.loginForm.validate();
      if (isValid) {
        this.isLoading = true;
        axios.post(this.apis.login, {username: this.username, password: this.password}).then(async response => {
          if (response.data.token) {
            this.storeToken(response.data.token);
            this.initEssentials().then(() => {
              this.$router.push("/");
            })
          }
        }).finally(() => {
          this.isLoading = false;
        })
      }
    }
  }
}
</script>

<style scoped>
.card-bg {
  background: #9152f8;
  background: -webkit-linear-gradient(top, #7579ff, #b224ef);
}

</style>
<style>
form .app-combobox .error--text {
  color: #212121 !important;
  caret-color: #212121 !important;
}

form .app-combobox .error--text .v-messages__message {
  color: white !important;
}

</style>