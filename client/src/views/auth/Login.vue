<template>
    <div class="container border mt-5 px-5 py-2 bg-light" style="max-width:500px">
        <p class="text-center display-5">Login</p>

        <div class="form-floating mb-3">
            <input
                v-model="form.credentials.email"
                type="email"
                class="form-control"
                id="floatingInput"
                placeholder="name@example.com"
            />
            <label for="floatingInput">Email address</label>
        </div>

        <div class="form-floating">
            <input
                v-model="form.credentials.password"
                type="password"
                class="form-control"
                id="floatingPassword"
                placeholder="Password"
            />
            <label for="floatingPassword">Password</label>
        </div>

        <div class="form-group form-check my-3 d-flex justify-content-between">
            <div>
                <input type="checkbox" class="form-check-input" id="exampleCheck1" />
                <label class="form-check-label" for="exampleCheck1">Remember me</label>
            </div>

            <router-link :to="{ name: 'register' }" tag="a" class="nav-link text-decoration-none">
                Register
            </router-link>
        </div>

        <p class="text-danger" v-if="form.errorMessage">{{ form.errorMessage }}</p>

        <button type="submit" class="btn btn-outline-primary" @click="login()">
            Submit
        </button>
    </div>
</template>

<script>
import { reactive } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    setup() {
        const router = useRouter();
        const store = useStore();

        const form = reactive({
            credentials: {
                email: null,
                password: null
            },

            errorMessage: null
        });

        const login = async () => {
            try {
                const csrf = await axios.get('/sanctum/csrf-cookie');
                const login = await axios.post('/login', form.credentials);
                const { data } = await axios.post('/api/tokens/create', form.credentials);

                localStorage.setItem('accessToken', data.token);
                localStorage.setItem('isAuthenticated', true);
                store.commit('setAuthenticated', true);

                router.go({ name: 'home' });
            } catch (error) {
                form.errorMessage = error.response.data.message || '';
            }
        };

        return {
            form,
            login
        };
    }
};
</script>
