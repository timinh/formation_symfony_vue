<script setup>
import {onMounted, ref, watch} from "vue";
import {useStatusStore} from "../stores/status.js";

const props = defineProps({
    openTaskDialog: {
        type: Boolean,
        default: false
    },
    taskDialogMode: {
        type: String,
        default: 'add'
    }
})

const openDialog = ref(false);
const taskTitle = ref('');
const taskDescription = ref('');
const startDate = ref('');
const endDate = ref('');
const titleDialog = ref('Ajouter une tâche');
const selectedStatus = ref(null);
const status = ref([]);
const statusStore = useStatusStore();

const $emit = defineEmits(['addTask', 'close']);
const addTask = () => {
    const task = {
        title: taskTitle.value,
        description: taskDescription.value,
        startDate: startDate.value,
        endDate: endDate.value,
        status: selectedStatus.value
    }

    $emit('addTask', task);
}

const getOpenTaskDialog = () => {
    return props.openTaskDialog;
}

onMounted(() => {
    openDialog.value = props.openTaskDialog;
    if(statusStore.statuses.length === 0) {
        statusStore.getStatus();
    }
})

watch(getOpenTaskDialog, (newVal) => {
    openDialog.value = newVal;
    if (props.taskDialogMode === 'add') {
        titleDialog.value = 'Ajouter une tâche';
        taskTitle.value = '';
        taskDescription.value = '';
        startDate.value = '';
        endDate.value = '';
    } else {
        titleDialog.value = 'Modifier la tâche';
    }
})
</script>

<template>
    <q-dialog v-model="openDialog">
        <q-card style="width: 600px">
            <q-card-section>
                <div class="text-h5">{{titleDialog}}</div>
            </q-card-section>
            <q-card-section>
                <q-form class="q-gutter-md">
                    <q-input filled v-model="taskTitle" label="Titre de la tâche" />
                    <q-input filled v-model="taskDescription" label="Description de la tâche" type="textarea" />
                    <q-input filled v-model="startDate" label="Date de début" type="date" />
                    <q-input filled v-model="endDate" label="Date de fin" type="date" />
                    <q-select v-model="selectedStatus" :options="statusStore.statuses" label="Statut de la tâche" option-value="id" option-label="libelle" filled />
                </q-form>
            </q-card-section>
            <q-card-actions class="row justify-between">
                <q-btn color="secondary" label="Annuler" @click="$emit('close')" />
                <q-btn color="primary" label="Ajouter" @click="addTask" />
            </q-card-actions>
        </q-card>
    </q-dialog>
</template>

<style scoped>

</style>
