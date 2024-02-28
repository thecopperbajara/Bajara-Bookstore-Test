<template>
   <div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
         <div>
            <div class="card bg-base-100 shadow-xl">
               <div class="card-body">
                  <h2 class="card-title">Total Users</h2>
                  <p> Count Users</p>
               </div>
            </div>
         </div>
         <div>
            <div class="card bg-base-100 shadow-xl">
               <div class="card-body">
                  <h2 class="card-title">Total Category</h2>
                  <p> Count Category</p>
               </div>
            </div>
         </div>
      </div>

   </div>
</template>

<script setup>
import Sidebar from '../layouts/Sidebar.vue';
</script>
