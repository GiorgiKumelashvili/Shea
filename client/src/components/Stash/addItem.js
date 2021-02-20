import { reactive } from 'vue';
import store from '@/store/index';
import Func from '@/libs/Func';

// State
const state = reactive({
    name: null,
    url: null,
    description: null,
    id: null
});

// Upda
const addNewItemToCardInStore = id => {
    state.id = Func.RandomNumber();

    store.dispatch('addNewItemToCard', {
        state: JSON.parse(JSON.stringify(state)),
        cardLocationId: id
    });
};

export default {
    newItemForm: state,
    addNewItemToCardInStore
};
