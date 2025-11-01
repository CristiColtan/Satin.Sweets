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
const AdminLayout = () => import('@/components/AdminLayout.vue')
const AdminDashboard = () => import('@/pages/admin/AdminDashboard.vue')
const AdminProducts = () => import('@/pages/admin/AdminProducts.vue')
const AdminGlitter = () => import('@/pages/admin/AdminGlitter.vue')
const AdminPlushies = () => import('@/pages/admin/AdminPlushies.vue')
const AdminBouquetAccessories = () =>
    import('@/pages/admin/AdminBouquetAccessories.vue')
const Product = () => import('@/pages/Product.vue')
export const routes = [
    {
        path: '/admin',
        name: 'admin',
        component: AdminLayout,
        meta: {
            requiresAuth: true,
            isAdmin: true,
        },
        redirect: '/admin/dashboard',
        children: [
            {
                path: 'dashboard',
                name: 'admin.dashboard',
                component: AdminDashboard,
            },
            {
                path: 'products',
                name: 'admin.products',
                component: AdminProducts,
            },
            {
                path: 'glitter',
                name: 'admin.glitter',
                component: AdminGlitter,
            },
            {
                path: 'plushies',
                name: 'admin.plushies',
                component: AdminPlushies,
            },
            {
                path: 'bouquets-accessories',
                name: 'admin.bouquets-accessories',
                component: AdminBouquetAccessories,
            },
        ],
    },
    {
        path: '/',
        name: 'app',
        component: AppLayout,
        redirect: '/home',
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
            {
                path: 'produs/:slug',
                name: 'app.product',
                component: Product,
                props: true,
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
