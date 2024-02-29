import { createWebHistory, createRouter } from 'vue-router'
import useCartData from '@/store/CartData';
import useCustomerStore from '@/store/Customer'
import useAuth from '@/store/auth';

const routes = [
    {
        path: "/",
        component: () => import('@/App.vue'),
        meta: {
            middleware: "guest",
            title: `Home`
        },
        children: [
            {
                path: '/',
                name: "homepage",
                component: () => import('@/components/frontend/pages/Home.vue'),
                meta: {
                    middleware: "user",
                    title: `Homepage`
                }
            },
            {
                path:'/cart',
                name: 'cart',
                component: ()=> import('@/components/frontend/pages/Cart.vue'),
                meta:{
                    middleware: 'user',
                    title: 'Cart'
                }
            },
            { // Shop Page
                path:'/shop',
                name:'shop',
                component: () => import('@/components/frontend/pages/Shop.vue'),
                meta:{
                    middleware: 'user',
                    title: 'Shop Page'
                }
            },
            {
                path:'/user/category/:id',
                name:'user.category',
                component: () => import('@/components/frontend/pages/Shop.vue'),
                meta:{
                    middleware:'user',
                    title: 'Category Wise Books'
                }
            },
            {
                path:'/user/product/:id',
                name:'user.product',
                component: () => import('@/components/frontend/pages/BookDetails.vue'),
                meta:{
                    middleware:'user',
                    title: 'Books Details'
                }
            },
            {
                path:'/wishlist',
                name:'wishlist',
                component: () => import('@/components/frontend/pages/Wishlist.vue'),
                meta:{
                    middleware:'user',
                    title: 'Wishlist Page'
                }
            },

           

            // { // user login
            //     path: '/login',
            //     name: 'login',
            //     component: () => import('@/components/frontend/Login.vue'),
            //     meta: {
            //         middleware: 'user',
            //         title: "User Login"
            //     }
            // },
            // { // Account
            //     path:'/account',
            //     name: 'account',
            //     component: () =>import('@/components/frontend/account/Dashboard.vue'),
            //     meta: {
            //         middleware: 'user',
            //         title: 'Account Dashboard',
            //     }
            // },
            // { // Orders
            //     path: 'order',
            //     name: 'order',
            //     component: () => import('@/components/frontend/account/Orders.vue'),
            //     meta:{
            //         middleware: 'user',
            //         title: 'Orders'
            //     }
            // },           
        ]
    },


    {
        path: "/admin/login",
        name: "admin.login",
        component: () => import('@/components/frontend/pages/Login.vue'),
        meta: {
            middleware: "guest",
            title: `Login`
        }
    },
    {
        path: "/register",
        name: "register",
        component: () => import('@/components/frontend/pages/Register.vue'),
        meta: {
            middleware: "guest",
            title: `Register`
        }
    },
    {
        path: "/admin/dashboard",
        name: 'admin.dashboard',
        component: () => import('@/components/backend/layouts/Main.vue'),
        meta: {
            middleware: "auth",
            requiresAuth: true
        },
        children: [
            {
                path: '/dashboard',
                name: "dashboard",
                component: () => import('@/components/backend/pages/Dashboard.vue'),
                meta: {
                    title: `Dashboard`,
                    requiresAuth: true
                }
            },

            { //category
                path: '/admin/category',
                name: 'admin.category',
                component: () => import('@/components/backend/pages/category/Category.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Category List',
                    requiresAuth: true
                }
            },
            {
                path: '/admin/addcategory',
                name: 'admin.addcategory',
                component: () => import('@/components/backend/pages/category/addCategory.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Add Category',
                    requiresAuth: true
                }
            },
            {
                path: '/admin/category/:id',
                name: 'admin.editCat',
                component: () => import('@/components/backend/pages/category/addCategory.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Edit Category',
                    requiresAuth: true
                }
            },

            { //subcategory
                path: '/admin/subcategory',
                name: 'admin.subcategory',
                component: () => import('@/components/backend/pages/subcategory/Subcategory.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Sub-Category List',
                    requiresAuth: true
                }
            },
            {
                path: '/admin/addsubcategory',
                name: 'admin.addsubcategory',
                component: () => import('@/components/backend/pages/subcategory/addSubcategory.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Add Subcategory',
                    requiresAuth: true
                }
            },
            {
                path: '/admin/subcategory/:id',
                name: 'admin.editsubcategory',
                component: () => import('@/components/backend/pages/subcategory/addSubcategory.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Edit Subcategory',
                    requiresAuth: true
                }
            },

            { //Product
                path: '/admin/product',
                name: 'admin.product',
                component: () => import('@/components/backend/pages/product/Products.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Products List',
                    requiresAuth: true
                }
            },
            {
                path: '/admin/addproduct',
                name: 'admin.addProduct',
                component: () => import('@/components/backend/pages/product/addProduct.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Products List',
                    requiresAuth: true
                }
            },
            {
                path: '/admin/editproduct/:id',
                name: 'admin.editProduct',
                component: () => import('@/components/backend/pages/product/addProduct.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Products List',
                    requiresAuth: true
                }
            },


            { // users
                path: '/admin/users',
                name: 'admin.users',
                component: () => import('@/components/backend/pages/users/Users.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Users List',
                    requiresAuth: true
                }
            },
            {
                path: '/admin/addUpdate',
                name: 'admin.adduser',
                component: () => import('@/components/backend/pages/users/addUser.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Users Add or Update',
                    requiresAuth: true
                }
            },
            {
                path: '/admin/useredit/:id',
                name: 'admin.userEdit',
                component: () => import('@/components/backend/pages/users/addUser.vue'),
                meta: {
                    middleware: 'auth',
                    title: 'Users Add or Update',
                    requiresAuth: true
                }
            },

            // {
            //     path: '/admin/setting',
            //     name: 'admin.setting',
            //     component: () => import('@/components/backend/setting/Setting.vue'),
            //     meta: {
            //         middleware: 'auth',
            //         title: 'Site Settings',
            //         requiresAuth: true
            //     }
            // },

            // {
            //     path: '/admin/profile',
            //     name: 'admin.profile',
            //     component: () => import('@/components/backend/setting/Profile.vue'),
            //     meta: {
            //         middleware: 'auth',
            //         title: 'Admin Profile',
            //         requiresAuth: true
            //     }
            // },
           
        ]
    },

]

const router = createRouter({
    mode: 'history',
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to, from) => {
    const cartData = useCartData();
    const customer = useCustomerStore();
    const authStore = useAuth();

    // if(to.meta.middleware === 'user'){
    //     await Promise.all([
    //         authStore.getAuthUser(),
    //         // customer.setCustomer(),
    //         // cartData.fetchCartItem(),
    //     ])
    // }
    if(customer.isCustomer  && to.name ==='admin.login' ){
        router.push({ name: 'homepage' })
    }

    if(!authStore.isAuthenticated && to.meta.middleware === 'auth'){
        router.push({ name:'admin.login' })
    }
});


export default router