import './app.css';
import { createApp } from 'vue';
import App from './App.vue';
import {createRouter, createWebHistory} from "vue-router";
import index from "./pages/index.vue";
import project from "./pages/project/project.vue";
import {Dialog, Notify, Quasar} from 'quasar';

// Import icon libraries
import '@quasar/extras/material-icons/material-icons.css'

// Import Quasar css
import 'quasar/src/css/index.sass'


let routes = [
    {
        path: '/',
        name: 'home',
        component: index
    },
    {
        path: '/project',
        name: 'projectPage',
        component: project
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

const app = createApp(App);
app.use(router);
app.use(Quasar, {
    plugin: {Notify, Dialog}
})
app.mount('#app');

console.log('App is running!');
