<template>
    <div class="whole-shea-horizontal-scroll mt-2 pt-2 ps-4">
        <template v-for="el in MainDataShow">
            <Card v-if="MainDataShow.length" :elementProp="el" :key="el.id" />
        </template>
    </div>
</template>

<script>
import Card from '@/components/archive/Card.vue';
import { useStore } from 'vuex';
import { computed } from 'vue';

export default {
    components: {
        Card
    },
    setup() {
        const store = useStore();
        store.dispatch('getMainData'); // Load Main Data !

        const MainDataShow = computed({
            get: () => store.getters.MainData,
            set: () => null
        });

        return { MainDataShow };
    }
};
</script>
