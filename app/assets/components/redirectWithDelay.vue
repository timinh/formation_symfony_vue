<script setup>
const props = defineProps({
    route: {
        type: String,
        required: true
    },
    delay: {
        type: Number,
        default: 5
    }
})
import { useRouter } from 'vue-router';
import { ref, onBeforeUnmount } from 'vue';

const router = useRouter();
const countdown = ref(props.delay);

const timer = window.setInterval(() => {
    countdown.value--;
    if (countdown.value <= 0) {
        clearInterval(timer);
        router.push(props.route);
    }
}, 1000);

onBeforeUnmount(() => {
    clearInterval(timer);
});
</script>

<template>
    <div>
        <h3>Vous allez être redirigé dans {{ countdown }} secondes.</h3>
        <q-btn class="full-width" color="primary" @click="router.push(route)">
            Aller maintenant
        </q-btn>
    </div>
</template>