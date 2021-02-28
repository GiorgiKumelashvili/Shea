import Back from '@/libs/Back';
import store from '@/store/index';

const deleteCertainItem = obj => {
    console.log('hi');

    // Delete in Store
    store.dispatch('deleteItem', obj);

    // Delete in Backend
    Back.Service('/item/delete', {
        id: obj.Child,
        card_id: obj.Parent
    });
};

export default { deleteCertainItem };
