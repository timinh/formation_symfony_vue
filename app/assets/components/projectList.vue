<script setup>
const props = defineProps({
    projects: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <div class="row q-gutter-sm q-ma-md" v-if="props.projects.length > 0">
        <q-card class="myCard" v-for="project in props.projects">
            <q-card-section>
                <div class="text-h5">{{project.title}}</div>
            </q-card-section>
            <q-separator inset/>
            <q-card-section class="description">
                <div class="text-subtitle2">{{project.description}}</div>
            </q-card-section>
            <q-card-actions align="center">
                <q-btn icon="chevron_right" color="primary" label="Détail du projet"/>
            </q-card-actions>
        </q-card>
    </div>
</template>

<style scoped>
.myCard{
    max-width: 300px;
}

.description {
    height: 150px;
    overflow: hidden;
}
</style>
