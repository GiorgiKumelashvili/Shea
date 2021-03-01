import wholeCardRefresh from '@/components/globals/cards/wholeCardRefresh';
import Back from '@/libs/Back';
import store from '@/store/index';

// Update card index after single Drag
const changeMain = async ({ oldIndex, newIndex }) => {
    const card = store.getters.MainData[oldIndex];

    // Update card index in Store
    store.dispatch('updateCardPosition', { oldIndex, newIndex, card });

    // Update card index in Backend
    await Back.Service('/card/stash/update-card-index', {
        cardId: card.id,
        oldIndex,
        newIndex
    });

    wholeCardRefresh.forcedRefreshStash();
};

export default {
    changeMain
};
