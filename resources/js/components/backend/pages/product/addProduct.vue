<template>
    <Loader v-if="isLoading" />
    <div v-else class="card bg-base-100 shadow-xl card-bordered">
        <div class="card-body">
            <h2 class="card-title"> {{ isEditMode ? 'Edit' : 'Add New' }} Book <RouterLink :to="{ name: 'admin.product' }"
                    class="btn btn-sm btn-primary">Back</RouterLink>
            </h2>

            <form @submit.prevent="saveForm" class="space-y-4 md:space-y-6" method="post">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-2 gap-4">
                    <div>
                        <div class="label"><span class="label-text">Book Title</span></div>
                        <label class="input input-bordered flex items-center gap-2">
                            <input type="text" v-model="form.title" class="grow" placeholder="Book Title" />
                        </label>
                        <div class="text-danger">{{ errors.title ? errors.title[0] : '' }}</div>
                    </div>


                    <div>
                        <div class="label"><span class="label-text">Category</span></div>
                        <input type="text" class="input input-bordered w-full" v-model="searchTerm" @input="filterCategory"
                            placeholder="Search for a Category" @focus="openDropdown" @blur="closeDropdown" />
                        <div v-if="isDropdownOpen && filteredCategory.length > 0">
                            <ul class="dropdown">
                                <li v-for="cat in filteredCategory" :key="cat.id" @mousedown="selectCategory(cat)">
                                    {{ cat.name }}
                                </li>
                            </ul>
                        </div>
                        <div v-if="isDropdownOpen && filteredCategory.length === 0" class="text-danger">
                            No matching found.
                        </div>
                        <div v-else class="text-danger">{{ errors.role_id ? errors.role_id[0] : '' }}</div>
                    </div>

                    <!-- <div>
                        <div class="label"><span class="label-text">Category</span></div>
                        <select class="select select-bordered w-full" v-model="form.category_id"
                            @change="fetchSubcategoies($event.target.value)">
                            <option>Select Category</option>
                            <option v-for="cat in categories" :key="cat.id" :value="cat.id"
                                :selected="form.category_id == cat.id">{{ cat.name }}</option>
                        </select>
                        <div class="text-danger">{{ errors.category_id ? errors.category_id[0] : '' }}</div>
                    </div> -->
                    <div>
                        <div class="label"><span class="label-text">Subcategory</span></div>
                        <select class="select select-bordered w-full" v-model="form.subcategory_id">
                            <option value="" disabled>Select Subcategory</option>
                            <option v-for="subcat in subcategories" :key="subcat.id" :value="subcat.id"
                                :selected="form.subcategory_id == subcat.id">{{ subcat.name }}
                            </option>
                        </select>
                        <div class="text-danger">{{ errors.subcategory_id ? errors.subcategory_id[0] : '' }}</div>
                    </div>

                    <div>
                        <div class="label"><span class="label-text">Buy Price</span></div>
                        <label class="input input-bordered flex items-center gap-2">
                            <input type="number" v-model="form.buy_price" class="grow" placeholder="Book buy price" />
                        </label>
                        <div class="text-danger">{{ errors.buy_price ? errors.buy_price[0] : '' }}</div>
                    </div>
                    <div>
                        <div class="label"><span class="label-text">Sell Price</span></div>
                        <label class="input input-bordered flex items-center gap-2">
                            <input type="number" v-model="form.price" class="grow" placeholder="Book sell price" />
                        </label>
                        <div class="text-danger">{{ errors.price ? errors.price[0] : '' }}</div>
                    </div>
                    <div>
                        <div class="label"><span class="label-text">Quantity (SKU)</span></div>
                        <label class="input input-bordered flex items-center gap-2">
                            <input type="number" v-model="form.sku" class="grow" placeholder="Book sku" />
                        </label>
                        <div class="text-danger">{{ errors.sku ? errors.sku[0] : '' }}</div>
                    </div>
                    <div>
                        <div class="label"><span class="label-text">Description</span></div>
                        <textarea class="textarea textarea-bordered w-full" v-model="form.description"
                            placeholder="Description" />
                        <div class="text-danger">{{ errors.description ? errors.description[0] : '' }}</div>
                    </div>

                    <div>
                        <div class="label"><span class="label-text">Author</span></div>
                        <select class="select select-bordered w-full" v-model="form.user_id">
                            <option>Select Auther</option>
                            <option v-for="user in authors" :key="user.id" :value="user.id"
                                :selected="form.user_id == user.id">
                                {{ user.name }}</option>
                        </select>
                        <div class="text-danger">{{ errors.user_id ? errors.user_id[0] : '' }}</div>
                    </div>


                    <div>
                        <div class="label"><span class="label-text"> Image</span></div>
                        <input type="file" class="file-input file-input-bordered w-full max-w-xs"
                            @change="handleImageUpload" accept="image/jpeg" />
                        <img v-if="isEditMode" :src="'/storage/product/' + form.image" width="100" height="100" />
                        <img v-if="imagePreview" :src="imagePreview" width="100" height="100" />

                        <div class="text-danger">{{ errors.image ? errors.image[0] : '' }}</div>
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
    title: '',
    category_id: '',
    subcategory_id: '',
    buy_price: '',
    price: '',
    sku: '',
    description: '',
    user_id: '',
    image: null,
});

