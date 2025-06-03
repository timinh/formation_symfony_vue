import './app.css';

import { createApp } from 'vue';
import App from './App.vue';
import {createRouter, createWebHistory} from "vue-router";
import index from "./pages/index.vue";
import project from "./pages/project/project.vue";

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
app.mount('#app');

console.log('App is running!');
