<template>
  <v-app id="inspire">
    <v-navigation-drawer v-model="drawer" app>
      <v-app-bar color="primary" flat dark>
        <v-list-item>
          <v-list-item-content>
            <v-list-item-title class="w200 text-center text-h6 font-weight-light text-uppercase">
              Menu TITLE
            </v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-app-bar>
      <v-divider></v-divider>
      <dashboard-menu/>
    </v-navigation-drawer>

    <v-app-bar app flat class="ps-2" color="white" dark>
      <v-app-bar-nav-icon class="primary--text" @click="drawer = !drawer"></v-app-bar-nav-icon>
      LEFT APP BAR
      <v-spacer></v-spacer>
      <app-bar-menu/>
    </v-app-bar>
    <v-main class="grey lighten-3">
      <v-container>
        <div class="d-flex justify-center">
          <v-sheet tile class="flex-grow-1 flex-shrink-1" max-width="100%" min-height="70vh">
            <router-view></router-view>
          </v-sheet>
        </div>
      </v-container>
    </v-main>
  </v-app>
</template>


<script>
import DashboardMenu from "./DashboardMenu";
import AppBarMenu from "./AppBarMenu";

export default {
  components: {AppBarMenu, DashboardMenu},
  data() {
    return {
      drawer: true
    }
  },
  mounted() {

  }
}
</script>