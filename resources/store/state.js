export default () => ({
    user: {
        token: localStorage.getItem('token') || null,
        data: {},
    },
    isSidebarOpen: false,
    products: {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null,
    },
})
