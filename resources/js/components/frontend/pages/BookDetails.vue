<template>
    <Default />
    <Loader v-if="isLoading" />
    <div v-else class="bg-white" v-for="book in products" :key="book.id">
        <div
            class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8  px-4 py-24 sm:px-6 sm:py-32 lg:max-w-7xl lg:grid-cols-2 lg:px-8">
            <div>
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ book.title }}</h2>

                <h3 class="font-medium text-gray-600">Category: {{ book.category }}</h3>
                <h3 class="font-medium text-gray-600">subcategory: {{ book.subcategory }}</h3>
                <h3 class="font-medium text-gray-600">$ {{ book.price }}</h3>
                <h4 class="font-medium text-gray-600"> Author: {{ book.author }}</h4>

                <p class="mt-4 text-gray-500">Description: {{ book.description }}</p>

                <div class="flex flex-col sm:flex-row sm:space-x-4 sm:px-0 mt-3">
                    <button v-if="!isInWishlist" class="btn btn-sm btn-accent transition hover:translate-y-1 hover:bg-white" @click="addWish(book.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 opacity-70">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C15.09 3.81 16.76 3 18.5 3 21.58 3 24 5.42 24 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </button>
                <button v-else class="btn btn-sm btn-neutral transition hover:translate-y-1 hover:bg-white" @click="removeWish(book.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 opacity-70">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C15.09 3.81 16.76 3 18.5 3 21.58 3 24 5.42 24 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </button>


                <!-- <button class="mt-4 flex items-center rounded-lg border-2 border-blue-600 px-6 py-2 font-medium text-blue-600 transition hover:translate-y-1 hover:bg-white" @click="addWish(book.id)">Add Wishlist </button> -->
                  </div>
       
            </div>
            <div class="grid grid-cols-2 grid-rows-2 gap-4 sm:gap-6 lg:gap-8">
                <img :src="'/storage/product/'+ book.image" :alt="book.title" class="rounded-lg bg-gray-100">
            </div>
        </div>
    </div>
</template>
  
<script setup>
import Default from '../layouts/Default.vue';
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import useAxios from '@/services/axios'
import {useToastr} from '@/services/toastr';
import Loader from '@/services/Loader.vue';
import useAuthStore from '@/store/auth'
import Routers from '@/router';
import useToken from '@/services/token'

const router = useRoute();
const userAuth = useAuthStore();
const toastr = useToastr();

const isLoading = ref(false);
const products = ref([]);
const isInWishlist = ref(false);

onMounted(() => {
    if (router.params.id) {
        const product_id = router.params.id;
        fetchProduct('product_id', product_id);
    }

    if (userAuth.isAuthenticated) {
        fetchIsInWishlist(router.params.id);
    }

    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 2000);
});

const fetchIsInWishlist = async (bookId) => {
    try {
        const response = await useAxios.get(`/user/isInWishlist/${bookId}`, {
            headers: { Authorization: "Bearer " + useToken().getToken() },
        });
        if (response.data.isInWishlist) {
            isInWishlist.value = true;
        }
    } catch (error) {
        console.error('Error checking wishlist:', error);
    }
};

const fetchProduct = async (type, id) => {
    try {
        const params = { [type]: id };
        const response = await useAxios.get(`/user/productById`, { params });

        products.value = response.data.data;
    } catch (error) {
        console.error('Error fetching products:', error);
    }
};

const addWish = async (bookId) => {
    if (!userAuth.isAuthenticated) {
        Routers.push('/admin/login')
        toastr.error('Need to Login First.')
    } else {
        const userId = userAuth.user.id;

        await useAxios.post(`/user/addFavorite`, { userId, bookId }, {
            headers: { Authorization: "Bearer " + useToken().getToken() },
        }).then((res) => {
            fetchIsInWishlist(bookId);
            toastr.success(res.data.message);
        }).catch((error) => {
            console.log('product', error);
        });
    }
};

const removeWish = async (bookId) => {
    if (!userAuth.isAuthenticated) {
        Routers.push('/admin/login')
        toastr.error('Need to Login First.')
    } else {
        const userId = userAuth.user.id;
        await useAxios.post(`/user/removeFromFavorites`, { userId, bookId }, {
            headers: { Authorization: "Bearer " + useToken().getToken() },
        }).then((res) => {
            isInWishlist.value = false;
            toastr.success(res.data.message);
        }).catch((error) => {
            console.log('product', error);
        });
    }
};

</script>
  
<style lang="scss" scoped></style>