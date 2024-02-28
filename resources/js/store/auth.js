import { onBeforeMount, ref, watch } from "vue";
import { defineStore } from 'pinia'
import useToken from '../services/token';
import { useRouter } from 'vue-router'
import axios from "axios";

const useAuth = defineStore('auth', () => {
    const isAuthenticated = ref(null);
    const user = ref(null);
    const setting = ref(null);
    const router = useRouter();
    const errorData = ref();

    onBeforeMount(() => {
        if (useToken().getToken() !== null) getAuthUser();
    });

    function getAuthUser() {
        axios.get('/api/admin/profile', {
            headers: { Authorization: 'Bearer ' + useToken().getToken() }
        })
            .then(response => {
                isAuthenticated.value = true
                user.value = response.data;
                // setting.value = response.data.settings;
            })
            .catch(error => {
                isAuthenticated.value = false;
                useToken().deleteToken();
            })
    }

    function login(data) {
        axios.post('/api/admin/login', data).then((res) => {
            if(res.data.user.role_id === 3){
                setAuthUser(res.data, data.remember);
                router.push({ name: 'homepage' })
            }else{
                setAuthUser(res.data, data.remember);
                router.push({ name: 'dashboard' })
            }
        }).catch((error) => {
            // console.log('Login Err', error.response);
            if(error.response?.status ===422){
                errorData.value = error.response.data.errors
            }
        });
    }

    function setAuthUser(response, remember) {
        errorData.value = null
        isAuthenticated.value = true
        user.value = response.user
        useToken().setToken(response.access_token, remember)
        getAuthUser();
    }
    

    function logout() {
        console.log('Logout');

        axios.get('/api/admin/logout', {
            headers: {
                Authorization: 'Bearer ' + useToken().getToken()
            }
        }).then(response => {
            router.push({ name: 'admin.login' })
                removeAuthUser();
                // useAlert().centerMessageAlert('success', response.data.message)
            })
    }

    function removeAuthUser() {
        isAuthenticated.value = false
        user.value = null
        useToken().deleteToken();
    }

    

    watch(isAuthenticated, () => {
        if (!isAuthenticated.value) router.push({ name: 'login' });
    })

    return { isAuthenticated,getAuthUser,user, setting, errorData, logout, login }
})

export default useAuth;