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
  <div class="row q-gutter-sm">
    <project-card v-for="project in props.projects"  :project :key="project.id"></project-card>
  </div>
</template>

<style scoped>

</style>