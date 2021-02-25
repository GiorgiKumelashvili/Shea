import { ref } from 'vue';
import store from '@/store/index';
import Back from '@/libs/Back';
import Func from '@/libs/Func';

import wholeCardRefresh from './wholeCardRefresh';

const cardName = ref(null);

const addNewCard = async () => {
    const arr = store.getters.MainData.map(obj => obj.index);

    let obj = {
        name: cardName.value,
        id: Func.RandomNumber(),
        child: [],
        location: 1,
        index: Math.max(...arr) + 1
    };

    // Add on Store
    store.dispatch('createNewCardAndAdd', obj);

    // Add on Backend
    await Back.Service('/addCard', obj);

    // Refresh whole data
    wholeCardRefresh.forcedRefresh();
};

export default { cardName, addNewCard };
