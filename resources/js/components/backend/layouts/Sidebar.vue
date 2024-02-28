<template>
   <aside id="logo-sidebar"
      class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
      aria-label="Sidebar">

      <ul class="menu bg-base-200 h-100">
         <!-- <li><RouterLink :to="{name: 'homepage'}" >Home</RouterLink></li> -->
         <li><RouterLink :to="{name: 'dashboard'}">Dashboard</RouterLink></li>
         <li><RouterLink :to="{ name:'admin.category' }" >Category</RouterLink></li>
         <li><RouterLink :to="{ name: 'admin.subcategory' }" >SubCategory</RouterLink></li>
         <li><RouterLink :to="{ name: 'admin.product' }">Books</RouterLink></li>
         <li><a @click="logout()" class="btn btn-sm btn-neutral mt-8">Logout</a></li>
      </ul>
   </aside>

</template>