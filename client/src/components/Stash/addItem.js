import { reactive } from 'vue';
import store from '@/store/index';
import Func from '@/libs/Func';
import Back from '@/libs/Back';

// State
const state = reactive({
    name: null,
    url: null,
    description: null,
    id: null,
    index: null
});

const addNewItemToCardInStore = obj => {
    if (!state.name || !state.url) {
        return null;
    }

    const { id, data } = obj;
    const indexArr = data.child.map(obj => obj.index);

    state.id = Func.RandomNumber();
    state.index = indexArr.length ? Math.max(...indexArr) + 1 : 0;

    // Add for Store
    store.dispatch('addNewItemToCard', {
        state: JSON.parse(JSON.stringify(state)),
        cardLocationId: id
    });

    // Add for Backend
    Back.Service('/addNewItem', {
        ...JSON.parse(JSON.stringify(state)),
        card_id: id
    });
};

export default {
    newItemForm: state,
    addNewItemToCardInStore
};
