<template>
    <h1>Archive</h1>
</template>

<script>
import { useStore } from 'vuex';

export default {
    setup() {
        const store = useStore();
        store.dispatch('getMainData'); // Load Main Data !
    }
};
</script>
