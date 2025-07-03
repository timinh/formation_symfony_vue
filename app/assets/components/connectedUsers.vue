<script setup>
import { ref, watch } from 'vue'
import { useEventSource } from '@vueuse/core'

const connectedUsers = ref([])

const { data } = useEventSource(
    '/.well-known/mercure?topic=user_connected',
    [],
    { 
        autoReconnect: true
    }
)
watch(data, (data) => {
    connectedUsers.value.push(JSON.parse(data))
})

</script>
<template>
  <div class="q-pa-md">
    <q-card>
      <q-card-section>
        <div class="text-h6">Utilisateurs connectés</div>
      </q-card-section>
      <q-list>
        <q-item v-for="user in connectedUsers" :key="user.username">
          <q-item-section>{{ user.username }}</q-item-section>
          <q-item-label caption>{{ user.connected_at }}</q-item-label>
        </q-item>
      </q-list>
    </q-card>
  </div>
</template>