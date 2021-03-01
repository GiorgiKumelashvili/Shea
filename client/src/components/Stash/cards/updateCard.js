import Back from '@/libs/Back';
import store from '@/store/index';

const updateCardName = (id, name) => {
    // Update in Store
    store.dispatch('updateCardName', { newCardName: name, id });

    // Update in Backend
    Back.Service('/card/stash/update-card-name', { id, newName: name });
};

const focusInput = id => {
    const el = document.getElementById('name-input-' + id);

    if (!el) return;

    setTimeout(() => el.focus(), 0);
};

export default {
    updateCardName,
    focusInput
};
