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
        b_accessories: createTableState(),
        t_small_accessories: createTableState(),
        t_big_accessories: createTableState(),
    },
    favorites: {
        loading: false,
        ids: [],
        items: [],
        error: null,
    },
    cart: {
        items: [],
    },
    couponCode: null,
    couponDiscount: 0,
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
