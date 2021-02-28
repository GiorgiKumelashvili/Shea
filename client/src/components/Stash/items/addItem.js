import { reactive } from 'vue';
import store from '@/store/index';
import Func from '@/libs/Func';
import Back from '@/libs/Back';
import wholeCardRefresh from '@/components/Stash/cards/wholeCardRefresh.js';

// State
const state = reactive({
    name: null,
    url: null,
    description: null,
    id: null,
    index: null
});

const addNewItemToCardInStore = async obj => {
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
    await Back.Service('/item/add', {
        ...JSON.parse(JSON.stringify(state)),
        card_id: id
    });

    // Refresh whole data
    wholeCardRefresh.forcedRefresh();
};

export default {
    newItemForm: state,
    addNewItemToCardInStore
};
