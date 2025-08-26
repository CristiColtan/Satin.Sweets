const HomePage = () => import ('@/pages/Home.vue')
const Login = () => import ('@/pages/Login.vue')
export const routes = [
    {
        path: '/',
        name: 'home',
        component: HomePage
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    }
]
