<template>
    <Navbar v-if="isAuthenticated" />

    <!-- Main content -->
    <router-view></router-view>
</template>

<script>
import Navbar from '@/components/Fragments/Navbar';
import { useStore } from 'vuex';
import { ref } from 'vue';

export default {
    components: {
        Navbar
    },
    setup() {
        const store = useStore();
        const isAuthenticated = ref(store.getters.isAuthenticated);

        //! Set in store
        isAuthenticated.value = localStorage.getItem('isAuthenticated') ?? false;
        store.commit('setAuthenticated', isAuthenticated.value);

        return { isAuthenticated, store };
    }
};
</script>
