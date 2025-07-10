<script setup>
import {onMounted, ref, watch} from "vue";
import {useRoute, useRouter} from 'vue-router';
import { useProjectStore } from '../../stores/project.js';
import { useTaskStore } from '../../stores/task.js';
import { useUserStore } from '../../stores/user.js';
import { useQuasar} from "quasar";
import EditProjectDialog from "../../components/editProjectDialog.vue";
import TaskDialog from "../../components/taskDialog.vue";

import { useEventSource } from '@vueuse/core'
import ShareTaskDialog from "../../components/shareTaskDialog.vue";

const $q = useQuasar();
const store = useProjectStore();
const taskStore = useTaskStore();
const userStore = useUserStore();
const route = useRoute();
const router = useRouter();

const isPrinting = ref(false);

const openDialogEdit = ref(false);

const openTaskDialog = ref(false);
const taskDialogMode= ref('add');
const openShareDialog = ref(false);
const targetTaskId = ref(null);

const shareDialog = (id) => {
    targetTaskId.value = id;
    openShareDialog.value = true;
}

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

const addTaskDialog = () => {
    openTaskDialog.value = true;
    taskDialogMode.value = 'add';
}

const addTaskToProject = async (task) => {
    task.project = '/api/projects/' + route.params.id;
    task.status = '/api/statuses/'+ task.status.id;
    try{
        await taskStore.createTask(task)
        await taskStore.getTasks(route.params.id);
    } catch (error) {
        $q.notify({
            type: 'negative',
            message: 'Erreur lors de l\'ajout de la tâche'
        });
    }
    openTaskDialog.value = false;
}

const printProjectTasks = async () => {
    try {
        const response = await fetch(`/project/${route.params.id}/print-tasks`, {
            headers: {
                'Content-Type': 'application/json',
            },
        });
        const data = await response.json();
        $q.notify({
            type: 'info',
            position: 'top',
            message: data.message
        });
    } catch (error) {
        $q.notify({
            type: 'negative',
            position: 'top',
            message: error.message
        });
    }
}

onMounted(() => {
    store.getProjectById(route.params.id)
    taskStore.getTasks(route.params.id);
});

const { data: printStartData } = useEventSource(
    '/.well-known/mercure?topic=project_print_start',
    [],
    {
        autoReconnect: true
    }
)

const { data: printEndData } = useEventSource(
    '/.well-known/mercure?topic=project_print_end',
    [],
    {
        autoReconnect: true
    }
)
watch(printStartData, (data) => {
    isPrinting.value = true;
})
watch(printEndData, (data) => {
    data = JSON.parse(data);
    const { host } = window.location;
    isPrinting.value = false;
    window.open(`http://${host}/${data.pdf_path}`, '_blank');
})
</script>

<route lang="yaml">
meta:
    requireAuth: true
    roles:
        - ROLE_ADMIN
</route>

<template>
    <div v-if="store.currentProject" class="q-ma-md">
        <div class="row items-center justify-between">
            <q-btn v-if="userStore.roles.includes('ROLE_ADMIN')" icon="delete" round color="negative" @click="deleteProject" />
            <div class="text-h2">Projet {{ store.currentProject.title }}</div>
            <q-space />
            <q-btn class="q-mr-sm" v-if="userStore.roles.includes('ROLE_ADMIN')" :disabled="isPrinting" icon="print" :loading="isPrinting" round color="primary" @click="printProjectTasks" />
            <q-btn v-if="userStore.roles.includes('ROLE_ADMIN')" icon="edit" round color="primary" @click="openDialogEdit = true" />
        </div>
        <div class="q-ma-md">
            <p>{{ store.currentProject.description }}</p>
        </div>
    </div>
    <div v-if="store.isloading" class="q-ma-md">
        <q-spinner-dots color="primary" size="50px" />
    </div>
    <q-btn icon="add" color="primary" label="Ajouter une tâche" v-if="userStore.roles.includes('ROLE_ADMIN')" @click="addTaskDialog"/>
    <q-scroll-area style="height: 500px">
        <q-item v-for="task in taskStore.tasks" :key="task.id" clickable>
            <q-item-section>
                <q-item-label>{{task.title}}</q-item-label>
                <q-item-label caption>{{ task.description }} </q-item-label>
                <q-item-label caption>{{ task.due_date }}</q-item-label>
            </q-item-section>
            <q-item-section side>
                <q-btn icon="share" round color="primary" @click="shareDialog(task.id)" />
            </q-item-section>
        </q-item>
        <q-item v-if="taskStore.tasks.length === 0" clickable>
            <q-item-section>
                <q-item-label>Aucune tâche pour ce projet</q-item-label>
            </q-item-section>
        </q-item>
    </q-scroll-area>
    <task-dialog :openTaskDialog :taskDialogMode @addTask="addTaskToProject" @close="openTaskDialog= false" ></task-dialog>
    <edit-project-dialog :openEditDialog="openDialogEdit" @close="openDialogEdit=false" :project="store.currentProject"/>
    <q-btn color="primary" to="/project" label="Retour" />
    <share-task-dialog :open-dialog="openShareDialog" :id-task="targetTaskId" @close="openShareDialog = false"/>
</template>
