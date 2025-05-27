<script setup>

import ProjectCard from "./ProjectCard.vue";

const props = defineProps({
  projects: {
    type: Array,
    required: true
  }
});

</script>

<template>
  <ul v-if="props.projects.length > 0">
    <router-link v-for="project in props.projects" :to="{ name: 'projectPage', params: { id: project.id } }" :key="project.id">
      <project-card :project></project-card>
    </router-link>
  </ul>
</template>

<style scoped>

</style>