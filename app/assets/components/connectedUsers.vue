<script setup>
import { onMounted, ref } from 'vue';

const users = ref([]);

onMounted(() => {
    const eventSource = new EventSource('/.well-known/mercure?topic=connected_users');

    eventSource.onmessage = (event) => {
        const data = JSON.parse(event.data);
        users.value.push(data);
    };

    eventSource.onerror = (error) => {
        console.error('EventSource failed:', error);
    };
});
</script>

<template>
    <div class="q-pa-md">
        <q-item v-for="user in users" :key="user.id">
            <q-item-section>
                <q-item-label>{{ user.username }}</q-item-label>
                <q-item-label caption>{{ user.connected_at }}</q-item-label>
            </q-item-section>
        </q-item>
    </div>
</template>