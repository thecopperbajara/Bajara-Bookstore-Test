<script setup>
import useAuthStore from '@/store/auth'

const authStore = useAuthStore();
</script>

<template>
    <div>
        <router-view />
    </div>
</template>
