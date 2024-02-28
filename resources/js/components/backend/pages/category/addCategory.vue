<template>
    <div class="card bg-base-100 shadow-xl card-bordered">
        <div class="card-body">
            <h2 class="card-title"> {{ isEditMode ? 'Edit' : 'Add New' }} Category <RouterLink
                    :to="{ name: 'admin.category' }" class="btn btn-sm btn-primary">Back</RouterLink>
            </h2>

            <form @submit.prevent="saveCategory" class="space-y-4 md:space-y-6" method="post">
                <div>
                    <div class="label"><span class="label-text">Category Name</span></div>
                    <label class="input input-bordered flex items-center gap-2">
                        <input type="text" v-model="form.name" class="grow" placeholder="Category name" />
                    </label>
                    <div class="text-danger">{{ errors.name ? errors.name[0] : '' }}</div>
                </div>
                <div>
                    <div class="label"><span class="label-text">Category Image</span></div>
                    <input type="file" class="file-input file-input-bordered w-full max-w-xs" @change="handleImageUpload"
                        accept="image/jpeg" />
                    <img v-bind:src="imagePreview == null ? '/storage/category/' + form.image : imagePreview" width="100"
                        height="100" />
                    <div class="text-danger">{{ errors.image ? errors.image[0] : '' }}</div>
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

const form = ref({
    name: '',
    image: null,
});

const imagePreview = ref(null);
const errors = ref('');
const isEditMode = ref(false);
const router = useRoute();
const toastr = useToastr();

onMounted(() => {
    isEditMode.value = router.params.id !== undefined;
    if (isEditMode.value) {
        editCategory(router.params.id);
    }
});

const editCategory = () => {
    useAxios.get(`/admin/category/${router.params.id}`, {
        headers: { Authorization: 'Bearer ' + useToken().getToken() }
    }).then(response => {
        form.value = { ...response.data };
    }).catch(error => {
        console.log(error)
    })
};

const saveCategory = async () => {
    if (isEditMode.value) {
        await useAxios.post(`/admin/category/${router.params.id}`, form.value, {
            headers: { Authorization: 'Bearer ' + useToken().getToken() }
        }).then((resp) => {
            if (resp.data.success === true) {
                Routers.push({ name: "admin.category" })
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
        await useAxios.post('/admin/category', form.value, {
            headers: { Authorization: 'Bearer ' + useToken().getToken() }
        }).then(resp => {
            if (resp.data.success === true) {
                Routers.push({ name: "admin.category" })
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
