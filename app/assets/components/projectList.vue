<script setup>
const props = defineProps({
    projects: {
        type: Array,
        required: true
    }
})
</script>

<template>
    <ul v-if="props.projects.length > 0">
        <li v-for="project in props.projects">
            <b>{{project.title}}</b>
            <p>{{project.description}}</p>
        </li>
    </ul>
</template>

<style scoped>

</style>
