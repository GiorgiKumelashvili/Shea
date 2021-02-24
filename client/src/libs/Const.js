export default {
    svgs: {
        settings: require('@/assets/svgs/bi-setting.svg'),
        itemPen: require('@/assets/svgs/bi-pen.svg'),
        plus: require('@/assets/svgs/bi-plus.svg'),
        xCircle: require('@/assets/svgs/bi-fullscreen-exit.svg'),
        Link: require('@/assets/svgs/bi-link.svg'),
        Link_Light: require('@/assets/svgs/bi-link-light.svg'),
        share: require('@/assets/svgs/bi-share.svg')
    },
    betweenClass: 'd-flex justify-content-between align-items-center',

    ItemDragOption: {
        animation: 500,
        group: 'list-of-items',
        disabled: false,
        ghostClass: 'ghost',
        delayOnTouchOnly: true,
        delay: 900
    },

    CardDragOption: {
        animation: 500,
        group: 'description',
        disabled: false,
        ghostClass: 'ghost',
        delayOnTouchOnly: true,
        delay: 1500
    }
};
