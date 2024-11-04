import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js';

import { createApp } from 'vue';
import axios from 'axios';
import MemoryCardCreate from './components/Create.vue';
import MemoryCardView from './components/View.vue';
import MemoryCardMenu from './components/Menu.vue';
import MemoryCardImport from './components/Import.vue';
import MemoryCardConfirm from './components/Confirm.vue';
import MemoryCardGroups from './components/Groups.vue';

const app = createApp({});
app.config.globalProperties.$trans = JSON.parse(document.getElementById('app').dataset.trans);
app.config.globalProperties.$axios = axios;
app.config.globalProperties.$bootstrap = bootstrap;

app.component('memory-card-create', MemoryCardCreate);
app.component('memory-card-view', MemoryCardView);
app.component('memory-card-menu', MemoryCardMenu);
app.component('memory-card-import', MemoryCardImport);
app.component('memory-card-confirm', MemoryCardConfirm);
app.component('memory-card-groups', MemoryCardGroups);

app.mount('#app');
