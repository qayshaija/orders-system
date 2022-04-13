import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        userPages: [],
        reports: [],
        stores: [],
        orderStatuses: [
            {id: 1, name: 'Fresh', color: 'black'},
            {id: 2, name: 'Confirmed', color: 'green'},
            {id: 3, name: 'Canceled', color: 'red'},
            {id: 4, name: 'Returned', color: 'blue'},
            {id: 5, name: 'No Answer', color: 'pink'},
            {id: 6, name: 'BLANK', color: 'tomato'},
        ],
        user: {
            isLoggedIn: false,
            username: null,
            token: null,
            permissions: [],
            pages: [],
        }
    },
    getters: {},
    mutations: {}
})

