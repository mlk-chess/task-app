<script setup>
import { ref } from 'vue'
import Footer from '@/components/Footer.vue';
import NavBar from '@/components/NavBar.vue';
import Alert from '@/components/UI/Alert.vue';

const error = ref(null)
const success = ref(null)
const data = ref({
    email: null,
    error: null
})

function newLink() {
    data.value.error = null

    if (data.value.email === null)
        data.value.error = 'Vous devez renseigner votre adresse email'
    else {
        const reset = new Request(`https://kaitokid.fr/reset/email`, {
            method: 'POST',
            body: JSON.stringify({
                email: data.value.email,
            }),
            headers: {
                "Content-Type": "application/json"
            }
        })

        fetch(reset)
            .then(response => response.status === 200 && response.json())
            .then(data => {
                if (data)
                    if (data.message === 'error') {
                        error.value = "Adresse email introuvable. Veuillez réessayer"
                        success.value = null;
                    } else {
                        error.value = null;
                        success.value = "Un email vous a été envoyé. Suivez les instructions qui vous ont été envoyées par mail.";
                    }
            })
    }
}
</script>

<template>
    <section>
        <NavBar />
        <div>
            <div class="flex justify-center items-center flex-col mt-10">
                <div>
                    <Alert v-if="success" type="success" :message="success" />
                    <Alert v-if="error" type="error" :message="error" />
                </div>
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
                                <input v-model="data.email" type="email" placeholder="jean.dupont@gmail.com"
                                    class="input input-bordered w-full max-w-xs" />
                            </div>

                            <div class="form-control mt-6">
                                <button type="submit" class="btn btn-primary">Envoyer</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="w-5/12">
                <img src="@/assets/img/password-amico.png" />
            </div>
        </div>
        <Footer />
    </section>
</template>
