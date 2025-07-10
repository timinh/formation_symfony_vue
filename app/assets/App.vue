<template>
    <q-layout view="hHh LpR fFf">

        <q-header class="bg-primary text-white" height-hint="98">
            <q-toolbar>
                <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

                <q-toolbar-title>
                    <q-avatar>
                        <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
                    </q-avatar>
                    Mes Projets
                </q-toolbar-title>
                <q-space />
                <span class="text-h6" v-if="userStore.username">
                    {{ userStore.username }}
                </span>
            </q-toolbar>

            <q-tabs align="left">
                <q-route-tab to="/project" label="Projets" />
                <q-route-tab to="/mytasks" label="Mes Tâches assignées" />
            </q-tabs>
        </q-header>

        <q-drawer show-if-above v-model="leftDrawerOpen" side="left" behavior="desktop">
            <connected-users />
        </q-drawer>

        <q-page-container>
            <router-view />
        </q-page-container>

    </q-layout>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import { jwtDecode } from 'jwt-decode'
import { useUserStore } from './stores/user'
import connectedUsers from './components/connectedUsers.vue'

const leftDrawerOpen = ref(false)
const toggleLeftDrawer = () => leftDrawerOpen.value = !leftDrawerOpen.value
const userStore = useUserStore()

onMounted(() => {
    const { username, roles, id } = jwtDecode(user_token)
    userStore.username = username
    userStore.roles = roles
})

</script>
