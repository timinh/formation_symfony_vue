<script setup>
import {onMounted, ref} from "vue";
import {api} from "../../api/Api.js";
import ProjectList from "../../components/projectList.vue";
import {useProjectStore} from "../../stores/project.js";
import {useUserStore} from "../../stores/user.js";

const store = useProjectStore();
const userStore = useUserStore();

const createProjectDialog = ref(false);
const newProject = ref({
    title: '',
    description: ''
})
const projectForm = ref(null);

const rules = [
    val => !!val || 'Le titre est requis',
]

const createProject = async () => {
    projectForm.value.validate().then(async (success) => {
        await store.createProject(newProject.value)
        createProjectDialog.value = false;
        await store.getProjects();
    })
}

onMounted(() => {
    store.getProjects()
})

</script>
<route lang="json">
{
    "name": "projectPage"
}
</route>
<template>
    <div class="row items-center justify-between q-ma-lg">
        <q-btn icon="refresh" round  @click="store.getProjects" color="secondary"/>
        <div class="text-h2">Liste de mes projets</div>
        <q-btn v-if="userStore.roles.includes('ROLE_ADMIN')" color="primary" icon="add" round @click="createProjectDialog = true" />
    </div>
    <div>
        <project-list :projects="store.projects"/>
    </div>
    <q-dialog v-model="createProjectDialog" persistent>
        <q-card style="width: 600px">
            <q-card-section>
                <div class="text-h4">Créer un projet</div>
            </q-card-section>
            <q-card-section>
                <q-form ref="projectForm">
                    <q-input v-model="newProject.title" label="Titre du projet" :rules="rules" />
                    <q-input v-model="newProject.description" label="Description du projet" type="textarea"/>
                </q-form>
            </q-card-section>
            <q-card-actions class="row justify-between">
                <q-btn color="secondary" label="Annuler" @click="createProjectDialog = false" />
                <q-btn color="primary" label="Créer" @click="createProject" />
            </q-card-actions>
        </q-card>
    </q-dialog>

</template>

<style scoped>

</style>
