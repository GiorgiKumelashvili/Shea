<template>
    <div class="whole-shea-horizontal-scroll mt-2 pt-2 ps-4" :key="draggableKey">
        <template v-for="el in MainDataShow">
            <Card
                v-if="MainDataShow.length"
                :elementProp="el"
                :key="`archive-card-${el.id}`"
                @openShareCardModalEvent="saveShareCardData($event)"
            />
        </template>
    </div>

    <Share />
</template>

<script>
import Card from '@/components/archive/Card.vue';
import wholeCardRefresh from '@/components/globals/cards/wholeCardRefresh';
import shareCard from '@/components/globals/cards/shareCard';
import { useStore } from 'vuex';
import { computed } from 'vue';

import Share from '@/components/Fragments/Share.vue';
export default {
    components: {
        Card,
        Share
    },
    setup() {
        const store = useStore();
        store.dispatch('getMainData', 'archive'); // Load Main Data !

        const MainDataShow = computed({
            get: () => store.getters.MainData,
            set: () => null
        });

        const { draggableKey } = wholeCardRefresh;
        const { saveShareCardData } = shareCard;

        return {
            MainDataShow,
            draggableKey,
            saveShareCardData
        };
    }
};
</script>
