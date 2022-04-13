import ManageUsers from "./pages/manage-users";
import Orders from "./pages/orders/Index";
import Stores from "./pages/stores/Index";
import Reports from "./pages/reports/Index";

export default [
    {
        name: 'Manage Users',
        route: '/manage-users',
        icon: 'mdi-web',
        level: 1,
        component: ManageUsers,
    },
    {
        name: 'Orders',
        route: '/orders',
        icon: 'mdi-web',
        level: 1,
        component: Orders,
    },
    {
        name: 'Reports',
        route: '/reports',
        icon: 'mdi-web',
        level: 1,
        component: Reports,
    },
    {
        name: 'Stores',
        route: '/stores',
        icon: 'mdi-web',
        level: 1,
        component: Stores,
    }
]
