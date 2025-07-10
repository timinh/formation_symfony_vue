<template>
    <component :is="layout">
        <router-view />
    </component>
    
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import admin from './layouts/admin.vue';
import connected from './layouts/default.vue';

const layout = ref(connected)

const router = useRouter();
router.beforeEach((to, from, next) => {
    layout.value = to.meta?.layout == 'admin' ? admin : connected
    next()
});
</script>
