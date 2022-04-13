<template>
  <div>
    <dashboard v-if="$store.state.user.isLoggedIn"/>
    <router-view v-else-if="!loading"></router-view>
    <Loading v-else></Loading>
  </div>
</template>
<script>
import Loading from "./Loading";
import Dashboard from "./Dashboard";

export default {
  components: {Dashboard, Loading},
  data() {
    return {
      loading: false,
    }
  },
  computed: {
    pages() {
      return this.$store.state.pages;
    }
  },
  mounted() {
    this.loading = true;
    this.initEssentials().then(() => {
      if(!this.$store.state.user.isLoggedIn){
        this.redirectToLogin();
      }else{
        this.getStores();
      }
    }).finally(() => {
      this.loading = false;
    });

  }
}
</script>