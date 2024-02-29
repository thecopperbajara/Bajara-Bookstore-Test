<template>
    <Default />
    <Loader v-if="isLoading" />
    <div v-else class="container mx-auto mb-5">

        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <div class="h-fit min-h-full flex ">
                <h2 class="text-xl font-bold text-gray-900 md:text-2xl dark:text-white">Books in Category Type:{{ categoryType }} , Filter {{ categoryName
                }}</h2>
                <div class="h-fit min-h-full justify-end">
                    <!-- <h1 class="text-xl font-bold text-gray-900 md:text-2xl dark:text-white"> Filter Books </h1> -->
                    <ul class="menu bg-base-200 lg:menu-horizontal rounded-box h-fit min-h-full ">
                        <li>
                            <details>
                                <summary>Category</summary>
                                <ul :style="{ 'z-index': 1 }">
                                    <li v-for="category in categories" :key="category.id"><a
                                            @click="fetchProduct('category', category.id)">{{ category.name }}</a></li>
                                </ul>
                            </details>
                        </li>
                        <li>
                            <details>
                                <summary>Author</summary>
                                <ul :style="{ 'z-index': 1 }">
                                    <li v-for="author in authors" :key="author.id"><a
                                            @click="fetchProduct('author', author.id)">{{ author.name }}</a></li>
                                </ul>
                            </details>
                        </li>
                        <li>
                            <details>
                                <summary>Price</summary>
                                <ul :style="{ 'z-index': 1 }">
                                    <li><a @click="fetchProduct('price', 'min')">Min to Max</a></li>
                                    <li><a @click="fetchProduct('price', 'max')">Max to Min</a></li>
                                </ul>
                            </details>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" v-if="products.length > 0">
                <Cards v-for="product in products" :key="product.id" :id="product.id" :title="product.title"
                    :category="product.category" :subcategory="product.subcategory" :image="product.image"
                    :buy_price="product.buy_price" :price="product.price" :author="product.author" />
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" v-else>
                No Matching data found.
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import useAxios from '@/services/axios'
import Loader from '@/services/Loader.vue';

const router = useRoute();

const products = ref([]);
const isLoading = ref(false);
const categories = ref([]);
const authors = ref([]);

const categoryType = ref('');
const categoryName = ref('');

import Default from '../layouts/Default.vue';
import Cards from '../layouts/Cards.vue';


onMounted(() => {
    fetchProduct();
    fetchCategory();
    fetchAuthor();

    if (router.params.id) {
        const categoryId = router.params.id;
        fetchProduct('category', categoryId);
    }

    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 2000);
});

const fetchProduct = async (type, id) => {
    try {
        const params = { [type]: id };
        const response = await useAxios.get(`/user/products`, { params });

        if (response.data.data.length > 0) {
            categoryType.value = type;
            categoryName.value = response.data.data[0].category;
        }
        products.value = response.data.data;
    } catch (error) {
        console.error('Error fetching products:', error);
    }
};

const fetchCategory = async () => {
    try {
        const response = await useAxios.get(`/user/category`);
        categories.value = response.data;
    } catch (error) {
        console.error('Error', error);
    }
};

const fetchAuthor = async () => {
    try {
        const response = await useAxios.get(`/user/authors`);
        authors.value = response.data;
    } catch (error) {
        console.error('Error', error);
    }
}
</script>
