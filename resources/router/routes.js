const HomePage = () => import('@/pages/Home.vue')
const Login = () => import('@/pages/Login.vue')
const Register = () => import('@/pages/Register.vue')
const ResetPassword = () => import('@/pages/ResetPassword.vue')
const Profile = () => import('@/pages/Profile.vue')
const ProfileData = () => import('@/pages/ProfileData.vue')
const NotFound = () => import('@/pages/NotFound.vue')
const AppLayout = () => import('@/components/AppLayout.vue')
const BucheteDeFlori = () => import('@/pages/BucheteDeFlori.vue')
const TablouriPersonalizate = () => import('@/pages/TablouriPersonalizate.vue')
export const routes = [
    {
        path: '/',
        name: 'app',
        component: AppLayout,
        redirect: '/app/home',
        children: [
            {
                path: 'home',
                name: 'app.home',
                component: HomePage,
            },
            {
                path: 'buchete-de-flori',
                name: 'app.buchete-de-flori',
                component: BucheteDeFlori,
            },
            {
                path: 'tablouri-personalizate',
                name: 'app.tablouri-personalizate',
                component: TablouriPersonalizate,
            },
        ],
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
