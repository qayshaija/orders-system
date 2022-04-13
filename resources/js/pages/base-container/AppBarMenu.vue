<template>
  <v-menu tile  bottom left offset-y open-on-hover>
    <template v-slot:activator="{ on, attrs }">
      <v-btn tile text depressed v-bind="attrs" v-on="on" color="primary">
        <v-icon left>
          mdi-account
        </v-icon>
        <div class="d-flex flex-row align-center">
          <div>{{ username }}</div>
        </div>
      </v-btn>
    </template>

    <v-list flat elevation="0">
      <v-list-item dense link @click="logout">
        <v-list-item-title>Logout</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-menu>
</template>
<script>
export default {
  computed: {
    username() {
      return "User Name";
      // return window.localStorage.getItem('username');
    }
  }
}
</script>
