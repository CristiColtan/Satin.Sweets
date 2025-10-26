export default () => ({
    user: {
        token: localStorage.getItem('token') || null,
        data: {},
    },
    isSidebarOpen: false,
    products: createTableState(),
    addons: {
        glitters: createTableState(),
        plushies: createTableState(),
        photos: createTableState(),
        ribbons: createTableState(),
    },
})

function createTableState() {
    return {
        loading: false,
        data: [],
        links: [],
        from: null,
        to: null,
        page: 1,
        limit: null,
        total: null,
    }
}
