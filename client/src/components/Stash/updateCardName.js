import Back from '@/libs/Back';
import store from '@/store/index';
import { ref } from 'vue';

const showCardNameInput = ref(false);

// Update Card Name
const updateCertainCardName = (id, name) => {
    showCardNameInput.value = false; // remove input after updating

    // Update in Store
    store.dispatch('updateCardName', { newCardName: name, id });

    // Update in Backend
    Back.Service('/updateCardName', { id, newName: name });
};

const showInput = id => {
    showCardNameInput.value = true;
    const el = document.getElementById('name-input-' + id);
    setTimeout(() => el.focus(), 0);
};

const closeInput = () => {
    showCardNameInput.value = false;
};

export default {
    showCardNameInput,
    updateCertainCardName,
    showInput,
    closeInput
};
