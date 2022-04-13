import confs from './confs'
import pages from './pages'


export default {
    computed: {
        apis() {
            return confs.apis;
        },
        validation() {
            return confs.validation;
        },
        stores(){
            return this.$store.state.stores;
        },
        reports(){
            return this.$store.state.reports;
        },
        orderStatuses(){
            return this.$store.state.orderStatuses;
        }
    },
    methods: {
        storeById(id) {
            return this.stores.find(el => el.id === Number.parseInt(id)) || {};
        },
        orderStatusById(id) {
            return this.orderStatuses.find(el => el.id === Number.parseInt(id)) ;
        },
        reportById(id) {
            return this.reports.find(el => el.id === Number.parseInt(id)) || {};
        },
        getStores() {
            if (!this.stores.length) {
                axios.get(this.apis.getStores).then(res => {
                    this.$store.state.stores = res.data;
                });
            }
        },
        getReports() {
            axios.get(this.apis.getReports).then(res => {
                this.$store.state.reports = res.data;
            })
        },
        async initCSRF() {
            await axios.get(this.apis.initCSRF);
        },
        getUserInfo() {
            return axios.get(this.apis.getUserInfo).then(response => {
                this.storeUserInfo(response.data);
                this.initPages(this.$store.state.user.level);
            })
        },
        initPages(level) {
            let userPages = this.pagesFromLevel(level);
            this.$store.state.userPages = userPages;
            this.registerRoutesFromPages(userPages)
        },
        registerRoutesFromPages(pages) {
            pages.forEach(page => {
                this.$router.addRoute(null, {
                    name: page.name, path: page.route, component: page.component, meta: {title: page.name, icon: page.icon}
                })
            });
        },
        pagesFromLevel(level) {
            return pages.filter(page => page.level === level);
        },
        storeUserInfo(userinfo) {
            this.$store.state.user.isLoggedIn = true;
            this.$store.state.user.username = userinfo.username;
            this.$store.state.user.level = userinfo.level;
        },
        async initEssentials() {
            await this.initCSRF()
            let storedToken = window.localStorage.getItem('token');
            if (storedToken) {
                this.storeToken(storedToken)
                try {
                    await this.getUserInfo()
                } catch (e) {
                    this.logout();
                }
            }
        },
        storeToken(token) {
            this.setAxiosBearer(token);
            this.$store.state.user.token = token;
            window.localStorage.setItem("token", token);
        },
        logout() {
            axios.post(this.apis.logout);
            this.$store.state.user.isLoggedIn = false;
            this.$store.state.user.username = null;
            this.$store.state.user.level = null;
            window.localStorage.removeItem("token");
            this.setAxiosBearer(null);
            this.redirectToLogin();
        },
        setAxiosBearer(token) {
            axios.defaults.withCredentials = true;
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        },
        redirectToLogin() {
            if (this.$route.name !== 'login') {
                this.$router.push('/login').catch(() => {
                });
            }
        },

    }
}