// vue
import { ref } from 'vue';
import store from '@/store/index';

// libs
import Back from '@/libs/Back';
import Func from '@/libs/Func';
import Const from '@/libs/Const';

// other
import wholeCardRefresh from '@/components/globals/cards/wholeCardRefresh';

const cardName = ref(null);

const addNewCard = async () => {
    const arr = store.getters.MainData.map(obj => obj.index);
    const index = arr.length ? Math.max(...arr) + 1 : 0;
    const obj = {
        name: cardName.value,
        id: Func.RandomNumber(),
        child: [],
        location: Const.locations.stash,
        index
    };

    // Add on Store
    store.dispatch('createNewCardAndAdd', obj);

    // Add on Backend
    await Back.Service('/card/stash/add-card', obj);

    // Refresh whole data
    wholeCardRefresh.forcedRefreshStash();
};

export default { cardName, addNewCard };
