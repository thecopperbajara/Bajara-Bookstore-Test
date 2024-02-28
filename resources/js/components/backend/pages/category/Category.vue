<template>
    <div class="overflow-x-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Category Lists ({{ totalRecord }}) 
                        <label class="input input-bordered flex items-center gap-2">
                    <input type="text" class="grow" placeholder="Search" v-model="searchTerm" @input="searchCategory" />
                </label>
                <RouterLink :to="{ name: 'admin.addcategory' }" class="btn btn-sm btn-primary label-text-alt">Add New</RouterLink>
                </h2>
                
            </div>

            <table class="table table-bordered table-zebra">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody v-if="filterCategory.length > 0">
                    <tr v-for="category in filterCategory" :key="category.id">
                        <th>{{ category.id }}</th>
                        <td>{{ category.name }}</td>
                        <td>{{ category.slug }} </td>
                        <td> <img :src="'/storage/category/' + category.image" :height="70" :width="70" :alt="category.name">
                        </td>
                        <td>
                            <RouterLink :to='{ name: "admin.editCat", params: { id: category.id } }'
                                class="btn btn-sm btn-primary mr-1"> Edit </RouterLink>
                            <button class="btn btn-sm btn-neutral" @click="deleteCategory(category.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="5" align="center">No Data Found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useToastr } from '@/toastr'
import useToken from '@/services/token'
import { RouterLink } from 'vue-router';
import useAxios from '@/services/axios';

const toastr = useToastr();
const isLoading = ref(false);

const categories = ref([]);
const filterCategory = ref([]);
const searchTerm = ref('');
const totalRecord = ref(0);


onMounted(() => {
    fetchCategory();
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 1000);
});

const fetchCategory = async () => {
    await useAxios.get(`/admin/category`, { headers: { Authorization: "Bearer " + useToken().getToken() }, }).then((res) => {
        categories.value = res.data.data;
        filterCategory.value = categories.value;
        totalRecord.value = res.data.total;
    }).catch((error) => {
        console.log('category', error);
        filterCategory.value = [];
    })
}


const deleteCategory = async (id) => {
    if (confirm('Are you sure to delete?')) {
        await useAxios.delete(`/admin/category/${id}`, { headers: { Authorization: "Bearer " + useToken().getToken() }, }).then((res) => {
            if (res.data.success === true) {
                fetchCategory();
                toastr.success(res.data.message)
            }
        }).catch((error) => {
            console.log('del cat', error);
        })
    }
}

const searchCategory = () => {
    const searchTermLower = searchTerm.value.toLowerCase();
    filterCategory.value = categories.value.filter(user =>
        user.name.toLowerCase().includes(searchTermLower)
    );
}

</script>
