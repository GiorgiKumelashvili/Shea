import { ref } from 'vue';
import store from '@/store/index';
import Back from '@/libs/Back';
import Func from '@/libs/Func';

const cardName = ref(null);

const addNewCard = () => {
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
    Back.Service('/addCard', obj);
};

export default { cardName, addNewCard };
