import wholeCardRefresh from '@/components/Stash/wholeCardRefresh';
import Back from '@/libs/Back';
import Func from '@/libs/Func';
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

        updateMain(state, { index, newChildren }) {
            state.MainData[index].child = newChildren;
        },

        addNewCard(state, payload) {
            state.MainData.unshift(payload);
        },

        updateMainCardPosition(state, { oldIndex, newIndex, card }) {
            state.MainData.splice(oldIndex, 1);
            state.MainData.splice(newIndex, 0, card);
        },

        updateCardName(state, { newCardName, index }) {
            state.MainData[index].name = newCardName;
        },

        deleteCard(state, payload) {
            state.MainData.splice(payload, 1);
        },

        createNewItem(state, { index, data }) {
            state.MainData[index].child.push(data);
            wholeCardRefresh.refresh();
        },

        deleteItem(state, { cardIndex, itemIndex }) {
            state.MainData[cardIndex].child.splice(itemIndex, 1);
            console.log({ cardIndex, itemIndex });
            wholeCardRefresh.refresh();
        }
    },

    actions: {
        authenticate(ctx, payload) {
            ctx.commit('setAuthenticated', { bool: payload });
        },

        async getMainData(ctx) {
            const data = await Back.Service('/t');

            if (data.response && data.response.statusText) {
                console.log(data.response.statusText);
                return;
            }

            ctx.commit('setMain', data.data);
        },

        updateMain(ctx, payload) {
            ctx.commit('updateMain', payload);
        },

        updateMainCardPosition(ctx, { oldIndex, newIndex }) {
            const card = ctx.state.MainData[oldIndex];
            ctx.commit('updateMainCardPosition', { oldIndex, newIndex, card });
        },

        addNewItemToCard(ctx, { cardLocationId, state }) {
            const index = ctx.getters.findCardIndexById(cardLocationId);
            ctx.commit('createNewItem', { index, data: state });
        },

        deleteCardByIndex(ctx, payload) {
            const index = ctx.getters.findCardIndexById(payload);
            ctx.commit('deleteCard', index);
        },

        createNewCardAndAdd(ctx, payload) {
            ctx.commit('addNewCard', {
                name: payload,
                id: Func.RandomNumber(),
                child: []
            });
        },

        updateCardName(ctx, { newCardName, id }) {
            const index = ctx.getters.findCardIndexById(id);
            ctx.commit('updateCardName', { newCardName, index });
        },

        deleteItem(ctx, { Parent, Child }) {
            const { index: cardIndex, card } = ctx.getters.findCardBoth(Parent);
            const itemIndex = card.child.findIndex(item => item.id === Child);

            ctx.commit('deleteItem', { cardIndex, itemIndex });
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
