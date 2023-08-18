<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import jsCookie from "js-cookie";
import Alert from './UI/Alert.vue';

const router = useRouter()

const loginData = ref({
  email: "johndoe@example.com",
  password: "apassword",
  error: null
});

function login() {
  loginData.value.error = null

  if (loginData.value.email === null || loginData.value.password === null) {
    loginData.value.error = 'Tous les champs sont obligatoires'

    return
  }

  const requestLogin = new Request(
    "https://localhost/api/login",
    {
      method: "POST",
      body: JSON.stringify({
        email: loginData.value.email,
        password: loginData.value.password
      }),
      headers: {
        "Content-Type": "application/json"
      }
    });

  fetch(requestLogin)
    .then((response) => response.json())
    .then((data) => {
      if (data.token) {
        jsCookie.set('jwt', data.token, { expires: 1 })
        router.push({ name: 'dashboard' })
      } else if (data.message === 'Not confirmed') {
        loginData.value.error = 'Votre compte n\'a pas été confirmé. Vérifiez vos mails.'
      } else {
        loginData.value.error = 'Identifiants incorrects !'
      }
    }).catch(e => console.error(e))
}
</script>

<template>
  <section class="flex items-center justify-center mt-10">

    <div class="flex-1">
      <img src="@/assets/img/Login-rafiki.png" alt="Illustration de connexion" />
    </div>

    <div class="flex-1">
      <div class="card w-96 bg-base-100 shadow-xl">
        <div class="card-body">
          <h2 class="card-title">Connexion</h2>
          <form @submit.prevent="login">
            <div v-if="loginData.error">
              <Alert type="warning" :message="loginData.error" />
            </div>

            <div class="form-group mb-3">
              <label class="label">
                <span class="label-text">Nom d'utilisateur ou email</span>
              </label>
              <input v-model="loginData.email" type="text" placeholder="jean.dupont@gmail.com"
                class="input input-bordered w-full max-w-xs" />
            </div>
            <div class="form-group">
              <label class="label">
                <span class="label-text">Mot de passe</span>
              </label>
              <input v-model="loginData.password" type="password" name="password" id="password"
                class="input input-bordered w-full max-w-xs" placeholder="*********" />
            </div>
            <label class="label">
              <router-link to="/password-forgotten" class="label-text-alt link link-hover">Mot de passe oublié?</router-link>
            </label>

            <div class="form-control mt-6">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>

export default {
  name: "Login"
}

</script>