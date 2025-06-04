<script setup>
import {onMounted} from "vue";
import { useRoute } from 'vue-router';
import { useProjectStore } from '../../stores/project.js';
import { useTaskStore } from '../../stores/task.js';

const store = useProjectStore();
const taskStore = useTaskStore();
const route = useRoute();

onMounted(() => {
    if (!store.currentProject) {
        store.getProjectById(route.params.id)
    }
    taskStore.getTasks(route.params.id);
    console.log(taskStore.tasks);
});
</script>

<template>
    <div v-if="store.currentProject" class="q-ma-md">
        <div class="q-ma-md">
            <h1>Projet {{ store.currentProject.title }}</h1>
        </div>
        <div class="q-ma-md">
            <p>{{ store.currentProject.description }}</p>
        </div>
        <div class="q-ma-md">
            <q-btn color="primary" to="/project" label="Retour" />
        </div>
    </div>
    <div v-if="store.isloading" class="q-ma-md">
        <q-spinner-dots color="primary" size="50px" />
    </div>
    <ul>
        <li v-for="task in taskStore.tasks" :key="task.id">
            {{ task.description }} - {{ task.due_date }}
        </li>
    </ul>
</template>