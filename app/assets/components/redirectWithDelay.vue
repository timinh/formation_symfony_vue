<script setup>
const props = defineProps({
  delay: {
    type: Number,
    default: 3
  },
  route: {
    type: String,
    required: true
  }
})

import { ref, onBeforeUnmount } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const countdown = ref(props.delay)

const timer = setInterval(() => {
    countdown.value --
    if (countdown.value <= 0) {
        clearInterval(timer)
        router.push(props.route)
    }
}, 1000)

onBeforeUnmount(() => {
    clearInterval(timer)
})
</script>

<template>
  <div>
    <p>Redirection dans {{ countdown }} secondes...</p>
    <q-btn
      color="primary"
      @click="router.push(route)"
        label="Rediriger maintenant"
    />
  </div>
</template>