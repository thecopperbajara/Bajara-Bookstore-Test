<template>
    <!-- <div class="navbar bg-neutral text-neutral-content mb-5">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <RouterLink :to="{ name: 'homepage' }">Home</RouterLink>
                    </li>
                    <li>
                        <RouterLink :to="{ name: 'shop' }">Books</RouterLink>
                    </li>
                </ul>
            </div>
            <RouterLink :to="{ name: 'homepage' }" class="btn btn-ghost text-xl">daisyUI</RouterLink>
        </div>
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1">
                <li>
                    <RouterLink :to="{ name: 'homepage' }">Home</RouterLink>
                </li>
                <li>
                    <RouterLink :to="{ name: 'shop' }">Books</RouterLink>
                </li>
                 <li>
                    <RouterLink :to="{ name: 'cart' }">Cart</RouterLink>
                </li> 
            </ul>
        </div>
        <div class="navbar-end">
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                    <li><a class="btn btn-sm p-1 mr-1"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                fill="currentColor" class="w-4 h-4 opacity-70">
                                <path
                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C15.09 3.81 16.76 3 18.5 3 21.58 3 24 5.42 24 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
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
    </div> -->

    <header class="mb-2 px-4 bg-gray-700 text-gray-200 shadow">
        <div
            class="relative mx-auto text-gray-200 flex max-w-screen-lg flex-col py-4 sm:flex-row sm:items-center sm:justify-between">
            <RouterLink :to="{ name: 'homepage' }" class="flex items-center text-2xl font-black">
                <span>Book Store</span>
            </RouterLink>
            <input class="peer hidden" type="checkbox" id="navbar-open" />
            <label class="absolute right-0 mt-1 cursor-pointer text-xl sm:hidden" for="navbar-open">
                <span class="sr-only">Toggle Navigation</span>
                <svg xmlns="http://www.w3.org/2000/svg" width="0.88em" height="1em" preserveAspectRatio="xMidYMid meet"
                    viewBox="0 0 448 512">
                    <path fill="currentColor"
                        d="M0 96c0-17.7 14.3-32 32-32h384c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zm0 160c0-17.7 14.3-32 32-32h384c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zm448 160c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32h384c17.7 0 32 14.3 32 32z" />
                </svg>
            </label>
            <nav aria-label="Header Navigation" class="peer-checked:block hidden pl-2 py-6 sm:block sm:py-0 text-white">
                <ul class="flex flex-col gap-y-4 sm:flex-row sm:gap-x-8">
                    <li class="">
                        <RouterLink class="hover:text-green-500 hover:underline transition-all cursor-pointer" :to="{ name: 'homepage' }">Home</RouterLink>
                    </li>
                    <li class="">
                        <RouterLink class="hover:text-green-500 hover:underline transition-all cursor-pointer" :to="{ name: 'shop' }">Books</RouterLink>
                    </li>
                    <!-- <li class=""><a class="text-white-600 hover:text-blue-600" href="#">Support</a></li> -->

                    <li class="sm:mt-0"><a class="btn btn-sm hover:bg-blue-600 hover:text-white" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="w-4 h-4 opacity-70">
                                <path
                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C15.09 3.81 16.76 3 18.5 3 21.58 3 24 5.42 24 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        </a>
                    </li>

                    <li class="group relative" v-if="authUser?.isAuthenticated">
                        <a href="#" class="flex items-center">
                            {{ authUser.user?.name }}
                        </a>
                        <ul class="absolute hidden p-2 rounded-lg bg-gray-800 mt-2 space-y-2">
                            <li><a class="hover:text-green-500 transition-all" href="#">Favorite List</a></li>
                            <li><a class="hover:text-green-500 transition-all cursor-pointer" @click="logout">Logout</a></li>
                        </ul>
                    </li>

                    <li v-else>
                        <RouterLink :to="{ name: 'admin.login' }" class="btn btn-sm">Login</RouterLink>
                    </li>
<!-- 
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
                    </li> -->
                    
                </ul>
            </nav>
        </div>
    </header>
</template>

<script setup>
import { RouterLink } from 'vue-router';
import useAuth from '@/store/auth'

const authUser = useAuth();

const logout = () => {
    authUser.logout();
}

</script>

<style>
/* Add more styling as needed */
.group:hover .absolute {
    display: block;
    width: 150px;
}
</style>