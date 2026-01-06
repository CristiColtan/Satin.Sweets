export default {
    favoritesCount: (state) => state.favorites.ids.length,
    cartCount: (state) => {
        return state.cart.items.reduce((sum, item) => sum + item.quantity, 0)
    },
    cartTotal: (state) => {
        return state.cart.items.reduce(
            (sum, item) => sum + item.quantity * Number(item.unit_price || 0),
            0,
        )
    },
}
