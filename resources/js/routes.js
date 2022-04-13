import VueRouter from 'vue-router'
import Vue from "vue";
import Login from "./pages/auth/Login";
import Orders from "./pages/orders/Index";

Vue.use(VueRouter)

let routes = [
    {
        path: '/orders/report/:reportId',
        name: 'Orders',
        component: Orders,
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
    },
];

export default new VueRouter({
    mode: 'history',
    routes: routes,
});

