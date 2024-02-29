<template>
    <RouterLink :to="{ name: 'user.product', params: { id: prod_id }}" class="card bg-base-100 shadow-xl card-bordered hover:text-black-500 hover:bg-stone-100 hover:shadow-xxl transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-40">
        <figure class="aspect-w-4 aspect-h-3">
            <img :src='"/storage/product/" + image' :alt="title" class="object-cover" :height="150" :width="200" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">{{ title }}</h2>
            <h3>{{ category }}</h3>
            <h3>{{ subcategory }}</h3>
            <h3>Rs: {{ price }}</h3>
            <h4> Author: {{ author }}</h4>
            <div class="card-actions">
                <button v-if="!isInWishlist" class="btn btn-sm btn-accent" @click="addWish(prod_id)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 opacity-70">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C15.09 3.81 16.76 3 18.5 3 21.58 3 24 5.42 24 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </button>
                <button v-else class="btn btn-sm btn-neutral" @click="removeWish(prod_id)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 opacity-70">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C15.09 3.81 16.76 3 18.5 3 21.58 3 24 5.42 24 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </button>

                <!-- <button class="btn btn-sm btn-accent" @click="addWish(id)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 opacity-70">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C15.09 3.81 16.76 3 18.5 3 21.58 3 24 5.42 24 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </button> -->
            </div>
        </div>
    </RouterLink>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { defineProps, defineEmits } from 'vue'
import useAxios from '@/services/axios';
import useAuthStore from '@/store/auth'
import { useToastr } from '@/toastr'
import useToken from '@/services/token'
import router from '@/router';

const userAuth = useAuthStore();
const toastr = useToastr();
const isInWishlist = ref(false);

const { prod_id, title, category, subcategory, image, buy_price, price, author } = defineProps(['prod_id', 'title', 'category', 'subcategory', 'image', 'buy_price', 'price', 'author']);

const emit = defineEmits();


onMounted(() => {
    if (userAuth.isAuthenticated) {
        fetchIsInWishlist(prod_id);
    }
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

const addWish = async (bookId) => {
    if (!userAuth.isAuthenticated) {
        router.push({ name: 'admin.login' });
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

        // const userId = userAuth.user.id;
        // await useAxios.post(`/user/addFavorite`, { userId, bookId }, { headers: { Authorization: "Bearer " + useToken().getToken() }, }).then((res) => {
        //     toastr.success(res.data.message)
        // }).catch((error) => {
        //     console.log('product', error);
        // })
    }
};


const removeWish = async (bookId) => {
    if (!userAuth.isAuthenticated) {
        router.push('/admin/login')
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
