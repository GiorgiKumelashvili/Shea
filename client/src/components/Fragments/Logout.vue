<template>
    <p class="m-0 w-100 h-100" style="padding: .375rem .75rem;" @click="logout">
        {{ text }}
    </p>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';

export default {
    props: {
        text: {
            type: String,
            default: 'Logout'
        }
    },
    setup() {
        const router = useRouter();
        const store = useStore();

        const token = localStorage.getItem('accessToken');

        const logout = () => {
            axios({
                url: '/api/logout',
                headers: {
                    Authorization: `Bearer ${token}`
                },
                method: 'POST'
            })
                .then(res => {
                    console.log(res);

                    localStorage.removeItem('isAuthenticated');
                    localStorage.removeItem('accessToken');

                    store.commit('setAuthenticated', false);

                    router.go({ name: 'login' });
                })
                .catch(err => {
                    console.log(err.response);
                });
        };

        return { logout };
    }
};
</script>
