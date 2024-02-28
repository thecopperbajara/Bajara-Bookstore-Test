

<template>
    <div class="navbar bg-neutral text-neutral-content mb-5">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a>Item 1</a></li>
                    <li>
                        <a>Parent</a>
                        <ul class="p-2">
                            <li><a>Submenu 1</a></li>
                            <li><a>Submenu 2</a></li>
                        </ul>
                    </li>
                    <li><a>Item 3</a></li>
                </ul>
            </div>
            <a class="btn btn-ghost text-xl">daisyUI</a>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li>
                    <RouterLink :to="{ name: 'homepage' }">Home</RouterLink>
                </li>
                <li>
                    <RouterLink :to="{ name: 'shop' }">Books</RouterLink>
                </li>
                <!-- <li>
                    <RouterLink :to="{ name: 'cart' }">Cart</RouterLink>
                </li> -->
                <!-- <li>
                    <details>
                        <summary>Parent</summary>
                        <ul class="p-2">
                             <li><a>Submenu 1</a></li>
                            <li><a>Submenu 2</a></li>
                        </ul>
                    </details>
                </li> -->
            </ul>
        </div>
        <div class="navbar-end">
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                    <li><a class="btn btn-sm p-1 mr-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 opacity-70">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C15.09 3.81 16.76 3 18.5 3 21.58 3 24 5.42 24 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg></a></li>
                    <li v-if="authUser?.isAuthenticated">
                        <details>
                            <summary>
                                {{ authUser.user?.name }}
                            </summary>
                            <ul class="p-2 bg-base-100 rounded-t-none">
                                <li><a>Profile</a></li>
                                <li><a @click="logout">Logout</a></li>
                            </ul>
                        </details>
                    </li>
                    <li v-else>
                        <RouterLink :to="{ name: 'admin.login' }" class="btn btn-sm">Login</RouterLink>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { RouterLink } from 'vue-router';
import useAuth from '@/store/auth'

const authUser = useAuth();

const logout = () => {
    authUser.logout();
}

</script>