let apiEndpoint = `${location.protocol + '//' + location.host}/api/`;

export default {
    apis: {
        login: `${apiEndpoint}login`,
        logout: `${apiEndpoint}logout`,
        getUserInfo: `${apiEndpoint}user`,
        initCSRF: `/sanctum/csrf-cookie`,


        getUsers: `${apiEndpoint}users`,
        storeUser: `${apiEndpoint}users`,
        updateUser: (id) => `${apiEndpoint}users/${id}`,
        deleteUser: (id) => `${apiEndpoint}users/${id}`,


        getOrders: `${apiEndpoint}orders`,
        storeOrder: `${apiEndpoint}orders`,
        updateOrder: (id) => `${apiEndpoint}orders/${id}`,
        deleteOrder: (id) => `${apiEndpoint}orders/${id}`,
        bulkUpdateOrders: `${apiEndpoint}orders/bulk-update`,
        bulkDeleteOrders: `${apiEndpoint}orders/bulk-delete`,
        getReportOrders: (id) => `${apiEndpoint}orders/report/${id}`,

        getStores: `${apiEndpoint}stores`,
        storeStore: `${apiEndpoint}stores`,
        updateStore: (id) => `${apiEndpoint}stores/${id}`,
        deleteStore: (id) => `${apiEndpoint}stores/${id}`,

        getReports: `${apiEndpoint}reports`,
        storeReport: `${apiEndpoint}reports`,
        updateReport: (id) => `${apiEndpoint}reports/${id}`,
        deleteReport: (id) => `${apiEndpoint}reports/${id}`,

    },
    validation: {
        required: [
            value => !!value || 'This field is required.'
        ],
        notEmptyArray: [
            value => !!(Array.isArray(value) && value.length) || 'This field is required.'
        ],
    },
}