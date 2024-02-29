<template>
    <Default />
    <Loader v-if="isLoading" />
    <div v-else class="container mx-auto mb-5">

        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <div class="h-fit min-h-full flex ">
                <h2 class="text-xl font-bold text-gray-900 md:text-2xl dark:text-white">Books lists </h2>

                <p class="text-lg md:text-2xl pl-10"> {{ categoryType ? 'Filter by:' + categoryType + ', Name: ' +
                    categoryName : '' }} </p>

                <div class="h-fit min-h-full justify-end absolute right-20">

                    <ul class="menu bg-gray-400 lg:menu-horizontal rounded-box h-fit min-h-full ml-20">
                        <div class="group ">
                            <button data-ripple-light="true" data-popover-target="menu"
                                class="select-none text-black px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-gray-900/10 transition-all hover:underline hover:shadow-gray-900 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                Category
                            </button>
                            <ul role="menu" data-popover="menu" data-popover-placement="bottom"
                                class="absolute z-10 min-w-[180px] overflow-auto rounded-md border border-blue-gray-50 bg-white font-sans text-sm font-normal text-blue-gray-500 shadow-lg shadow-blue-gray-500/10 focus:outline-none opacity-0 group-hover:opacity-100 transition-opacity">
                                <li role="menuitem"
                                    class="block w-full cursor-pointer select-none rounded-md pt-[9px] text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900"
                                    v-for="category in categories" :key="category.id">
                                    <a class="hover:text-green-500 w-full transition-all cursor-pointer"
                                        @click="fetchProduct('category', category.id)">{{ category.name }}</a>
                                </li>
                            </ul>

                        </div>
                        <div class="group border-l-2 border-r-2 border-blue-900">
                            <button data-ripple-light="true" data-popover-target="menu"
                                class="select-none text-black px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-gray-900/10 transition-all hover:underline hover:shadow-gray-900 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                Author
                            </button>
                            <ul role="menu" data-popover="menu" data-popover-placement="bottom"
                                class="absolute z-10 min-w-[180px] overflow-auto rounded-md border border-blue-gray-50 bg-white font-sans text-sm font-normal text-blue-gray-500 shadow-lg shadow-blue-gray-500/10 focus:outline-none opacity-0 group-hover:opacity-100 transition-opacity">
                                <li role="menuitem"
                                    class="block w-full cursor-pointer select-none rounded-md pt-[9px] text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900"
                                    v-for="author in authors" :key="author.id">
                                    <a class="hover:text-green-500 w-full transition-all cursor-pointer"
                                        @click="fetchProduct('author', author.id)">{{ author.name }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="group">
                            <button data-ripple-light="true" data-popover-target="menu"
                                class="select-none text-black px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-gray-900/10 transition-all hover:underline hover:shadow-gray-900 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                                Price
                            </button>
                            <ul role="menu" data-popover="menu" data-popover-placement="bottom"
                                class="absolute z-10 min-w-[180px] overflow-auto rounded-md border border-blue-gray-50 bg-white font-sans text-sm font-normal text-blue-gray-500 shadow-lg shadow-blue-gray-500/10 focus:outline-none opacity-0 group-hover:opacity-100 transition-opacity">
                                <li role="menuitem"
                                    class="block w-full cursor-pointer select-none rounded-md pt-[9px] text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
                                    <a class="hover:text-green-500 w-full transition-all cursor-pointer"
                                        @click="fetchProduct('price', 'min')">Min To Max</a>
                                </li>
                                <li role="menuitem"
                                    class="block w-full cursor-pointer select-none rounded-md pt-[9px] text-start leading-tight transition-all hover:bg-blue-gray-50 hover:bg-opacity-80 hover:text-blue-gray-900 focus:bg-blue-gray-50 focus:bg-opacity-80 focus:text-blue-gray-900 active:bg-blue-gray-50 active:bg-opacity-80 active:text-blue-gray-900">
                                    <a class="hover:text-green-500 w-full transition-all cursor-pointer"
                                        @click="fetchProduct('price', 'max')">Max To Min</a>
                                </li>
                            </ul>
                        </div>

                    </ul>
                    <button @click="resetFilter" class="btn btn-sm btn-active hover:text-black-500 transition-all cursor-pointer ml-2">Reset</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" v-if="products.length > 0">
                <Cards v-for="product in products" :key="product.id" :prod_id="product.id" :title="product.title"
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

        if (type === 'category') {
            categoryName.value = response.data.data[0].category;
        } else if (type === 'author') {
            categoryName.value = response.data.data[0].author;
        } else {
            categoryName.value = id;
        }
        categoryType.value = type;

        // if (response.data.data.length > 0) {
        //     categoryName.value = response.data.data[0].category;
        // }
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

const resetFilter = () =>{
    fetchProduct();
}
</script>
