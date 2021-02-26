<template>
    <!-- [Fab] of Add New Card -->
    <button
        class="btn rounded-circle custom-add-icon"
        data-bs-toggle="modal"
        data-bs-target="#OpenAddCardModal"
    >
        <img :src="Const.svgs.plus" />
    </button>

    <!-- [Modal] of Add New Card -->
    <div
        class="modal fade"
        id="OpenAddCardModal"
        tabindex="-1"
        aria-labelledby="OpenAddCardModal"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-1">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="OpenAddCardModal">
                        Modal title
                    </h5>
                    <img
                        :src="Const.svgs.xCircle"
                        class="pointer p-2"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    />
                </div>
                <div class="modal-body py-2">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Card Name"
                        aria-label="Card Name"
                        v-model="cardName"
                    />
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">
                        Discard
                    </button>
                    <button
                        type="button"
                        :class="{ disabled: !cardName }"
                        class="btn btn-primary btn-sm"
                        data-bs-dismiss="modal"
                        @click="addNewCard()"
                    >
                        Add New Card
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import addCard from '@/components/Stash/cards/addCard.js';
import Const from '@/libs/Const';

export default {
    setup() {
        const { cardName, addNewCard } = addCard; // Add new card

        return {
            cardName,
            addNewCard,
            Const
        };
    }
};
</script>

<style scoped>
.custom-add-icon {
    position: fixed;
    bottom: 40px;
    right: 40px;

    width: 3.4rem;
    height: 3.4rem;

    background-image: var(--main-gradient);
}
</style>
