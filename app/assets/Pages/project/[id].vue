<script setup>
import {useRoute, useRouter} from "vue-router";
import {useProjectStore} from "../../stores/project.js";
import {onMounted, ref} from "vue";
const projectStore = useProjectStore();

const route = useRoute();
const router = useRouter();

const project = ref(null);

onMounted(async () => {
  if (projectStore.projects.length === 0) {
    await projectStore.getProjects();
  }
  const projectId = route.params.id;
  project.value = projectStore.getProjectById(projectId);
});
</script>

<route lang="json">
{
  "name": "projectPage"
}
</route>

<template>
  <q-btn :to="{ path: '/project' }" label="Retour à la liste des projets" color="secondary"  icon="arrow_left" class="q-ma-md"/>
  <q-card-section class="row justify-between">
    <div class="text-h3">{{ project?.title }}</div>
    <q-btn @click="projectStore.deleteProject(project.id).then(() => {router.back()})" color="secondary"  icon="delete" class="q-ma-md" round/>
  </q-card-section>
  <q-separator inset/>
  <q-card-section>
    <p>{{ project?.description }}</p>
  </q-card-section>
</template>

<style scoped>

</style>