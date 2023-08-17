<script setup>
import { ref } from 'vue'
import Footer from '@/components/Footer.vue';
import NavBar from '@/components/NavBar.vue';
import Alert from '../components/UI/Alert.vue';

const error = ref(null)
const data = ref({
    email: null,
    error: null
})

function newLink() {
    data.value.error = null

    if (data.value.email === null)
        data.value.error = 'Vous devez renseigner votre adresse email'
    else {
        const reset = new Request(`https://localhost/reset/email`, {
            method: 'POST',
            body: JSON.stringify({
                email: data.value.email,
            }),
            headers: {
                "Content-Type": "application/merge-post+json"
            }
        })

        fetch(reset)
            .then(response => {
                console.log(response)
            })
    }
}
</script>

<template>
    <section>
        <NavBar />
        <div v-if="!error">
            <div class="flex justify-center items-center mt-10">
                <div class="card w-96 bg-base-100 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title">Récupération de votre compte</h2>
                        <form @submit.prevent="newLink">
                            <div v-if="data.error">
                                <Alert type="warning" :message="data.error" />
                            </div>

                            <div class="form-group mb-3">
                                <label class="label">
                                    <span class="label-text">Email</span>
                                </label>
                                <input v-model="data.email" type="text" placeholder="jean.dupont@gmail.com"
                                    class="input input-bordered w-full max-w-xs" />
                            </div>

                            <div class="form-control mt-6">
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </section>
</template>
