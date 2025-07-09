<script setup>
import redirectWithDelay from '../../components/redirectWithDelay.vue';
</script>

<template>
<h2>Unauthorized access</h2>
<redirect-with-delay route="/project" :delay="5" />
</template>