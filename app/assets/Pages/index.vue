<script setup>
import {onMounted, ref} from "vue";
import ProjectList from "./../components/ProjectList.vue";
import {useProjectStore} from "../stores/project.js";
const projectStore = useProjectStore();

onMounted(() => {
  projectStore.getProjects();
});


</script>

<template>
  <h3>Liste des projets</h3>
  <button @click="projectStore.getProjects()">Récupérer les projets</button>
  <p v-if="projectStore.isLoading">Chargement en cours...</p>
  <project-list v-if="!projectStore.isLoading" :projects="projectStore.projects"></project-list>
</template>