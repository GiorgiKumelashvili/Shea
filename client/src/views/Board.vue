<template>
    <h1>Board</h1>
    <button @click="req">req</button>
    <button @click="log">log</button>
</template>

<script>
import axios from 'axios';
import { useStore } from 'vuex';
export default {
    setup() {
        const req = () => {
            axios.get('http://localhost:8000/api/t').then(res => {
                console.log(res);
            });
        };

        const store = useStore();

        const log = () => {
            console.log(store.state);
        };

        return { req, log };
    }
};
</script>
