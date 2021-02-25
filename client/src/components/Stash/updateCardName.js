import Back from '@/libs/Back';
import store from '@/store/index';

// Update Card Name
const updateCertainCardName = (id, name) => {
    // Update in Store
    store.dispatch('updateCardName', { newCardName: name, id });

    // Update in Backend
    Back.Service('/updateCardName', { id, newName: name });
};

const showInput = id => {
    const el = document.getElementById('name-input-' + id);
    console.log(el);
    if (!el) return;

    setTimeout(() => el.focus(), 0);
};

export default {
    updateCertainCardName,
    showInput
};
