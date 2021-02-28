import Back from '@/libs/Back';
import wholeCardRefresh from '@/components/globals/cards/wholeCardRefresh.js';

/**
 * Update Item [Name]
 */

const focusItemInputName = id => {
    let elName = 'item-name-input-' + id;
    const el = document.getElementById(elName);
    setTimeout(() => el.focus(), 0);
};

const updateItemName = async (id, name) => {
    await Back.Service('/item/update', { id, name });
    wholeCardRefresh.forcedRefresh();
};

/**
 * Update Item [Url]
 */

const focusItemInputUrl = id => {
    let elName = 'item-url-input-' + id;
    const el = document.getElementById(elName);
    setTimeout(() => el.focus(), 0);
};

const updateItemUrl = async (id, url) => {
    await Back.Service('/item/update', { id, url });
    wholeCardRefresh.forcedRefresh();
};

export default {
    focusItemInputName,
    updateItemName,
    focusItemInputUrl,
    updateItemUrl
};
