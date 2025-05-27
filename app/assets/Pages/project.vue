<script setup>
import {useRoute} from "vue-router";
import {useProjectStore} from "../stores/project.js";
import {onMounted, ref} from "vue";
const projectStore = useProjectStore();

const route = useRoute();

const project = ref(null);

onMounted(async () => {
  if (projectStore.projects.length === 0) {
    await projectStore.getProjects();
  }
  const projectId = route.params.id;
  project.value = projectStore.getProjectById(projectId);
});
</script>

<template>
  <div>
    <h3>{{ project?.title }}</h3>
    <p>{{ project?.description }}</p>
    <button @click="$router.push({ name: 'home' })">Retour à la liste des projets</button>
  </div>
</template>

<style scoped>

</style>