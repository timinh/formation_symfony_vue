import "./app.css";
import { createApp } from "vue";
import App from "./App.vue";
import { createRouter, createWebHistory } from 'vue-router'
import { routes } from 'vue-router/auto-routes'
import {createPinia} from "pinia";
import {Dialog, Notify, Quasar} from 'quasar'
import quasarLang from 'quasar/lang/fr'


// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css'
import quasarIconSet from 'quasar/icon-set/svg-material-icons'
// Import Quasar css
import 'quasar/src/css/index.sass'

const routerHistory = createWebHistory();
const router = createRouter({
    history: routerHistory,
    routes
});

const pinia = createPinia();

const app = createApp(App);
app.use(router);
app.use(pinia);
app.use(Quasar, {
    plugins: {Notify, Dialog}, // import Quasar plugins and add here
    lang: quasarLang,
    iconSet: quasarIconSet,
});
app.mount("#app");