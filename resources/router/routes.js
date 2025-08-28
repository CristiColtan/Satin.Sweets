const HomePage = () => import('@/pages/Home.vue')
const Login = () => import('@/pages/Login.vue')
const Register = () => import('@/pages/Register.vue')
const ResetPassword = () => import('@/pages/ResetPassword.vue')
export const routes = [
    {
        path: '/',
        name: 'home',
        component: HomePage,
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: ResetPassword,
    },
]
