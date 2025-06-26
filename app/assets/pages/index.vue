<script setup>

import {useQuasar} from "quasar";

const $q = useQuasar();

const eventSource = new EventSource(aboutUrl);
eventSource.onmessage = event => {
    $q.notify({
        message: 'Utilisateur connecté : ' + JSON.parse(event.data).username,
        type: 'positive'
    });
};
</script>

<template>
<p>index page</p>
</template>

<style scoped>

</style>
