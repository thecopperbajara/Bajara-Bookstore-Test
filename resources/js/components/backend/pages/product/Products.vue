<template>
    <Loader v-if="isLoading" />
    <div v-else class="overflow-x-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Books Lists ({{ totalRecord }})
                    <label class="input input-bordered flex items-center gap-2">
                        <input type="text" class="grow" placeholder="Search" v-model="searchTerm" @input="searchProduct" />
                    </label>
                    <RouterLink :to="{ name: 'admin.addProduct' }" class="btn btn-sm btn-primary">Add New
                    </RouterLink>
                </h2>
            </div>

            <table class="table table-bordered table-zebra">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Price</th>
                        <th>Author</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody v-if="filterProducts.length > 0">
                    <tr v-for="(product, key) in filterProducts" :key="key">
                        <td>{{ product.id }}</td>
                        <td>{{ product.title }}</td>
                        <td>{{ product.category }}</td>
                        <td>{{ product.subcategory }}</td>
                        <td>{{ product.price }}</td>
                        <td> {{ product.author }}</td>
                        <td> <img :src="'/storage/product/' + product.image" :height="70" :width="70" :alt="product.name" />
                        </td>
                        <td>
                            <RouterLink :to='{ name: "admin.editProduct", params: { id: product.id } }'
                                class="btn btn-sm btn-primary mr-1"> Edit </RouterLink>
                            <button class="btn btn-sm btn-neutral" @click="deleteProduct(product.id)">Delete</button>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="7" align="center">No Data Found</td>
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
import Loader from '@/services/Loader.vue';

const toastr = useToastr();
const isLoading = ref(false);

const products = ref([]);
const filterProducts = ref([]);
const searchTerm = ref('');
const totalRecord = ref(0);


onMounted(() => {
    fetchProducts();

    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 1000);
})

const fetchProducts = async () => {
    await useAxios.get(`/admin/products`, { headers: { Authorization: "Bearer " + useToken().getToken() }, }).then((res) => {
        products.value = res.data.data;
        filterProducts.value = products.value;
        totalRecord.value = res.data.meta.total;
    }).catch((error) => {
        console.log('subcategory', error);
        filterProducts.value = [];
    })
}


const deleteProduct = async (id) => {
    if (confirm('Are you sure to delete?')) {
        await useAxios.delete(`/admin/products/${id}`, { headers: { Authorization: "Bearer " + useToken().getToken() }, }).then((res) => {
            if (res.data.success === true) {
                fetchProducts();
                toastr.success(res.data.message)
            }
        }).catch((error) => {
            console.log('del product', error);
        })
    }
};

const searchProduct = () => {
    const searchTermLower = searchTerm.value.toLowerCase();
    filterProducts.value = products.value.filter(user =>
        user.title.toLowerCase().includes(searchTermLower) ||
        user.category.toLowerCase().includes(searchTermLower)
    );
};

</script>