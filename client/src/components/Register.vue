<script setup>
import { ref } from "vue";

const registerData = ref({
  username: null,
  email: null,
  password: null,
  confirmPassword: null,
  error: null,
  success: null
});

function register() {
  registerData.value.error = null
  registerData.value.success = null

  if (registerData.value.email === null
    || registerData.value.username === null
    || registerData.value.password === null
    || registerData.value.confirmPassword === null) {
    registerData.value.error = 'Tous les champs sont obligatoires'
    return
  }

  if (registerData.value.password !== registerData.value.confirmPassword) {
    registerData.value.error = 'Les mots de passe ne correspondent pas'
    return
  }

  if (registerData.value.password.length < 8) {
    registerData.value.error = 'Le mot de passe doit contenir au moins 8 caractères.'
    return
  }

  const requestRegister = new Request(
    "https://localhost/api/users",
    {
      method: "POST",
      body: JSON.stringify({
        username: registerData.value.username,
        email: registerData.value.email,
        plainPassword: registerData.value.password
      }),
      headers: {
        "Content-Type": "application/json"
      }
    });

  fetch(requestRegister)
    .then(response => {
      console.log(response)
      if (response.status === 201) {
        Object.keys(registerData.value).forEach(key => {
          registerData.value[key] = null;
        });
        registerData.value.success = 'Votre compte a bien été créé. Vérifiez vos mails pour confirmer votre compte.'
        registerData.value.error = null
      } else {
        return response.json()
      }
    })
    .then(data => {
      console.log(data)
      registerData.value.error = data
    })
}
</script>

<template>
  <section class="flex items-center justify-center mt-10">

    <div class="card w-96 bg-base-100 shadow-xl">
      <div class="card-body">
        <h2 class="card-title">Inscription</h2>

        <form @submit.prevent="register">

          <p v-if="registerData.error" class="has-text-centered has-text-danger">{{ registerData.error }}</p>
          <p v-if="registerData.success" class="has-text-centered has-text-success">{{ registerData.success }}</p>
          <div class="form-group mb-3">
            <label class="label">
              <span class="label-text">Nom d'utilisateur</span>
            </label>
            <input v-model="registerData.username" type="text" placeholder="jean.dupont"
              class="input input-bordered w-full max-w-xs" />
          </div>
          <div class="form-group mb-3">
            <label class="label">
              <span class="label-text">Email</span>
            </label>
            <input v-model="registerData.email" type="email" placeholder="jean.dupont@gmail.com"
              class="input input-bordered w-full max-w-xs" />
          </div>
          <div class="form-group">
            <label class="label">
              <span class="label-text">Mot de passe</span>
            </label>
            <input v-model="registerData.password" type="password" name="password" id="password"
              class="input input-bordered w-full max-w-xs" placeholder="*********" />
          </div>
          <div class="form-group">
            <label class="label">
              <span class="label-text">Mot de passe de confirmation</span>
            </label>
            <input type="password" name="passwordConfirm" id="passwordConfirm" v-model="registerData.confirmPassword"
              class="input input-bordered w-full max-w-xs" placeholder="*********" />
          </div>

          <div class="form-control mt-6">
            <button type="submit" class="btn btn-primary">Register</button>
          </div>

        </form>
      </div>
    </div>
  </section>
</template>