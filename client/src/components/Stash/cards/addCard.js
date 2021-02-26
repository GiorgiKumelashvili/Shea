// vue
import { ref } from 'vue';
import store from '@/store/index';

// libs
import Back from '@/libs/Back';
import Func from '@/libs/Func';
import Const from '@/libs/Const';

// other
import wholeCardRefresh from '@/components/Stash/cards/wholeCardRefresh';

const cardName = ref(null);

const addNewCard = async () => {
    const arr = store.getters.MainData.map(obj => obj.index);

    let obj = {
        name: cardName.value,
        id: Func.RandomNumber(),
        child: [],
        location: Const.locations.stash,
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
