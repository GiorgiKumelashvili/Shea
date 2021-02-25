import wholeCardRefresh from '@/components/Stash/wholeCardRefresh';
import Back from '@/libs/Back';
import { createStore } from 'vuex';

export default createStore({
    state: {
        authenticated: false,
        MainData: [],
        MainDatax: [
            {
                name: 'Big list 1',
                id: 101,
                child: [
                    {
                        name: '[Both] Should do something a',
                        id: 4,
                        url: 'url example',
                        description: 'desription example'
                    },
                    { name: 'First', id: 42, url: 'url example' },
                    { name: 'Secon', id: 43, description: 'desription example' }
                ]
            },
            {
                name: 'Big list 2',
                id: 102,
                child: [
                    {
                        name:
                            'Should do something about anime stuffd do something about anime stuffd do something about anime stuffd do something about anime stuff',
                        id: 5,
                        url: 'url example'
                    },
                    {
                        name:
                            'Should do something about anime stuffd do something about anime stuffd do something about anime stuffd do something about anime stuff',
                        id: 7,
                        url: 'url example'
                    }
                ]
            },
            {
                name: 'Big list 3',
                id: 103,
                child: [
                    { name: 'gio', id: 8, url: 'url example' },
                    { name: 'gel', id: 9, url: 'url example' },
                    { name: 'jemala', id: 10, url: 'url example' }
                ]
            },
            {
                name: 'Big list 4',
                id: 104,
                child: [
                    { name: 'Jena', id: 11, url: 'url example' },
                    { name: 'nino', id: 12, url: 'url example' },
                    { name: 'malaa', id: 13, url: 'url example' }
                ]
            },
            {
                name: 'Big list 5',
                id: 105,
                child: [
                    { name: 'Jena', id: 11, url: 'url example' },
                    { name: 'nino', id: 12, url: 'url example' },
                    { name: 'malaa', id: 13, url: 'url example' }
                ]
            }
        ]
    },
    mutations: {
        setAuthenticated(state, payload) {
            state.authenticated = payload;
        },

        setMain(state, payload) {
            state.MainData = payload;
        },

        /**
         * [ Card Mutations ]
         *
         * @method addNewCard
         * @method updateCardPosition
         * @method updateCardName
         * @method deleteCard
         */

        addNewCard(state, payload) {
            state.MainData.push(payload);
        },

        updateCardPosition(state, { oldIndex, newIndex, card }) {
            state.MainData.splice(oldIndex, 1);
            state.MainData.splice(newIndex, 0, card);
        },

        updateCardName(state, { newCardName, index }) {
            state.MainData[index].name = newCardName;
        },

        //!
        deleteCard(state, payload) {
            const card = state.MainData[payload];

            // delete
            state.MainData.splice(payload, 1);

            // decrement indexes
            state.MainData.forEach((el, i) => {
                if (el.index > card.index) {
                    state.MainData[payload].index = el.index - 1;
                }
            });

            // refresh ui
            wholeCardRefresh.refresh();
        },

        /**
         * [ Item Mutations ]
         *
         * @method createNewItem
         * @method updateItemPosition
         * @method deleteItem
         */

        createNewItem(state, { index, data }) {
            state.MainData[index].child.push(data);
            wholeCardRefresh.refresh();
        },

        updateItemPosition(state, { index, newChildren }) {
            state.MainData[index].child = newChildren;
        },

        deleteItem(state, { cardIndex, itemIndex }) {
            const item = state.MainData[cardIndex].child[itemIndex];

            // delete
            state.MainData[cardIndex].child.splice(itemIndex, 1);

            // decrement indexes
            state.MainData[cardIndex].child.forEach((el, i) => {
                if (el.index > item.index) {
                    state.MainData[cardIndex].child[i].index = el.index - 1;
                }
            });

            // refresh ui
            wholeCardRefresh.refresh();
        }
    },

    actions: {
        authenticate(ctx, payload) {
            ctx.commit('setAuthenticated', { bool: payload });
        },

        async getMainData(ctx) {
            const data = await Back.Service('/getMainData');

            if (data.response && data.response.statusText) {
                return;
            }

            ctx.commit('setMain', data.data);
        },

        /**
         * [ Item Actions ]
         *
         * @method addNewItemToCard
         * @method updateItemPosition
         * @method deleteItem
         */

        addNewItemToCard(ctx, { cardLocationId, state }) {
            const index = ctx.getters.findCardIndexById(cardLocationId);
            ctx.commit('createNewItem', { index, data: state });
        },

        updateItemPosition(ctx, payload) {
            ctx.commit('updateItemPosition', payload);
        },

        deleteItem(ctx, { Parent, Child }) {
            const { index: cardIndex, card } = ctx.getters.findCardBoth(Parent);
            const itemIndex = card.child.findIndex(item => item.id === Child);

            ctx.commit('deleteItem', { cardIndex, itemIndex });
        },

        /**
         * [ Card Actions ]
         *
         * @method createNewCardAndAdd
         * @method updateCardPosition
         * @method updateCardName
         * @method deleteCardByIndex
         */

        createNewCardAndAdd(ctx, payload) {
            ctx.commit('addNewCard', payload);
        },

        updateCardPosition(ctx, payload) {
            ctx.commit('updateCardPosition', payload);
        },

        updateCardName(ctx, { newCardName, id }) {
            const index = ctx.getters.findCardIndexById(id);
            ctx.commit('updateCardName', { newCardName, index });
        },

        deleteCardByIndex(ctx, payload) {
            const index = ctx.getters.findCardIndexById(payload);
            ctx.commit('deleteCard', index);
        }
    },

    getters: {
        isAuthenticated: state => state.authenticated,
        MainData: state => state.MainData,
        findCardIndexById: state => id => {
            let index = state.MainData.findIndex((el, i) => {
                if (el.id === id) return i;
            });

            return index === -1 ? 0 : index;
        },
        findCardById: state => id => {
            return state.MainData.find(el => {
                if (el.id === id) return el;
            });
        },
        findCardBoth: state => id => {
            let index = 0;
            let card = state.MainData.find((el, i) => {
                if (el.id === id) {
                    index = i;
                    return el;
                }
            });

            return { index, card };
        }
    },

    modules: {},
    strict: true
});
