<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import NavBar from "@/components/NavBar.vue";
import Alert from "@/components/UI/Alert.vue"
import Footer from '../components/Footer.vue';

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
    <NavBar />
    <div>
        <div v-if="success">
            <Alert type="success" message="Votre compte a bien été confirmé !" />
            <div class="w-3/6 m-auto">
                <img src="@/assets/img/Onboarding-rafiki.png" />
            </div>
        </div>
        <div v-if="error">
            <Alert type="error" message="Une erreur s'est produite, veuillez contacter un administrateur ou essayez de vous connecter." />
            <div class="w-3/6 m-auto">
                <img src="@/assets/img/error.png" />
            </div>
        </div>
    </div>
    <Footer />
</template>