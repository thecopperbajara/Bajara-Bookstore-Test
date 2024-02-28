<template>
     <div class="overflow-x-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Subcategory Lists ({{ totalRecord }})
                        <label class="input input-bordered flex items-center gap-2">
                    <input type="text" class="grow" placeholder="Search" v-model="searchTerm" @input="searchCategory" />
                </label>
                <RouterLink :to="{ name: 'admin.addsubcategory' }" class="btn btn-sm btn-primary label-text-alt">Add New</RouterLink>
                </h2>
                
            </div>

            <table class="table table-bordered table-zebra">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody v-if="filterSubcategory.length > 0">
                    <tr v-for="subcat in filterSubcategory" :key="subcat.id">
                        <th>{{ subcat.id }}</th>
                        <td>{{ subcat.name }}</td>
                        <td>{{ subcat.slug }} </td>
                        <td>{{ subcat.category }} </td>
                        <td> <img :src="'/storage/subcategory/' + subcat.image" :height="70" :width="70" :alt="subcat.name">
                        </td>
                        <td>
                            <RouterLink :to='{ name: "admin.editsubcategory", params: { id: subcat.id } }'
                                class="btn btn-sm btn-primary mr-1"> Edit </RouterLink>
                            <button class="btn btn-sm btn-neutral" @click="deleteSubcategory(subcat.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="6" align="center">No Data Found</td>
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

const subcategories = ref([]);
const filterSubcategory = ref([]);
const searchTerm = ref('');
const totalRecord = ref(0);


onMounted(() => {
    fetchSubcategory();
})

const fetchSubcategory = async () => {
    await useAxios.get(`/admin/subcategory`, { headers: { Authorization: "Bearer " + useToken().getToken() }, }).then((res) => {
        subcategories.value = res.data.data;
        filterSubcategory.value = subcategories.value;
        totalRecord.value = res.data.meta.total;
    }).catch((error) => {
        console.log('subcategory', error);
        filterSubcategory.value = [];
    })
}


const deleteSubcategory = async (id) => {
    if (confirm('Are you sure to delete?')) {
        await useAxios.delete(`/admin/subcategory/${id}`, { headers: { Authorization: "Bearer " + useToken().getToken() }, }).then((res) => {
            if (res.data.success === true) {
                fetchSubcategory();
                toastr.success(res.data.message)
            }
        }).catch((error) => {
            console.log('del subcat', error);
        })
    }
}

const searchCategory = () => {
    const searchTermLower = searchTerm.value.toLowerCase();
    filterSubcategory.value = subcategories.value.filter(user =>
        user.name.toLowerCase().includes(searchTermLower)
    );
}

</script>