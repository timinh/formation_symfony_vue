import "./app.css";
import { createApp } from "vue";
import App from "./App.vue";
import {createRouter, createWebHistory} from "vue-router";
import {createPinia} from "pinia";

const routes = [
    {
        path: "/",
        name: "home",
        component: () => import("./Pages/index.vue")
    },
    {
        path: "/project/:id",
        name: "projectPage",
        component: () => import("./Pages/project.vue")
    }
]

const routerHistory = createWebHistory();
const router = createRouter({
    history: routerHistory,
    routes
});

const pinia = createPinia();

const app = createApp(App);
app.use(router);
app.use(pinia);
app.mount("#app");