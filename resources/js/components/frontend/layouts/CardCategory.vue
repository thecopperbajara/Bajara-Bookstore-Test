<template>
    <RouterLink :to="{ name: 'user.category', params: { id: cat_id }}" class="card bg-base-100 shadow-xl card-bordered hover:text-black-500 hover:bg-zinc-200 hover:shadow-xxl transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-40">
        <figure class="aspect-w-4 aspect-h-3">
            <img :src='"/storage/category/" + image' :alt="name" class="object-cover" :height="150" :width="200" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">{{ name }}</h2>
        </div>
    </RouterLink>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue'
import { ref } from 'vue';

const { cat_id, name, image } = defineProps(['cat_id', 'name', 'image']);

</script>
