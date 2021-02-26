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
                @openShareCardModalEvent="saveShareCardData($event)"
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
                        :disabled="!newItemForm.name || !newItemForm.url"
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
        id="OpenItemModal"
        tabindex="-1"
        aria-labelledby="OpenItemModal"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content rounded-1">
                <div class="modal-header">
                    <h5 class="modal-title text-truncate" id="OpenItemModal">
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
                                    deleteCertainItem({
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
                    <!-- Item name -->
                    <div v-if="itemData.item && itemData.item.hasOwnProperty('name')">
                        <h4
                            class="text-center font-monospace m-0 py-3 pointer"
                            @click="
                                focusItemInputName(itemData.item.id);
                                showItemNameInput();
                            "
                            v-if="!ItemNameInput"
                        >
                            {{ itemData.item.name[0].toUpperCase() + itemData.item.name.slice(1) }}
                        </h4>

                        <input
                            type="text"
                            placeholder="Name"
                            class="form-control my-3 py-2"
                            v-model="itemData.item.name"
                            :class="{ 'd-none': !ItemNameInput }"
                            :id="'item-name-input-' + itemData.item.id"
                            @keyup.enter="
                                updateItemName(itemData.item.id, itemData.item.name);
                                closeItemNameInput();
                            "
                            @blur="closeItemNameInput()"
                        />
                    </div>

                    <!-- Item properties -->
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <!-- Url -->
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
                                    <div class="text-truncate pointer flex-grow-1">
                                        <!--//!  Url body -->
                                        <p
                                            class="m-0 text-truncate pointer"
                                            @click="
                                                focusItemInputUrl(itemData.item.id);
                                                showItemUrlInput();
                                            "
                                            v-if="!ItemUrlInput"
                                        >
                                            {{ itemData.item.url }}
                                        </p>

                                        <input
                                            type="text"
                                            placeholder="Name"
                                            class="form-control"
                                            v-model="itemData.item.url"
                                            :class="{ 'd-none': !ItemUrlInput }"
                                            :id="'item-url-input-' + itemData.item.id"
                                            @keyup.enter="
                                                updateItemUrl(itemData.item.id, itemData.item.url);
                                                closeItemUrlInput();
                                            "
                                            @blur="closeItemUrlInput()"
                                        />
                                    </div>

                                    <!-- Button -->
                                    <button
                                        class="btn btn-sm btn-secondaryborder-0 text-light ms-2 p-0 px-1 outline-none shadow-none"
                                        style="background:var(--bs-indigo)"
                                        @click="Func.OpenLink(itemData.item.url)"
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

    <!-- [Modal] Show Share -->
    <div
        class="modal fade force-wrap"
        id="OpenShareModal"
        tabindex="-1"
        aria-labelledby="OpenShareModal"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content rounded-1">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title text-truncate" id="OpenShareModal">
                        Share Your List
                    </h5>
                </div>

                <div class="modal-body">
                    <div class="d-flex justify-content-end gap-1">
                        <!--------->
                        <span
                            class="badge pointer rounded-pill bg-primary"
                            @click.stop.prevent="copyItemShareData()"
                        >
                            Copy
                            <textarea
                                class="visually-hidden"
                                :value="copyValue"
                                id="copy-item-share"
                            ></textarea>
                        </span>
                        <span
                            class="badge pointer rounded-pill bg-success"
                            @click="downloadTextPlain()"
                        >
                            Text document
                        </span>
                        <!-- <span class="badge pointer rounded-pill bg-danger">
                            Pdf
                        </span> -->
                        <!--------->
                    </div>

                    <div class="card my-3">
                        <!-- Card name -->
                        <div class="card-body">
                            <h5 class="card-title">
                                {{ shareCardData?.name }}
                            </h5>
                        </div>

                        <!-- Item names and links -->
                        <ul
                            class="list-group list-group-flush"
                            v-if="
                                shareCardData && shareCardData.child && shareCardData.child.length
                            "
                        >
                            <li
                                class="list-group-item d-flex align-items-center justify-content-between"
                                v-for="obj in shareCardData.child"
                                :key="'shareable-item-' + obj.id"
                            >
                                <!-- Individual Item -->
                                <div class="p-0 m-0 text-truncate">
                                    {{ obj?.name }}

                                    <a href="#" class="card-link ps-2" v-if="obj.url">
                                        {{ obj.url }}
                                    </a>
                                </div>

                                <!-- Remove item for share -->
                                <button
                                    type="button"
                                    class="btn-close ms-4"
                                    aria-label="Close"
                                    @click="removeItemInShare(obj.id)"
                                />
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Items
import addItem from '@/components/Stash/addItem';
import showItem from '@/components/Stash/showItem';
import updateItem from '@/components/Stash/updateItem';
import deleteItem from '@/components/Stash/deleteItem';

// Cards
import wholeCardRefresh from '@/components/Stash/wholeCardRefresh';
import moveCardBackend from '@/components/Stash/moveCardBackend';
import shareCard from '@/components/Stash/shareCard';

// Components
import MainCard from '@/components/Stash/MainCard.vue';
import Fab from '@/components/Stash/Fab.vue';

// Helpers
import Const from '@/libs/Const';
import Func from '@/libs/Func';

// Globals
import draggable from 'vuedraggable';
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
        store.dispatch('getMainData'); // Load Main Data !

        const MainDataShow = computed({
            get: () => store.getters.MainData,
            set: () => null
        });

        // Item Mixins (Add, Show, Update, Delete)
        const { newItemForm, addNewItemToCardInStore } = addItem;
        const { itemData, openItemModal } = showItem;
        const { focusItemInputName, updateItemName, focusItemInputUrl, updateItemUrl } = updateItem;
        const { deleteCertainItem } = deleteItem;

        // Card Mixins (Update)
        const { draggableKey } = wholeCardRefresh;
        const { changeMain } = moveCardBackend;
        const {
            shareCardData,
            copyValue,
            saveShareCardData,
            removeItemInShare,
            downloadTextPlain,
            copyItemShareData
        } = shareCard;

        // Add New Card
        const cardData = reactive({
            id: null,
            data: null
        });

        const saveCardId = obj => {
            const { id, final } = obj;

            cardData.id = id;
            cardData.data = final;
        };

        // For Updating item name
        const ItemNameInput = ref(false);
        const showItemNameInput = () => (ItemNameInput.value = true);
        const closeItemNameInput = () => (ItemNameInput.value = false);

        // For Updating item url
        const ItemUrlInput = ref(false);
        const showItemUrlInput = () => (ItemUrlInput.value = true);
        const closeItemUrlInput = () => (ItemUrlInput.value = false);

        return {
            // share modal
            shareCardData,
            saveShareCardData,
            removeItemInShare,
            copyItemShareData,
            copyValue,
            downloadTextPlain,

            // rest
            store,
            MainDataShow,
            Const,
            deleteCertainItem,
            draggableKey,
            itemData,
            openItemModal,
            changeMain,
            cardData,
            newItemForm,
            saveCardId,
            Func,
            addNewItemToCardInStore,

            //! new
            ItemNameInput,
            focusItemInputName,
            showItemNameInput,
            updateItemName,
            closeItemNameInput,

            ItemUrlInput,
            focusItemInputUrl,
            showItemUrlInput,
            updateItemUrl,
            closeItemUrlInput
        };
    }
};
</script>
