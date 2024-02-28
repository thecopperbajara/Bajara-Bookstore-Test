<template>
    <div class="card bg-base-100 shadow-xl card-bordered">        
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
                <button class="btn btn-sm btn-accent" @click="addWish(id)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="w-4 h-4 opacity-70">
                        <path
                            d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C15.09 3.81 16.76 3 18.5 3 21.58 3 24 5.42 24 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { defineProps, defineEmits } from 'vue'

const { id, title, category, subcategory, image, buy_price, price, author } = defineProps(['id', 'title', 'category', 'subcategory', 'image', 'buy_price', 'price', 'author']);

const emit = defineEmits();

const addWish = (id) => {
    console.log('prod', id);
    // emit('page-change', currentPage.value - 1);
};

</script>
