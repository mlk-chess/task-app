<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import jsCookie from "js-cookie";

const router = useRouter()

const loginData = ref({
  email: null,
  password: null,
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
        router.push({ name: 'home' })
      } else if (data.message === 'Not confirmed') {
        loginData.value.error = 'Votre compte n\'a pas été confirmé. Vérifiez vos mails.'
      } else {
        loginData.value.error = 'Email ou mot de passe incorrect'
      }
    })
}
</script>

<template>
  <section class="flex items-center justify-center mt-10">

    <div class="flex-1">
      <img src="../assets/img/Login-rafiki.png" alt="Illustration de connexion" />
    </div>

    <div class="flex-1">
      <div class="card w-96 bg-base-100 shadow-xl">
        <div class="card-body">
          <h2 class="card-title">Connexion</h2>
          <form @submit.prevent="login">
            <p v-if="loginData.error" class="has-text-centered has-text-danger">{{ loginData.error }}</p>

            <div class="form-group mb-3">
              <label class="label">
                <span class="label-text">Email</span>
              </label>
              <input v-model="loginData.email" type="email" placeholder="jean.dupont@gmail.com"
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
              <a href="#" class="label-text-alt link link-hover">Mot de passe oublié?</a>
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