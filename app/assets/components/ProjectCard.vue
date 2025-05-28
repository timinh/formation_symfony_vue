<script setup>
  const props = defineProps({
    project: {
        type: Object,
        required: true
    }
  });
</script>

<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-h6">{{ props.project.title }}</div>
    </q-card-section>
    <q-separator inset/>
    <q-card-section class="description">
      <div class="text-subtitle2">{{ props.project.description }}</div>
    </q-card-section>
    <q-card-actions align="around">
      <q-btn :to="{ name: 'projectPage', params: { id: props.project.id } }" color="primary">Voir le projet</q-btn>
    </q-card-actions>
  </q-card>
</template>

<style>
.my-card {
  max-width: 300px;
}

.description {
  height: 150px;
  overflow: hidden;
}
</style>