<template>
    <div class="card bg-base-100 shadow-xl">
        <figure>
            <img :src='"/storage/product/" + image' :alt="title" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">{{ title }}</h2>
            <p>{{ category }}</p>
            <p>{{ subcategory }}</p>
            <p>Rs: {{ price }}</p>
            <p> Author: {{ author }}</p>
            <div class="card-actions justify-end">
                <button class="btn btn-sm btn-primary">Buy Now</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { defineProps, defineEmits } from 'vue'

const { id, title, category, subcategory, image, buy_price, price, author } = defineProps(['id', 'title', 'category', 'subcategory', 'image', 'buy_price', 'price', 'author']);
</script>
