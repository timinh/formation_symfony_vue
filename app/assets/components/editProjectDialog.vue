<script setup>
import {ref, watch} from "vue";
import {useProjectStore} from "../stores/project.js";
const props = defineProps({
    openEditDialog: {
        type: Boolean,
        required: true
    },
    project: {
        type: Object,
        required: true
    }
})

const newProject = ref({
    id: null,
    title: '',
    description: ''
});

const titleRules = [
    val => !!val || 'Le titre est requis',
];

const descriptionRules = [
    val => !!val || 'La description est requise',
];

const openDialog = ref(false);
const store = useProjectStore();

const $emit = defineEmits(['close']);

const editProject = async () => {
    await store.updateProject(newProject.value);
    $emit('close');
}

watch(() => props.openEditDialog, (newVal) => {
    openDialog.value = props.openEditDialog
    if(newVal) {
        newProject.value = props.project;
    }
})
</script>

<template>
<q-dialog v-model="openDialog">
    <q-card style="width: 600px">
        <q-card-section>
            <div class="text-h4">Modifier mon projet</div>
        </q-card-section>
        <q-card-section>
            <q-form ref="editForm">
                <q-input v-model="newProject.title" label="Titre du projet" :rules="titleRules" />
                <q-input v-model="newProject.description" label="Description du projet" type="textarea" :rules="descriptionRules"/>
            </q-form>
        </q-card-section>
        <q-card-actions class="row justify-between">
            <q-btn color="secondary" label="Annuler" @click="$emit('close')" />
            <q-btn color="primary" label="Enregistrer" @click="editProject" />
        </q-card-actions>
    </q-card>
</q-dialog>
</template>

<style scoped>

</style>