const isLoading = ref(false);


const searchTerm = ref('');
const filteredCategory = ref([]);
const isDropdownOpen = ref(false);


const categories = ref([]);
const subcategories = ref([]);
const authors = ref([]);

const imagePreview = ref(null);
const errors = ref('');
const isEditMode = ref(false);
const router = useRoute();
const toastr = useToastr();

onMounted(() => {
    category();
    fetchAuthors();
    isEditMode.value = router.params.id !== undefined;
    if (isEditMode.value) {
        editProductById(router.params.id);
    }

    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 1000);
});

const category = () => {
    useAxios.get('/admin/category', {
        headers: { Authorization: 'Bearer ' + useToken().getToken() }
    }).then((res) => {
        categories.value = res.data.data
        filteredCategory.value = categories.value
    })
};

const openDropdown = () => {
    isDropdownOpen.value = true;
};

const closeDropdown = () => {
    isDropdownOpen.value = false;
};


const selectCategory = (cate) => {
    form.value.category_id = cate.id;
    searchTerm.value = cate.name;
    isDropdownOpen.value = false;
    fetchSubcategoies(cate.id);
};

const filterCategory = () => {
    filteredCategory.value = categories.value.filter((role) =>
        role.name.toLowerCase().includes(searchTerm.value.toLowerCase())
    );
};

const fetchAuthors = () => {
    useAxios.get('/admin/authors', {
        headers: { Authorization: 'Bearer ' + useToken().getToken() }
    }).then((res) => {
        authors.value = res.data
    })
};

const fetchSubcategoies = async (catId) => {
    if (catId) {
        try {
            const response = await useAxios.get(`/admin/categoryWiseSubcategory/${catId}`, {
                headers: { Authorization: 'Bearer ' + useToken().getToken() }
            });
            subcategories.value = response.data;
        } catch (error) {
            console.error('fetch subcat', error);
        }
    }
};

const editProductById = async (id) => {
    await useAxios.get(`/admin/products/${id}`, {
        headers: { Authorization: 'Bearer ' + useToken().getToken() }
    }).then((res) => {
        form.value = res.data;
        fetchSubcategoies(res.data.category_id);
    }).catch((error) => {
        console.error('edit Prod', error);
    })
};


const saveForm = async () => {
    errors.value = '';
    if (isEditMode.value) {
        await useAxios.post(`/admin/products/${router.params.id}`, form.value, {
            headers: { Authorization: 'Bearer ' + useToken().getToken() }
        }).then((resp) => {
            if (resp.data.success === true) {
                Routers.push({ name: "admin.product" })
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
        await useAxios.post('/admin/products', form.value, {
            headers: { Authorization: 'Bearer ' + useToken().getToken() }
        }).then(resp => {
            if (resp.data.success === true) {
                Routers.push({ name: "admin.product" })
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


const handleImageUpload = (event) => {
    form.value.image = event.target.files[0];
    let reader = new FileReader();
    reader.addEventListener("load", function () {
        imagePreview.value = reader.result;
    }.bind(this), false);
    if (form.value.image) {
        if (/\.(jpe?g|png|gif)$/i.test(form.value.image.name)) {
            reader.readAsDataURL(form.value.image);
        }
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