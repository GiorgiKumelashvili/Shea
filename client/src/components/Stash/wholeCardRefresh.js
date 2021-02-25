import store from '@/store/index';
import { ref } from 'vue';

const draggableKey = ref('some random key');

const refresh = () => (draggableKey.value = `new random key ${Math.random() * 10}`);

const forcedRefresh = async () => {
    await store.dispatch('getMainData');

    refresh();
};

export default { refresh, forcedRefresh, draggableKey };
