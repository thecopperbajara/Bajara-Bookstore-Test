<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Login your account
                    </h1>

                    <div v-if="authStore.errorData" class="alert alert-danger" role="alert">
                        <ul>
                            <li v-for="key in authStore.errorData" :key="key">{{ key[0] }}</li>
                        </ul>
                    </div>

                    <form class="space-y-4 md:space-y-6" action="javascript:void(0)" method="post">
                        <div>
                            <label class="input input-bordered flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="w-4 h-4 opacity-70">
                                    <path
                                        d="M2.5 3A1.5 1.5 0 0 0 1 4.5v.793c.026.009.051.02.076.032L7.674 8.51c.206.1.446.1.652 0l6.598-3.185A.755.755 0 0 1 15 5.293V4.5A1.5 1.5 0 0 0 13.5 3h-11Z" />
                                    <path
                                        d="M15 6.954 8.978 9.86a2.25 2.25 0 0 1-1.956 0L1 6.954V11.5A1.5 1.5 0 0 0 2.5 13h11a1.5 1.5 0 0 0 1.5-1.5V6.954Z" />
                                </svg>
                                <input type="email" v-model="form.email" class="grow" placeholder="Email" />
                            </label>

                        </div>
                        <div>
                            <label class="input input-bordered flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                    class="w-4 h-4 opacity-70">
                                    <path fill-rule="evenodd"
                                        d="M14 6a4 4 0 0 1-4.899 3.899l-1.955 1.955a.5.5 0 0 1-.353.146H5v1.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-2.293a.5.5 0 0 1 .146-.353l3.955-3.955A4 4 0 1 1 14 6Zm-4-2a.75.75 0 0 0 0 1.5.5.5 0 0 1 .5.5.75.75 0 0 0 1.5 0 2 2 0 0 0-2-2Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <input type="password" v-model="form.password" class="grow" placeholder="******"/>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="remember" v-model="form.remember" aria-describedby="remember" type="checkbox"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
                                </div>
                            </div>
                            <a href="#"
                                class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot
                                password?</a>
                        </div>
                        <button type="submit" class="btn btn-sm btn-active btn-primary" :disabled="processing" @click="login">{{ processing ? "Please wait" : "Login" }}</button>
                    </form>

                    <div class="flex items-center justify-between">
                        Dont have Account?
                        <RouterLink :to="{name: 'register'}" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Register</RouterLink>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import useAuth from '@/store/auth'
import { ref } from 'vue';
import router from '@/router'

const authStore = useAuth();

const form = ref({
    email: '',
    password: '',
    remember: '',
    accessToken: null,
});

const validationErrors = ref({});
const processing = ref(false);

const login = async () => {
    validationErrors.value = {};
    processing.value = true

    try {
        authStore.login(form.value)
    } catch (error) {
        console.log('error', authStore.errorData);
        if (error.response && error.response.status === 422) {
            validationErrors.value = Object.values(error.response.data.message).flat();
        } else {
            validationErrors.value = {};
            alert(error.response);
        }
    } finally {
        processing.value = false;
    }
}

</script>