import wholeCardRefresh from '@/components/globals/cards/wholeCardRefresh';
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

const moveItemToNewCard = async (event, final) => {
    const { newIndex } = event;

    await Back.Service('/item/update-item-index-on-drag-add', {
        cardId: final.id,
        itemId: final.child[newIndex].id,
        newIndex
    });

    wholeCardRefresh.forcedRefreshStash();
};

const removeItemFromOldCard = async (event, final) => {
    inside.value = false;
    const { oldIndex } = event;

    await Back.Service('/item/update-item-index-on-drag-remove', {
        cardId: final.id,
        oldIndex
    });

    wholeCardRefresh.forcedRefreshStash();
};

const moveItemInside = async (event, final) => {
    if (!inside.value) {
        inside.value = true;
        return;
    }

    const { newIndex, oldIndex } = event;

    await Back.Service('/item/update-item-index-on-inside-drag', {
        cardId: final.id,
        itemId: final.child[newIndex].id,
        newIndex,
        oldIndex
    });

    wholeCardRefresh.forcedRefreshStash();
};

export default {
    inside,
    moveItemInside,
    moveItemToNewCard,
    removeItemFromOldCard
};
