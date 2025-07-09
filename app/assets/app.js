import './app.css';
import { createApp } from 'vue';
import { createPinia } from "pinia";
import App from './App.vue';
import {createRouter, createWebHistory} from "vue-router/auto";
import { routes } from 'vue-router/auto-routes';
import {Dialog, Notify, Quasar} from 'quasar';
import { useRequiresRoleMiddleware } from './composition/use-requires-role-middleware';

// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css'

// Import Quasar css
import 'quasar/src/css/index.sass'

const router = createRouter({
    history: createWebHistory(),
    routes
})
const pinia = createPinia();
const app = createApp(App);
app.use(router);
app.use(pinia);
app.use(Quasar, {
    plugins: {Notify, Dialog},
})
app.mount('#app');

useRequiresRoleMiddleware(router);
