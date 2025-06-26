<script setup>
import {onBeforeMount, onMounted, ref} from "vue";
import {useRoute, useRouter} from 'vue-router';
import { useProjectStore } from '../../stores/project.js';
import { useTaskStore } from '../../stores/task.js';
import { useUserStore } from '../../stores/user.js';
import {useQuasar} from "quasar";
import EditProjectDialog from "../../components/editProjectDialog.vue";

const $q = useQuasar();
const store = useProjectStore();
const taskStore = useTaskStore();
const userStore = useUserStore();
const route = useRoute();
const router = useRouter();

const openDialogEdit = ref(false);

const deleteProject = () => {
    $q.dialog({
        title: 'Supprimer le projet',
        message: `Êtes-vous sûr de vouloir supprimer le projet ${store.currentProject.title} ?`,
        cancel: true,
        persistent: true,
        ok: {
            label: 'Supprimer',
            color: 'negative'
        },
    }).onOk(async () => {
        await store.deleteProject(store.currentProject.id);
        router.push('/project');
    })
}

onMounted(() => {
    store.getProjectById(route.params.id)
    taskStore.getTasks(route.params.id);
});
</script>

<template>
    <div v-if="store.currentProject" class="q-ma-md">
        <div class="row items-center justify-between">
            <q-btn v-if="userStore.roles.includes('ROLE_ADMIN')" icon="delete" round color="negative" @click="deleteProject" />
            <div class="text-h2">Projet {{ store.currentProject.title }}</div>
            <q-btn v-if="userStore.roles.includes('ROLE_ADMIN')" icon="edit" round color="primary" @click="openDialogEdit = true" />
        </div>
        <div class="q-ma-md">
            <p>{{ store.currentProject.description }}</p>
        </div>
    </div>
    <div v-if="store.isloading" class="q-ma-md">
        <q-spinner-dots color="primary" size="50px" />
    </div>
    <q-scroll-area style="height: 500px">
        <q-item v-for="task in taskStore.tasks" :key="task.id" clickable>
            <q-item-section>
                <q-item-label>{{task.title}}</q-item-label>
                <q-item-label caption>{{ task.description }} </q-item-label>
                <q-item-label caption>{{ task.due_date }}</q-item-label>
            </q-item-section>
        </q-item>
    </q-scroll-area>
    <edit-project-dialog :openEditDialog="openDialogEdit" @close="openDialogEdit=false" :project="store.currentProject"/>
    <q-btn color="primary" to="/project" label="Retour" />
</template>
