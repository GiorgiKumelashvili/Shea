import Back from '@/libs/Back';
import store from '@/store/index';

const deleteCertainItem = obj => {
    store.dispatch('deleteItem', obj);

    const { Parent, Child } = obj;

    Back.Service('/deleteItem', {
        id: Child,
        card_id: Parent
    });
};

export default { deleteCertainItem };
