<template>
  <section class="flex items-center justify-center h-screen">
    <div class="card w-96 bg-base-100 shadow-xl">
      <div class="card-body">
        <h2 class="card-title">Connexion</h2>
        <form action="#" method="POST">
          <div class="form-group mb-3">
            <label class="label">
              <span class="label-text">Email</span>
            </label>
            <input type="email" placeholder="email@address.com" class="input input-bordered w-full max-w-xs" />
          </div>
          <div class="form-group">
            <label class="label">
              <span class="label-text">Mot de passe</span>
            </label>
            <input type="password" name="password" id="password" class="input input-bordered w-full max-w-xs"
              placeholder="*********" />
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
  </section>
</template>

<script>

export default {
  name: "Login"
}

</script>