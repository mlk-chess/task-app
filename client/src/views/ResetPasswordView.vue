<script setup>
import { ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import Footer from '@/components/Footer.vue';
import NavBar from '@/components/NavBar.vue';
import Alert from '../components/UI/Alert.vue';

const route = useRoute()
const router = useRouter()

if (!route.query.token)
  router.push({ name: 'login' })

const data = ref({
  password: null,
  passwordConfirm: null,
  error: null,
  success: null
})

function resetPassword() {
  data.value.error = null

  if (data.value.password === null || data.value.passwordConfirm === null) {
    data.value.error = 'Tous les champs sont obligatoires'
  } else if (data.value.password !== data.value.passwordConfirm) {
    data.value.error = 'Les mots de passe ne correspondent pas'
  } else {
    const reset = new Request(`https://localhost/reset/password`, {
      method: 'PATCH',
      body: JSON.stringify({
        password: data.value.password,
        token: route.query.token
      }),
      headers: {
        "Content-Type": "application/merge-patch+json"
      }
    })

    fetch(reset)
      .then(response => response.status === 200 && response.json())
      .then(res => {
        if (res) {
          data.value.error = null;
          data.value.success = "Votre mot de passe a bien été changé !";
        } else {
          data.value.error = "Une erreur s'est produite lors de la réinitialisation du mot de passe.";
          data.value.success = null;
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
        <div class="flex justify-center items-center">
          <div class="card w-96 bg-base-100 shadow-xl p-0">
            <div class="card-body">
              <h2 class="card-title">Changez votre mot de passe</h2>
              <form @submit.prevent="resetPassword">
                <div>
                  <Alert v-if="data.success" type="success" :message="data.success" />
                  <Alert v-if="data.error" type="error" :message="data.error" />
                </div>

                <div class="form-group mb-3">
                  <label class="label">
                    <span class="label-text">Mot de passe</span>
                  </label>
                  <input v-model="data.password" type="password" placeholder="**************"
                    class="input input-bordered w-full max-w-xs" />
                </div>

                <div class="form-group mb-3">
                  <label class="label">
                    <span class="label-text">Confirmation du mot de passe</span>
                  </label>
                  <input v-model="data.passwordConfirm" type="password" placeholder="**************"
                    class="input input-bordered w-full max-w-xs" />
                </div>

                <div class="form-control mt-6">
                  <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>

              </form>
            </div>
          </div>
          <div class="w-5/12">
            <img src="@/assets/img/Authentication-rafiki.png" />
          </div>
        </div>
      </div>
    </div>
    <Footer />
  </section>
</template>
