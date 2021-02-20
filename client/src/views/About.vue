<template>
    <draggable class="d-flex mover" :list="bigList" group="peoplex" itemKey="name">
        <template #item="{ element }">
            <div class="list-group-item">
                <div class="col-12 bg-dark border border-2 border-success">
                    <h3 class="text-white">{{ element.name }}</h3>
                    <draggable
                        class="list-group"
                        :list="element.child"
                        group="people"
                        itemKey="name"
                    >
                        <template #item="{ element }">
                            <div class="list-group-item">{{ element.name }}</div>
                        </template>
                    </draggable>
                </div>
            </div>
        </template>
    </draggable>
</template>

<script>
import draggable from 'vuedraggable';
import { ref } from 'vue';

export default {
    name: 'two-lists',
    components: {
        draggable
    },
    setup() {
        const bigList = ref([
            {
                name: 'big list 1',
                id: 101,
                child: [
                    { name: 'John', id: 1 },
                    { name: 'Joao', id: 2 },
                    { name: 'Jean', id: 3 },
                    { name: 'Gerard', id: 4 }
                ]
            },
            {
                name: 'big list 2',
                id: 102,
                child: [
                    { name: 'Juan', id: 5 },
                    { name: 'Edgard', id: 6 },
                    { name: 'Johnson', id: 7 }
                ]
            },
            {
                name: 'big list 3',
                id: 103,
                child: [
                    { name: 'gio', id: 8 },
                    { name: 'gel', id: 9 },
                    { name: 'jemala', id: 10 }
                ]
            },
            {
                name: 'big list 4',
                id: 104,
                child: [
                    { name: 'Jena', id: 11 },
                    { name: 'nino', id: 12 },
                    { name: 'malaa', id: 13 }
                ]
            }
        ]);

        return { bigList };
    }
};
</script>
