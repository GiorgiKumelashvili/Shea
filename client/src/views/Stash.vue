<template>
    <draggable
        class="whole-shea-horizontal-scroll mt-2 pt-2 ps-4"
        itemKey="name"
        tag="transition-group"
        v-model="MainDataShow"
        v-if="MainDataShow.length"
        v-bind="Const.CardDragOption"
        :key="draggableKey"
        :component-data="{ tag: 'div', type: 'transition' }"
        @end="changeMain"
    >
        <template #item="{ element }">
            <MainCard
                :elementProp="element"
                @openItemModalEvent="openItemModal($event)"
                @addNewItemModalEvt="saveCardId($event)"
            />
        </template>
    </draggable>

    <!-- [Message] Error -->
    <div class="card mx-auto mt-5 p-5" v-else style="width:30rem">
        <h1 class="text-center">Error occured</h1>
    </div>

    <!-- [Button] Add new Card -->
    <Fab />

    <!-- [Modal] Add New Item -->
    <div
        class="modal fade"
        id="AddNewItemModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content rounded-1">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <img
                        :src="Const.svgs.xCircle"
                        class="pointer p-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    />
                </div>

                <div class="modal-body py-0">
                    <div class="py-2 d-flex flex-column">
                        <label for="exampleFormName" class="form-label ps-1 pb-2">
                            Name
                        </label>
                        <input
                            type="text"
                            id="exampleFormName"
                            class="form-control"
                            placeholder="Name"
                            aria-label="Name"
                            v-model="newItemForm.name"
                        />
                    </div>

                    <div class="d-flex flex-column">
                        <label for="exampleFormUrl" class="form-label ps-1">
                            Link
                            <img :src="Const.svgs.Link" class="pointer py-2 ps-1" />
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="basic-url"
                            placeholder="https: //example.com"
                            v-model="newItemForm.url"
                        />
                    </div>

                    <div class="py-2 d-flex flex-column">
                        <label for="exampleFormTextarea" class="form-label ps-1 py-2">
                            Description
                        </label>
                        <textarea
                            class="form-control"
                            id="exampleFormTextarea"
                            rows="4"
                            v-model="newItemForm.description"
                        />
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                        Discard
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary btn-sm"
                        data-bs-dismiss="modal"
                        @click="addNewItemToCardInStore(cardData)"
                    >
                        Add New Item
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- [Modal] Show Item -->
    <div
        class="modal fade force-wrap"
        id="OpenCardModal"
        tabindex="-1"
        aria-labelledby="OpenCardModal"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content rounded-1">
                <div class="modal-header">
                    <h5 class="modal-title text-truncate" id="OpenCardModal">
                        {{ itemData?.card?.name }}
                    </h5>
                    <img
                        :src="Const.svgs.settings"
                        class="icon-hover p-2 rounded pointer"
                        id="dropdownMenuOffset"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    />

                    <ul
                        class="dropdown-menu dropdown-menu-dark pointer"
                        aria-labelledby="dropdownMenuOffset"
                    >
                        <li>
                            <p
                                class="dropdown-item m-0"
                                @click="
                                    deleteItem({
                                        Parent: itemData.card.id,
                                        Child: itemData.item.id
                                    })
                                "
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            >
                                Delete
                            </p>
                        </li>
                    </ul>
                </div>
                <div class="modal-body">
                    <h4
                        class="text-center font-monospace m-0 py-3"
                        v-if="itemData.item && itemData.item.hasOwnProperty('name')"
                    >
                        {{ itemData.item.name[0].toUpperCase() + itemData.item.name.slice(1) }}
                    </h4>

                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div
                            class="accordion-item"
                            v-if="itemData.item && itemData.item.hasOwnProperty('url')"
                        >
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button
                                    class="accordion-button px-0 border-0 px-2 shadow-none"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne"
                                    aria-expanded="false"
                                    aria-controls="flush-collapseOne"
                                >
                                    Url
                                    <img :src="Const.svgs.Link_Light" class="pointer ps-2" />
                                </button>
                            </h2>
                            <div
                                id="flush-collapseOne"
                                class="accordion-collapse border-0 collapse multi-collapse show"
                            >
                                <div
                                    class="accordion-body d-flex align-items-center justify-content-between pointer"
                                >
                                    <!-- Url -->
                                    <p class="m-0 text-truncate">
                                        {{ itemData.item.url }}
                                    </p>

                                    <!-- Button -->
                                    <button
                                        class="btn btn-sm btn-secondaryborder-0 text-light ms-2 p-0 px-1 outline-none shadow-none"
                                        style="background:var(--bs-indigo)"
                                    >
                                        Redirect
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div
                            class="accordion-item"
                            v-if="itemData.item && itemData.item.hasOwnProperty('description')"
                        >
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button
                                    class="accordion-button collapsed px-0 border-0 px-2 shadow-none"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo"
                                    aria-expanded="false"
                                    aria-controls="flush-collapseTwo"
                                >
                                    Description
                                </button>
                            </h2>
                            <div
                                id="flush-collapseTwo"
                                class="accordion-collapse border-0 collapse multi-collapse"
                            >
                                <div class="accordion-body force-wrap">
                                    {{ itemData.item.description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Fab from '../components/Stash/Fab.vue';
import addItem from '@/components/Stash/addItem';
import showItem from '@/components/Stash/showItem';
import addCard from '@/components/Stash/addCard';
import wholeCardRefresh from '@/components/Stash/wholeCardRefresh';

import MainCard from '@/components/Stash/MainCard.vue';
import draggable from 'vuedraggable';
import Const from '@/libs/Const';
import Back from '@/libs/Back';

import { useStore } from 'vuex';
import { ref, computed, reactive } from 'vue';

export default {
    name: 'two-lists',
    components: {
        draggable,
        MainCard,
        Fab
    },
    setup() {
        const store = useStore();

        //! Load Main Data
        store.dispatch('getMainData');

        // Main Data
        const MainDataShow = computed({
            get: () => store.getters.MainData,
            set: () => null
        });

        // Mixin
        const { newItemForm, addNewItemToCardInStore } = addItem; // Add new item
        const { itemData, openItemModal } = showItem; // Show item modal
        const { draggableKey } = wholeCardRefresh; // Add new card

        // Delete certain item
        const deleteItem = obj => store.dispatch('deleteItem', obj);

        // Update card index after single Drag
        const changeMain = ({ oldIndex, newIndex }) => {
            const card = store.getters.MainData[oldIndex];

            // Update card index in Backend
            Back.Service('/updateCardIndex', {
                cardId: card.id,
                oldIndex,
                newIndex
            });

            // Update card index in Store
            store.dispatch('updateCardPosition', { oldIndex, newIndex, card });
        };

        // For adding new card
        const cardData = reactive({
            id: null,
            data: null
        });

        const saveCardId = obj => {
            const { id, final } = obj;

            cardData.id = id;
            cardData.data = final;
        };

        return {
            store,
            MainDataShow,
            Const,
            deleteItem,
            draggableKey,
            itemData,
            openItemModal,
            changeMain,
            cardData,
            newItemForm,
            saveCardId,
            addNewItemToCardInStore
        };
    }
};
</script>
