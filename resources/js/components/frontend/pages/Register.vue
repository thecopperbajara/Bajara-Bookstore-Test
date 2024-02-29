<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div
                class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Create your account
                    </h1>

                    <form class="space-y-2 md:space-y-2" @submit.prevent="saveForm" method="post">
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                            <div class="mt-2">
                                <input v-model="form.name" type="text" autocomplete="email"  class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div class="text-danger">{{ errors.name ? errors.name[0] : '' }}</div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Username</label>
                            <div class="mt-2">
                                <input v-model="form.username" type="text" autocomplete="email"  class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div class="text-danger">{{ errors.username ? errors.username[0] : '' }}</div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                            <div class="mt-2">
                                <input v-model="form.email" type="email" autocomplete="email"  class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div class="text-danger">{{ errors.email ? errors.email[0] : '' }}</div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                            <div class="mt-2">
                                <input v-model="form.password" type="password" autocomplete="email"  class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div class="text-danger">{{ errors.password ? errors.password[0] : '' }}</div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</label>
                            <div class="mt-2">
                                <input v-model="form.password_confirm" type="password" autocomplete="email"  class="pl-2 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                            <div class="text-danger">{{ errors.password_confirm ? errors.password_confirm[0] : '' }}</div>
                        </div>

                        <button type="submit" class="mt-6 flex items-center rounded-lg border-2 bg-blue-600 text-white border-blue-600 px-6 py-2 font-medium text-blue-600 transition hover:translate-y-1 hover:bg-blue"
                            >{{ processing ? "Please wait" : "Create" }}</button>
                    </form>

                    <div class="flex items-center justify-between">
                        Already have Account?
                        <RouterLink :to="{ name: 'admin.login' }"
                            class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Login
                        </RouterLink>
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
import useAxios from '@/services/axios'

const authStore = useAuth();

const form = ref({
    name: '',
    username: '',
    email: '',
    password: '',
    password_confirm:''
});

const errors = ref({});
const processing = ref(false);

const saveForm = async () => {
    errors.value = '';
    processing.value = true

    await useAxios.post('/user/register', form.value).then(resp => {
        if (resp.data.success === true) {
            router.push({ name: "admin.login" })
            toastr.success(resp.data.message)
            processing.value = false;
        } else {
            errors.value = resp.data.message
        }
    }).catch((error) => {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            console.error(error);
        }
    })
}

</script>