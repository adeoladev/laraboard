import {createApp} from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';


const app = createApp({});

import Header from "./components/HeaderComponent.vue";

app.component('header-component', Header);

app.mount('#app');
app.use(VueAxios, axios);
