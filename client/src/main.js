import { createApp } from 'vue';
import App from './App.vue';
import router from './router/router';
import store from './store';
import axios from 'axios';

// router guard
import '@/router/routeGuard';

// Global css
import '@/assets/global.css';
import Back from './libs/Back';

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000';

createApp(App)
    .use(store)
    .use(router)
    .mount('#app');

/*
    ! trello
    https://trello.com/b/yMcCyZmI/sssss#

    !draggable
    https://github.com/SortableJS/vue.draggable.next

    TODO

    ( ) archive
*/
