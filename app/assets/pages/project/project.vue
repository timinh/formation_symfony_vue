<script setup>
import {onMounted, ref} from "vue";
import {api} from "../../api/Api.js";
import ProjectList from "../../components/projectList.vue";

const projects = ref([]);

const getProjects = () => {
    api('/api/projects', 'GET').then((response) => {
        projects.value = response.data.member;
    })
}

onMounted(() => {
    getProjects();
})

</script>

<template>
<h2>Liste de mes projets...</h2>
<project-list :projects/>
</template>

<style scoped>

</style>
