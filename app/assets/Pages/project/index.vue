<script setup>
import {onMounted, ref} from "vue";
import ProjectList from "../../components/ProjectList.vue";
import {useProjectStore} from "../../stores/project.js";
import CreateProjectDialog from "../../components/createProjectDialog.vue";
const projectStore = useProjectStore();
const openDialog = ref(false);
onMounted(() => {
  projectStore.getProjects();
});

const createProject = (project) => {
  projectStore.createProject(project).then(() => {
    openDialog.value = false;
  })
};
</script>

<route lang="json">
{
  "name": "projects"
}
</route>

<template>
  <q-card-section class="row justify-between">
    <q-btn @click="projectStore.getProjects()" color="secondary" icon="refresh" rounded />
    <div class="text-h2">Bienvenue dans la liste des projets</div>
    <q-btn @click="openDialog = true" color="primary" icon="add" rounded />
  </q-card-section>
  <q-separator inset/>
  <q-card-section>
    <p v-if="projectStore.isLoading">Chargement en cours...</p>
    <project-list v-if="!projectStore.isLoading" :projects="projectStore.projects"></project-list>
  </q-card-section>
  <create-project-dialog :openDialog @create="createProject" @close="openDialog=false"/>
</template>