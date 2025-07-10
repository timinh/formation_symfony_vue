<template>
  <q-layout view="hHh LpR fFf">

        <q-header class="bg-primary text-white" height-hint="98">
            <q-toolbar>
                <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" />

                <q-toolbar-title>
                    <q-avatar>
                        <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
                    </q-avatar>
                    Administration
                </q-toolbar-title>
            </q-toolbar>

            <q-tabs align="left">
                <q-route-tab to="/project" label="Projets" />
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
import { ref } from 'vue'
import connectedUsers from '../components/connectedUsers.vue'

const leftDrawerOpen = ref(false)

const toggleLeftDrawer = () => leftDrawerOpen.value = !leftDrawerOpen.value
</script>