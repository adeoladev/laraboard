import {createApp} from 'vue';
const app = createApp({});

import Header from "./components/HeaderComponent.vue";

app.component('header-component', Header);

app.mount('#app');
