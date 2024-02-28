<template>
    <div class="card bg-base-100 shadow-xl card-bordered">
        <figure class="aspect-w-4 aspect-h-3">
            <img :src='"/storage/category/" + image' :alt="name" class="object-cover" :height="150" :width="200" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">{{ name }}</h2>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'
import { ref } from 'vue';

const { name, image } = defineProps(['name', 'image']);

</script>
