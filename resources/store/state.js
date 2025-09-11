export default () => ({
    user: {
        token: localStorage.getItem('token') || null,
        data: {},
    },
    isSidebarOpen: false,
})
