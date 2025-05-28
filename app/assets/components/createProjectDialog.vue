<script setup>
import {ref, watch} from "vue";
const props = defineProps({
  openDialog: {
    type: Boolean,
    required: true
  }
});
const title = ref('');
const description = ref('');
const dialog = ref(false);

watch(() => props.openDialog, (newVal) => {
  dialog.value = newVal;
});
</script>

<template>
  <q-dialog v-model="dialog" persistent>
    <q-card style="width: 800px">
      <q-card-section>
        <div class="text-h4">Créer un nouveau projet</div>
      </q-card-section>
      <q-separator inset/>
      <q-card-section class="q-gutter-sm">
        <q-input filled v-model="title" label="Titre du projet" :rules="[val => !!val || 'Champ obligatoire']" />
        <q-input filled v-model="description" label="Description du projet" type="textarea" />
      </q-card-section>
      <q-card-actions class="justify-between">
        <q-btn flat label="Annuler" color="secondary" @click="$emit('close')" />
        <q-btn flat label="Créer" color="primary" @click="$emit('create', { title, description })" :disable="title===''"/>
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<style scoped>

</style>