import { reactive } from 'vue';
import store from '@/store/index';

// Show Item modal
const itemData = reactive({
    item: null,
    card: null
});

const openItemModal = ({ Parent, Child }) => {
    // Copy
    const card = JSON.parse(JSON.stringify(store.getters.findCardById(Parent)));

    itemData.card = { name: card.name, id: Parent };
    itemData.item = card.child.find(item => item.id === Child);
};

export default { itemData, openItemModal };
