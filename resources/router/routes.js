const HomePage = () => import('@/pages/Home.vue')
const Login = () => import('@/pages/Login.vue')
const Register = () => import('@/pages/Register.vue')
const ResetPassword = () => import('@/pages/ResetPassword.vue')
const Profile = () => import('@/pages/Profile.vue')
const ProfileData = () => import('@/pages/ProfileData.vue')
const NotFound = () => import('@/pages/NotFound.vue')
export const routes = [
    {
        path: '/',
        name: 'home',
        component: HomePage,
    },
    {
        path: '/profile',
        name: 'profile',
        component: Profile,
        meta: {},
        children: [
            {
                path: 'data',
                name: 'profile.data',
                component: ProfileData,
            },
            //more to come
        ],
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
    {
        path: '/:pathMatch(.*)*',
        name: 'notFound',
        component: NotFound,
    },
]
