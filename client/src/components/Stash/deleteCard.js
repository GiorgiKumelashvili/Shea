import Back from '@/libs/Back';
import store from '@/store/index';

const deleteCertainCard = id => {
    // Delete in Store
    store.dispatch('deleteCardByIndex', id);

    // Delete in Backend
    Back.Service('/deleteCard', { id });
};

export default {
    deleteCertainCard
};
