<template>
    <Loader v-if="isLoading" />
    <div v-else class="overflow-x-auto">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Users Lists ({{ totalRecord }}) 
                        <label class="input input-bordered flex items-center gap-2">
                    <input type="text" class="grow" placeholder="Search" v-model="searchTerm" @input="searchUser" />
                </label>
                <RouterLink :to="{ name: 'admin.adduser' }" class="btn btn-sm btn-primary">Add New</RouterLink>
                </h2>
                
            </div>

            <table class="table table-bordered table-zebra">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody v-if="filterUser.length > 0">
                    <tr v-for="user in filterUser" :key="user.id">
                        <th>{{ user.id }}</th>
                        <td>{{ user.name }}</td>
                        <td>{{ user.username }} </td>
                        <td> {{ user.email }}</td>
                        <td> {{ user.role }}</td>
                        <td>
                            <RouterLink :to='{ name: "admin.userEdit", params: { id: user.id } }'
                                class="btn btn-sm btn-primary mr-1"> Edit </RouterLink>
                            <button class="btn btn-sm btn-neutral" @click="deleteUser(user.id)">Delete</button>
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
import useAlert from '@/services/alert';
import Loader from '@/services/Loader.vue';

const toastr = useToastr();
const isLoading = ref(false);

const users = ref([]);
const filterUser = ref([]);
const searchTerm = ref('');
const totalRecord = ref(0);


onMounted(() => {
    fetchUsers();
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 1000);
});

const fetchUsers = async () => {
    await useAxios.get(`/admin/users`, { headers: { Authorization: "Bearer " + useToken().getToken() }, }).then((res) => {
        users.value = res.data.data;
        filterUser.value = users.value;
        totalRecord.value = res.data.meta.total;
    }).catch((error) => {
        filterUser.value = [];
    })
}


const deleteUser = async (id) => {
    const result = await useAlert().centerMessageAlert("warning");

    if (result.isConfirmed) {
        await useAxios.delete(`/admin/users/${id}`, { headers: { Authorization: "Bearer " + useToken().getToken() }, }).then((res) => {
            if (res.data.success === true) {
                fetchUsers();
                toastr.success(res.data.message)
            }
        }).catch((error) => {
            console.log('del user', error);
        })
    }
}

const searchUser = () => {
    const searchTermLower = searchTerm.value.toLowerCase();
    filterUser.value = users.value.filter(user =>
        user.name.toLowerCase().includes(searchTermLower) ||
        user.username.toLowerCase().includes(searchTermLower) ||
        user.role.toLowerCase().includes(searchTermLower)
    );
}

</script>
