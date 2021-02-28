<template>
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
import shareCard from '@/components/globals/cards/shareCard';

export default {
    name: 'two-lists',
    setup() {
        const {
            shareCardData,
            copyValue,
            saveShareCardData,
            removeItemInShare,
            downloadTextPlain,
            copyItemShareData
        } = shareCard;

        return {
            // share modal
            shareCardData,
            saveShareCardData,
            removeItemInShare,
            copyItemShareData,
            copyValue,
            downloadTextPlain
        };
    }
};
</script>
