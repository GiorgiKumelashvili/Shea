<template>
    <div class="card pointer d-inline-block card-custom">
        <div class="card-body p-0 d-flex flex-column justify-content-between">
            <!-- Top half -->
            <div
                :class="Const.betweenClass"
                class="px-2 pt-2"
                @click="
                    showCardNameInput = true;
                    showInput(final.id, showCardNameInput);
                "
                v-if="!showCardNameInput"
            >
                <h5 class="card-title m-0 flex-grow-1 text-truncate">
                    {{ final.name }}
                </h5>

                <div class="dropdown" style="z-index:900">
                    <img
                        :src="Const.svgs.settings"
                        class="icon-hover p-2 rounded"
                        id="dropdownMenuOffset"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                    />

                    <ul
                        class="dropdown-menu dropdown-menu-dark"
                        aria-labelledby="dropdownMenuOffset"
                    >
                        <li @click="deleteCertainCard(final.id)">
                            <p class="dropdown-item m-0">
                                Delete
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="d-flex p-2" :class="{ 'd-none': !showCardNameInput }">
                <input
                    class="form-control py-1 px-2"
                    :id="'name-input-' + final.id"
                    v-model="final.name"
                    type="text"
                    placeholder="Name"
                    @keyup.enter="
                        updateCertainCardName(final.id, final.name);
                        closeInput();
                    "
                    @blur="closeInput()"
                />
            </div>

            <!-- Middle half -->
            <draggable
                class="my-1 list-group flex-grow-1 card-scrollbar px-2"
                :list="final.child"
                group="list-of-items"
                itemKey="list-of-items"
                v-bind="Const.ItemDragOption"
                @add="moveItemToNewCard($event, final)"
                @remove="removeItemFromOldCard($event, final)"
                @end="moveItemInside($event, final)"
            >
                <template #item="{ element }">
                    <div class="list-group-item mb-2 p-2">
                        <p
                            class="m-0"
                            @click="emitOpenItemModalEvent({ Parent: final.id, Child: element.id })"
                            data-bs-toggle="modal"
                            data-bs-target="#OpenCardModal"
                        >
                            {{ element.name }}
                        </p>

                        <img
                            :src="Const.svgs.Link"
                            class="p-1 rounded cust"
                            @click="goToLink(element.url)"
                        />
                    </div>
                </template>
            </draggable>

            <!-- Bottom Half -->
            <div
                class="icon-hover d-flex align-items-center flex-grow-1 p-1 m-2"
                @click="emitAddNewItemModal(final.id)"
                data-bs-toggle="modal"
                data-bs-target="#AddNewItemModal"
            >
                <img :src="Const.svgs.plus" class="icon-hover rounded" />
                <p class="m-0">Add another item</p>
            </div>
        </div>
    </div>
</template>

<script>
import deleteCard from '@/components/Stash/deleteCard';
import updateCardName from '@/components/Stash/updateCardName';
import moveItemBackend from '@/components/Stash/moveItemBackend';

import draggable from 'vuedraggable';
import Const from '@/libs/Const';

import { useStore } from 'vuex';
import { ref, watch } from 'vue';

export default {
    name: 'two-lists',
    components: {
        draggable
    },
    props: {
        elementProp: {
            type: Object,
            required: true
        }
    },
    setup(props, ctx) {
        const store = useStore();
        const final = ref(JSON.parse(JSON.stringify(props.elementProp)));
        const { moveItemInside, moveItemToNewCard, removeItemFromOldCard } = moveItemBackend;
        const { deleteCertainCard } = deleteCard;

        // Update card name
        const { updateCertainCardName, showInput } = updateCardName;
        const showCardNameInput = ref(false);
        const closeInput = () => (showCardNameInput.value = false);

        // emit click events
        const emitOpenItemModalEvent = obj => ctx.emit('openItemModalEvent', obj);
        const emitAddNewItemModal = id => ctx.emit('addNewItemModalEvt', { id, final });

        // Go to link
        const goToLink = url => window.open(url);

        // Update card children by watching dragging in vuex
        watch(final.value.child, newVal => {
            const index = store.getters.findCardIndexById(final.value.id);
            const newChildren = JSON.parse(JSON.stringify(newVal));

            store.dispatch('updateItemPosition', { newChildren, index });
        });

        return {
            moveItemInside,
            moveItemToNewCard,
            removeItemFromOldCard,
            closeInput,
            showInput,
            Const,
            deleteCertainCard,
            emitOpenItemModalEvent,
            emitAddNewItemModal,
            goToLink,
            showCardNameInput,
            final,
            updateCertainCardName
        };
    }
};
</script>

<style scoped>
.ghost {
    opacity: 0.3;
    background: #f2e6ff;
}

.cust {
    position: absolute;
    top: 5px;
    right: 5px;
    z-index: 100;

    transition: 0.5s;
    opacity: 0;
}

.cust:hover {
    opacity: 1;
    transition: 0.5s;
    background-color: rgb(200, 200, 200);
}

.list-group-item:hover .cust {
    opacity: 1;
    transition: 0.5s;
}

.card-scrollbar {
    max-height: 78vh;
    overflow: auto;
}

.card-scrollbar::-webkit-scrollbar {
    width: 1em;
}

.card-scrollbar::-webkit-scrollbar-track {
    background: #ebecf0;
}

.card-scrollbar::-webkit-scrollbar-thumb {
    background-color: #bec3cd;
    border-radius: 10px;

    background-clip: padding-box;
    border: 4px solid rgba(0, 0, 0, 0);
}
.card-scrollbar::-webkit-scrollbar-thumb:hover {
    background-color: #8f939b;
}

.card-scrollbar::-webkit-scrollbar-corner {
    background-color: transparent;
}

.card-scrollbar::-webkit-scrollbar-button {
    display: none;
}
</style>
