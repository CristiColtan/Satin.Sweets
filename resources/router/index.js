import { createRouter, createWebHistory } from 'vue-router'
import { routes } from './routes'
import { useAppStore } from '../store/index.js'

export const router = createRouter({
    history: createWebHistory(),
    routes,
})

{
    router.beforeEach((to, from, next) => {
        const store = useAppStore()

        const isLoggedIn = !!store.user.token
        const isAdmin = store.user.data?.is_admin

        if (to.meta.requiresAuth && !isLoggedIn) {
            return next({ name: 'login', query: { redirect: to.fullPath } })
        }

        if (to.meta.isAdmin && !isAdmin) {
            return next({ name: 'app.home' })
        }

        if (to.meta.guestOnly && isLoggedIn) {
            return next({ name: 'app.home' })
        }

        return next()
    })
}
