import { reactive } from 'vue';
import store from '@/store/index';

// Show Item modal
const itemData = reactive({
    item: null,
    card: null
});

const openItemModal = ({ Parent, Child }) => {
    const card = store.getters.findCardById(Parent);

    itemData.card = { name: card.name, id: Parent };
    itemData.item = card.child.find(item => item.id === Child);

    console.log(itemData);
};

export default { itemData, openItemModal };
