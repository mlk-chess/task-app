<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const success = ref(null)
const error = ref(null)


onMounted(() => {
    const token = route.query.token

    if (token === undefined) {
        router.push({ name: 'login' })
    } else {
        fetch(`https://localhost/confirm-account/${token}`, {
            method: 'GET',
        })
            .then((response) => response.json())
            .then((data) => {
                if (data === 'Success') {
                    success.value = true
                } else {
                    error.value = true
                }
            })
    }
})
</script>

<template>
    <div>
        <div v-if="success">
            <h1>Success</h1>
            <p>Your account has been confirmed.</p>
        </div>
        <div v-if="error">
            <h1>Error</h1>
            <p>Your account could not be confirmed.</p>
        </div>
    </div>
</template>