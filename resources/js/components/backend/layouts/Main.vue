<template>
   <Sidebar />
   <div class="p-4 sm:ml-64">
      <router-view></router-view>
   </div>
</template>

<script setup>
import Sidebar from './Sidebar.vue';
</script>
