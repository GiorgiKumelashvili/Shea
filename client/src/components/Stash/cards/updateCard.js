import Back from '@/libs/Back';
import store from '@/store/index';

const updateCardName = (id, name) => {
    // Update in Store
    store.dispatch('updateCardName', { newCardName: name, id });

    // Update in Backend
    Back.Service('/updateCardName', { id, newName: name });
};

const focusInput = id => {
    const el = document.getElementById('name-input-' + id);

    if (!el) return;

    setTimeout(() => el.focus(), 0);
};

// Update card index after single Drag
const changeMain = ({ oldIndex, newIndex }) => {
    const card = store.getters.MainData[oldIndex];

    // Update card index in Backend
    Back.Service('/updateCardIndex', {
        cardId: card.id,
        oldIndex,
        newIndex
    });

    // Update card index in Store
    store.dispatch('updateCardPosition', { oldIndex, newIndex, card });
};

export default {
    changeMain,
    updateCardName,
    focusInput
};
