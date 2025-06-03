<script setup>
import {onMounted, ref} from "vue";
import {api} from "../../api/Api.js";
import ProjectList from "../../components/projectList.vue";

const projects = ref([]);

const getProjects = () => {
    projects.value = [];
    api('/api/projects', 'GET').then((response) => {
        projects.value = response.data.member;
    });
}

onMounted(() => {
    getProjects();
})

</script>

<template>
    <div class="q-ma-md">
        <div class="text-h2"><q-btn icon="refresh" @click="getProjects"/>Liste de mes projets</div>
        <project-list :projects/>
    </div>

</template>

<style scoped>

</style>
