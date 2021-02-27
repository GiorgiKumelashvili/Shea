<template>
    <div class="card pointer d-inline-block card-custom">
        <div class="card-body p-0 d-flex flex-column justify-content-between">
            <!-- Top half -->
            <div :class="Const.betweenClass" class="p-2">
                <h5 class="card-title m-0 flex-grow-1 text-truncate">
                    {{ final.name }}
                </h5>

                <div class="dropdown" style="z-index:1">
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
                        <li>
                            <p
                                class="dropdown-item m-0"
                                @click="emitOpenShareCardModalEvent(final)"
                                data-bs-toggle="modal"
                                data-bs-target="#OpenShareModal"
                            >
                                Share
                            </p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Middle half -->
            <div class="list-group flex-grow-1 card-scrollbar px-2">
                <div class="list-group-item mb-2 p-2" v-for="el in final.child" :key="el.id">
                    <!-- Title -->
                    <p
                        class="m-0 force-wrap"
                        data-bs-toggle="collapse"
                        aria-expanded="false"
                        :data-bs-target="`#flush-collapse-${el.id}`"
                        :aria-controls="`flush-collapse-${el.id}`"
                    >
                        {{ el.name }}
                    </p>

                    <!-- Link fab -->
                    <img
                        :src="Const.svgs.Link"
                        class="p-1 rounded cust"
                        @click="Func.OpenLink(el.url)"
                    />

                    <!-- Main body -->
                    <div
                        :id="`flush-collapse-${el.id}`"
                        class="accordion-collapse collapse multi-collapse border-0 pt-2"
                    >
                        <div class="accordion-body p-0">
                            <!-- Url -->
                            <div class="pointer force-wrap-2">
                                Url :
                                <a class="m-0 text-decoration-none" :href="el.url">
                                    {{ el.url }}
                                </a>
                            </div>

                            <div class="pointer force-wrap-2 py-3" v-if="el.description">
                                Description :
                                {{ el.description }}
                            </div>

                            <!-- Buttons -->
                            <div
                                class="d-flex justify-content-end"
                                :class="{ 'pt-3': !el.description }"
                            >
                                <button
                                    class="me-1 btn btn-sm btn-primary border-0 text-light p-0 px-1 outline-none shadow-none"
                                    @click="Func.OpenLink(el.url)"
                                >
                                    <img :src="Const.svgs.Link_Light" class="rounded" />
                                    Redirect
                                </button>
                                <button
                                    class="btn btn-sm btn-danger border-0 text-light p-0 px-1 outline-none shadow-none"
                                    @click="Func.OpenLink(el.url)"
                                >
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- [End] Main body -->
                </div>
            </div>
            <!-- [End] Middle half -->
        </div>
        <!-- [End] Card body -->
    </div>
</template>

<script>
// Cards
import deleteCard from '@/components/Stash/cards/deleteCard';
import updateCard from '@/components/Stash/cards/updateCard';

// Items
import moveItemBackend from '@/components/Stash/items/moveItemBackend';

// Helpers
import Const from '@/libs/Const';
import Func from '@/libs/Func';

// Globals
import { useStore } from 'vuex';
import { ref, watch } from 'vue';

export default {
    name: 'two-lists',

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
        const { updateCardName, focusInput } = updateCard;

        // Update card name
        const CardNameInput = ref(false);
        const showCardNameInput = () => (CardNameInput.value = true);
        const closeCardNameInput = () => (CardNameInput.value = false);

        // emit click events
        const emitOpenItemModalEvent = obj => ctx.emit('openItemModalEvent', obj);
        const emitAddNewItemModal = id => ctx.emit('addNewItemModalEvt', { id, final });
        const emitOpenShareCardModalEvent = obj => ctx.emit('openShareCardModalEvent', obj);

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
            showCardNameInput,
            closeCardNameInput,
            focusInput,
            Const,
            deleteCertainCard,
            emitOpenItemModalEvent,
            emitOpenShareCardModalEvent,
            emitAddNewItemModal,
            Func,
            CardNameInput,
            final,
            updateCardName
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
    max-height: 83vh;
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
