import Back from '@/libs/Back';
import { ref } from 'vue';

/**
 * Item drag update on backend
 *
 * @method moveItemToNewCar
 * @method removeItemFromOldCard
 *
 * @method moveItemInside
 * @description
 * Execution process:
 *      I)  Remove
 *      II) End
 *
 *      So this method executes only once
 *      which is when dragged only inside
 *      this is why we need inside var
 *      because it also executes on
 *      moving outside of card
 */

const inside = ref(true);

const moveItemToNewCard = (event, final) => {
    const { newIndex } = event;

    Back.Service('/updateItemIndexOnDragAdd', {
        cardId: final.id,
        itemId: final.child[newIndex].id,
        newIndex
    });
};

const removeItemFromOldCard = (event, final) => {
    inside.value = false;
    const { oldIndex } = event;

    Back.Service('/updateItemIndexOnDragRemove', {
        cardId: final.id,
        oldIndex
    });
};

const moveItemInside = (event, final) => {
    if (!inside.value) {
        inside.value = true;
        return;
    }

    const { newIndex, oldIndex } = event;

    Back.Service('/updateIndexOnInsideDragUpdate', {
        cardId: final.id,
        itemId: final.child[newIndex].id,
        newIndex,
        oldIndex
    });
};

export default {
    inside,
    moveItemInside,
    moveItemToNewCard,
    removeItemFromOldCard
};
