<template>
    <Default />
    <div class="container mx-auto mt-5">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-5 mb-5">
            <CardCategory v-for="category in categories" :key="category.id" :id="category.id" :name="category.name" :image="category.image" />
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <Cards v-for="product in products" :key="product.id" :id="product.id" :title="product.title" :category="product.category" :subcategory="product.subcategory" :image="product.image" :buy_price="product.buy_price" :price="product.price" :author="product.author" />
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useToastr } from '@/toastr'
import useAxios from '@/services/axios'


const categories = ref([]);
const products = ref([]);

import Default from '../layouts/Default.vue';
import Cards from '../layouts/Cards.vue';
import CardCategory from '../layouts/CardCategory.vue';


onMounted(()=>{
    fetchCategory();
    fetchProduct();
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
