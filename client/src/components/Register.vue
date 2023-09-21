<script setup>
import { ref } from "vue";
import Alert from './UI/Alert.vue';
import Loading from './UI/Loading.vue';

const isLoad = ref(false);

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
  isLoad.value = true

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
      if (data !== undefined)
        if ("violations" in data) {
          if (data.violations[0]['propertyPath'] === 'email') {
            registerData.value.error = 'Cet email est déjà utilisé !'
          } else if (data.violations[0]['propertyPath'] === 'username') {
            registerData.value.error = "Ce nom d'utilisateur est déjà attribué à un utilisateur"
          }
        } else {
          registerData.value.error = 'Une erreur est survenue. Réessayez plus tard ou contactez nous.'
        }
      isLoad.value = false
    })
}
</script>

<template>
  <section class="flex items-center justify-center mt-10">

    <div class="flex-1">
      <img class="sm:invisible md:visible" src="@/assets/img/Queue-amico.png" alt="Illustration d'inscription" />
    </div>

    <div class="flex-1">
      <div class="card w-96 bg-base-100 shadow-xl">
        <div class="card-body">
          <Loading v-if="isLoad" />
          <div v-else>
            <h2 class="card-title">Inscription</h2>
            <form @submit.prevent="register">
              <div v-if="registerData.error">
                <Alert type="warning" :message="registerData.error" />
              </div>

              <div v-if="registerData.success">
                <Alert type="info" :message="registerData.success" />
              </div>

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
                <button type="submit" class="btn btn-secondary">S'enregistrer</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </section>
</template>