<script setup>
  const props = defineProps({
    project: {
        type: Object,
        required: true
    }
  });
</script>

<template>
  <div>
    <button>{{ props.project.title }}</button>
    <p>{{props.project.description}}</p>
  </div>
</template>

<style scoped>

</style>