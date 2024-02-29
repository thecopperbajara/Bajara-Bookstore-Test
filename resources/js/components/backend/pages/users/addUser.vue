<template>
    <Loader v-if="isLoading" />
    <div v-else class="card bg-base-100 shadow-xl card-bordered">
        <div class="card-body">
            <h2 class="card-title"> {{ isEditMode ? 'Edit' : 'Add New' }} User <RouterLink :to="{ name: 'admin.users' }"
                    class="btn btn-sm btn-primary">Back</RouterLink>
            </h2>

            <form @submit.prevent="saveForm" class="space-y-4 md:space-y-6" method="post">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <div>
                        <div class="label"><span class="label-text">Name</span></div>
                        <input type="text" v-model="form.name" class="input input-bordered input-md w-full"
                            placeholder="User name" />
                        <div class="text-danger">{{ errors.name ? errors.name[0] : '' }}</div>
                    </div>
                    <div>
                        <div class="label"><span class="label-text">Username</span></div>
                        <input type="text" v-model="form.username" class="input input-bordered input-md w-full"
                            placeholder="User username" />
                        <div class="text-danger">{{ errors.username ? errors.username[0] : '' }}</div>
                    </div>

                    <div>
                        <div class="label"><span class="label-text">Email</span></div>
                        <input type="email" v-model="form.email" class="input input-bordered input-md w-full"
                            placeholder="User email" />
                        <div class="text-danger">{{ errors.email ? errors.email[0] : '' }}</div>
                    </div>
                    <div v-if="!isEditMode">
                        <div class="label"><span class="label-text">Password</span></div>
                        <input type="password" v-model="form.password" class="input input-bordered input-md w-full"
                            placeholder="User password" />
                        <div class="text-danger">{{ errors.password ? errors.password[0] : '' }}</div>
                    </div>


                    <div>
                        <div class="label"><span class="label-text">Role</span></div>
                        <input type="text" class="input input-bordered w-full" v-model="searchTerm" @input="filterRoles"
                            placeholder="Search for a role" @focus="openDropdown" @blur="closeDropdown" />
                        <div v-if="isDropdownOpen && filteredRoles.length > 0">
                            <ul class="dropdown">
                                <li v-for="role in filteredRoles" :key="role.id" @mousedown="selectRole(role)">
                                    {{ role.name }}
                                </li>
                            </ul>
                        </div>
                        <div v-if="isDropdownOpen && filteredRoles.length === 0" class="text-danger">
                            No matching found.
                        </div>
                        <div class="text-danger" v-else>{{ errors.role_id ? errors.role_id[0] : '' }}</div>
                    </div>

                </div>


                <button type="submit" class="btn btn-sm btn-active btn-primary">{{ isEditMode ? 'Update' : 'Save'
                }}</button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import Routers from '@/router'
import useAxios from '@/services/axios'
import useToken from '@/services/token'
import { useToastr } from '@/services/toastr'
import Loader from '@/services/Loader.vue'

const form = ref({
    name: '',
    username: '',
    email: '',
    password: '',
    role_id: ''
});

const searchTerm = ref('');
const roles = ref([]);
const filteredRoles = ref([]);
const isDropdownOpen = ref(false);

const errors = ref('');
const isEditMode = ref(false);
const router = useRoute();
const toastr = useToastr();
const isLoading = ref(false);


onMounted(() => {
    fetchRoles();
    isEditMode.value = router.params.id !== undefined;
    if (isEditMode.value) {
        editUser(router.params.id);
    }

    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 1000);
});

const fetchRoles = () => {
    useAxios.get(`/admin/fetchRoles`, {
        headers: { Authorization: 'Bearer ' + useToken().getToken() }
    }).then((res) => {
        roles.value = res.data
        filteredRoles.value = roles.value
    }).catch(error => {
        console.log(error)
    })
};


const openDropdown = () => {
    isDropdownOpen.value = true;
};

const closeDropdown = () => {
    isDropdownOpen.value = false;
};

const selectRole = (role) => {
    console.log('role', role.id);
    form.value.role_id = role.id;
    searchTerm.value = role.name;
    isDropdownOpen.value = false;
};
const filterRoles = () => {
    filteredRoles.value = roles.value.filter((role) =>
        role.name.toLowerCase().includes(searchTerm.value.toLowerCase())
    );
};


const editUser = () => {
    useAxios.get(`/admin/users/${router.params.id}`, {
        headers: { Authorization: 'Bearer ' + useToken().getToken() }
    }).then(response => {
        form.value = { ...response.data };

        const selectedRole = roles.value.find(role => role.id === response.data.role_id);
        if (selectedRole) {
            searchTerm.value = selectedRole.name;
            filterRoles();
        }
    }).catch(error => {
        console.log(error)
    })
};

const saveForm = async () => {
    errors.value = '';
    if (isEditMode.value) {
        await useAxios.post(`/admin/users/${router.params.id}`, form.value, {
            headers: { Authorization: 'Bearer ' + useToken().getToken() }
        }).then((resp) => {
            if (resp.data.success === true) {
                Routers.push({ name: "admin.users" })
                toastr.success(resp.data.message)
            } else {
                errors.value = resp.data.message
            }
        }).catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        })
    } else {
        await useAxios.post('/admin/users', form.value, {
            headers: { Authorization: 'Bearer ' + useToken().getToken() }
        }).then(resp => {
            if (resp.data.success === true) {
                Routers.push({ name: "admin.users" })
                toastr.success(resp.data.message)
            } else {
                errors.value = resp.data.message
            }
        }).catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error(error);
            }
        })
    }
};

</script>


<style scoped>
.dropdown {
    list-style: none;
    padding: 0;
    margin: 0;
    border: 1px solid #f0f0f0;
    border-radius: 7%;
    position: absolute;
    background: #fff;
}

.dropdown li {
    padding: 6px;
    width: 250px;
    cursor: pointer;
    border-bottom: 1px solid #ccc;
}

.dropdown li:last-child {
    border-bottom: none;
}

.dropdown li:hover {
    background-color: #f0f0f0;
}</style>