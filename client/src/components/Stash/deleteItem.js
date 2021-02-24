import Back from '@/libs/Back';
import store from '@/store/index';

const deleteCertainItem = obj => {
    // Delete in Store
    store.dispatch('deleteItem', obj);

    // Delete in Backend
    Back.Service('/deleteItem', {
        id: obj.Child,
        card_id: obj.Parent
    });
};

export default { deleteCertainItem };
