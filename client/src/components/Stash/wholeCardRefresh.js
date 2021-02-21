import { ref } from 'vue';

const draggableKey = ref('some random key');

const refresh = () => (draggableKey.value = `new random key ${Math.random() * 10}`);

export default { refresh, draggableKey };
