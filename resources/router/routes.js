const HomePage = () => import('@/pages/Home.vue')
const Login = () => import('@/pages/Login.vue')
const Register = () => import('@/pages/Register.vue')
const ForgotPassword = () => import('@/pages/ForgotPassword.vue')
const ResetPassword = () => import('@/pages/ResetPassword.vue')
const Profile = () => import('@/pages/Profile.vue')
const ProfileInfo = () => import('@/components/profile-page/ProfileInfo.vue')
const ProfileChangePassword = () =>
    import('@/components/profile-page/ProfileChangePassword.vue')
const ProfileOrders = () =>
    import('@/components/profile-page/ProfileOrders.vue')
const ProfileAddresses = () =>
    import('@/components/profile-page/ProfileAddresses.vue')
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
        component: AppLayout,
        children: [
            {
                path: '',
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
            {
                path: 'login',
                name: 'login',
                component: Login,
                meta: { guestOnly: true },
            },
            {
                path: 'register',
                name: 'register',
                component: Register,
                meta: { guestOnly: true },
            },
            {
                path: 'profile',
                component: Profile,
                meta: {
                    requiresAuth: true,
                },
                redirect: '/profile/data',
                children: [
                    {
                        path: 'data',
                        name: 'profile.data',
                        component: ProfileInfo,
                    },
                    {
                        path: 'change-password',
                        name: 'profile.change-password',
                        component: ProfileChangePassword,
                    },
                    {
                        path: 'orders',
                        name: 'profile.orders',
                        component: ProfileOrders,
                    },
                    {
                        path: 'shipping-addresses',
                        name: 'profile.shipping-addresses',
                        component: ProfileAddresses,
                    },

                    //more to come
                ],
            },
            {
                path: 'forgot-password',
                name: 'forgot-password',
                component: ForgotPassword,
                meta: { guestOnly: true },
            },
            {
                path: 'reset-password',
                name: 'reset-password',
                component: ResetPassword,
                meta: { guestOnly: true },
            },
            {
                path: ':pathMatch(.*)*',
                name: 'notFound',
                component: NotFound,
            },
        ],
    },
]
