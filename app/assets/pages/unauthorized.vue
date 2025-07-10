<script setup>
import RedirectWithDelay from '../components/redirectWithDelay.vue'
</script>

<template>
    <h3>Accès refusé</h3>
    <RedirectWithDelay
      :delay="5"
      route="/project"
    />
</template>
