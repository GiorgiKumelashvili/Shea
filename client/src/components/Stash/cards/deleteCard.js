import Back from '@/libs/Back';
import store from '@/store/index';
// import wholeCardRefresh from '@/components/Stash/cards/wholeCardRefresh.js';

const deleteCertainCard = id => {
    // Delete in Store
    store.dispatch('deleteCardByIndex', id);

    // Delete in Backend
    Back.Service('/card/stash/delete-card', { id });
};

export default {
    deleteCertainCard
};
