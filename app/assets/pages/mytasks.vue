<script setup>

import {api} from "../api/Api.js";
import {onMounted, ref} from "vue";
import {useUserStore} from "../stores/user.js";
import {jwtDecode} from "jwt-decode";
const tasks = ref([]);
const userStore = useUserStore();

const getUserTasks = async () => {
    await api('users/' + user_id + '/tasks', 'GET').then((response) => {
        tasks.value = response.data.tasks;
    }).catch((error) => {
        console.error('Error fetching user tasks:', error);
    })
}

onMounted(() => {
    getUserTasks();
});

</script>

<template>
    <div class="q-pa-md">
        <div class="text-h5">
            Mes tâches assignées
        </div>
        <div class="q-ma-md">
            <div class="text-h6">Tâches en cours</div>
            <q-list>
                <q-item v-for="task in tasks" :key="task.id" class="q-mb-sm">
                    <q-item-section>
                        <q-item-label>{{task.title}}</q-item-label>
                        <q-item-label caption>{{task.description}}</q-item-label>
                    </q-item-section>
                    <q-item-section side>
                        <q-item-label>{{task.status}}</q-item-label>
                        <q-item-label caption>{{task.start_date}}</q-item-label>
                        <q-item-label caption>{{task.due_date}}</q-item-label>
                    </q-item-section>
                </q-item>
                <q-item v-if="tasks.length === 0">
                    <q-item-section>
                        <q-item-label>Pas de tâches en cours</q-item-label>
                    </q-item-section>
                </q-item>
            </q-list>
        </div>
    </div>


</template>

<style scoped>

</style>
