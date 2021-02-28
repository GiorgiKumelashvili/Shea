import Back from '@/libs/Back';
import store from '@/store/index';

// Update card index after single Drag
const changeMain = ({ oldIndex, newIndex }) => {
    const card = store.getters.MainData[oldIndex];

    // Update card index in Backend
    Back.Service('/card/stash/update-card-index', {
        cardId: card.id,
        oldIndex,
        newIndex
    });

    // Update card index in Store
    store.dispatch('updateCardPosition', { oldIndex, newIndex, card });
};

export default {
    changeMain
};
