import wholeCardRefresh from '@/components/globals/cards/wholeCardRefresh.js';
import Back from '@/libs/Back';
import store from '@/store';

const transferToArchive = cardId => {
    console.log('hi');
    console.log(cardId);

    // Just deletes on ui
    store.dispatch('deleteCardByIndex', cardId);

    // Change location of card
    Back.Service('/card/move-card-to-archive', { id: cardId });
};

export default {
    transferToArchive
};
