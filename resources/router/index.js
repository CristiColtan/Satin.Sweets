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

        if (to.meta.requiresAuth && !store.user.token) {
            next({ name: 'login' })
        } else if (to.meta.isAdmin && !store.user.data.is_admin) {
            next({ name: 'app' })
        }
        next()
    })
}
