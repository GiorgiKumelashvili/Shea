import wholeCardRefresh from '@/components/globals/cards/wholeCardRefresh.js';
import Back from '@/libs/Back';
import store from '@/store';

const transferToArchive = (cardId, index) => {
    // Just deletes on ui
    store.dispatch('deleteCardByIndex', cardId);

    // Change location of card
    Back.Service('/card/move-card-to-archive', { id: cardId, index });
};

export default {
    transferToArchive
};
