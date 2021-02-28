<template>
    <div class="whole-shea-horizontal-scroll mt-2 pt-2 ps-4" :key="draggableKey">
        <template v-for="el in MainDataShow">
            <Card
                v-if="MainDataShow.length"
                :elementProp="el"
                :key="`archive-card-${el.id}`"
                @openShareCardModalEvent="saveShareCardData($event)"
            />
        </template>
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
import Card from '@/components/archive/Card.vue';
import wholeCardRefresh from '@/components/globals/cards/wholeCardRefresh';
import shareCard from '@/components/globals/cards/shareCard';
import { useStore } from 'vuex';
import { computed } from 'vue';

export default {
    components: {
        Card
    },
    setup() {
        const store = useStore();
        store.dispatch('getMainDataArchive'); // Load Main Data !

        const MainDataShow = computed({
            get: () => store.getters.MainData,
            set: () => null
        });

        const { draggableKey } = wholeCardRefresh;

        const {
            shareCardData,
            copyValue,
            saveShareCardData,
            removeItemInShare,
            downloadTextPlain,
            copyItemShareData
        } = shareCard;

        return {
            MainDataShow,
            draggableKey,
            shareCardData,
            copyValue,
            saveShareCardData,
            removeItemInShare,
            downloadTextPlain,
            copyItemShareData
        };
    }
};
</script>
