import { ref } from 'vue';
import store from '@/store/index';

const cardName = ref(null);

const addNewCard = () => {
    store.dispatch('createNewCardAndAdd', cardName.value);
};

export default { cardName, addNewCard };
