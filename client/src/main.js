import { createApp } from 'vue';
import App from './App.vue';
import router from './router/router';
import store from './store';
import axios from 'axios';
import { VueClipboard } from '@soerenmartius/vue3-clipboard';

// router guard
import '@/router/routeGuard';

// Global css
import '@/assets/global.css';

axios.defaults.withCredentials = true;
axios.defaults.baseURL = 'http://localhost:8000';

createApp(App)
    .use(store)
    .use(VueClipboard)
    .use(router)
    .mount('#app');

/*
    ! trello
    https://trello.com/b/yMcCyZmI/sssss#

    !draggable
    https://github.com/SortableJS/vue.draggable.next

    TODO

    (+) create item 
    (+) show item
    (+) delete item
    (+) update item

    (+) create card
    (+) show card
    (+) update card
    (+) delete card 
    
    (+) open link
    (+) after add neew item everything must refresh or at least card !!!!
    (+) validate add new item (don't allow empty name and url)
    (+) delete doesnt work after adding card and dragging any card
*/
