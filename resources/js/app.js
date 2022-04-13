import Vue from "vue";
import vuetify from './vuetify'
import mixin from './mixins'
import router from "./routes";
import store from "./store";
import lodash from "lodash";
import VueClipboard from 'vue-clipboard2'
import VueExcelXlsx from "vue-excel-xlsx";





require('./axios')


window.Vue = Vue.default;
window.lodash = lodash;

Vue.component('base-container', require('./pages/base-container/Index').default);
Vue.component('delete-dialog', require('./components/DeleteDialog').default);



Vue.use(VueClipboard)
Vue.use(VueExcelXlsx)


Vue.mixin(mixin);
new Vue({
    el: '#app',
    router,
    store,
    vuetify
});
