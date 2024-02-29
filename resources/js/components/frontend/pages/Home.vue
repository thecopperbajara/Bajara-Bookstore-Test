<template>
    <Default />

    <Loader v-if="isLoading"  /> 
    <div v-else class="container mx-auto mt-5">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Categroy list
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-5 mb-5">
                <CardCategory v-for="category in categories" :key="category.id" :cat_id="category.id" :name="category.name"
                    :image="category.image" />
            </div>
        </div>

        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                Books list
            </h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <Cards v-for="product in products" :key="product.id" :prod_id="product.id" :title="product.title"
                    :category="product.category" :subcategory="product.subcategory" :image="product.image"
                    :buy_price="product.buy_price" :price="product.price" :author="product.author" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useToastr } from '@/toastr'
import useAxios from '@/services/axios'
import Loader from '@/services/Loader.vue';


const categories = ref([]);
const products = ref([]);
const isLoading = ref(false);

import Default from '../layouts/Default.vue';
import Cards from '../layouts/Cards.vue';
import CardCategory from '../layouts/CardCategory.vue';


onMounted(() => {
    fetchCategory();
    fetchProduct();

    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 2000);
});

const fetchCategory = async () => {
    await useAxios.get(`/user/category`).then((res) => {
        categories.value = res.data;
    }).catch((error) => {
        console.log('category', error);
    })
};

const fetchProduct = async () => {
    await useAxios.get(`/user/products`).then((res) => {
        products.value = res.data.data;
    }).catch((error) => {
        console.log('product', error);
    })
};

</script>
