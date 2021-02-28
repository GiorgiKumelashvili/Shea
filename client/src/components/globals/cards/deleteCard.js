import Back from '@/libs/Back';
import store from '@/store/index';

const deleteCertainCard = (id, location) => {
    // Delete in Store
    store.dispatch('deleteCardByIndex', id);

    // Delete in Backend
    Back.Service('/card/stash/delete-card', { id, location });
};

export default {
    deleteCertainCard
};
