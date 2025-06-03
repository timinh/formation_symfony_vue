<script setup>
import {onMounted, ref} from "vue";
import {api} from "../../api/Api.js";
import ProjectList from "../../components/projectList.vue";
import {useProjectStore} from "../../stores/project.js";

const store = useProjectStore();

onMounted(() => {
    store.getProjects()
})

</script>
<route lang="json">
{
    "name": "projectPage"
}
</route>
<template>
    <div class="q-ma-md">
        <div class="text-h2"><q-btn icon="refresh" @click="store.getProjects"/>Liste de mes projets</div>
        <project-list :projects="store.projects"/>
    </div>

</template>

<style scoped>

</style>
