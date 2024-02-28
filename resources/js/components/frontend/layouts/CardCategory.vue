<template>
    <div class="card bg-base-100 shadow-xl">
        <figure>
            <img :src='"/storage/category/" + image' :alt="name" />
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
