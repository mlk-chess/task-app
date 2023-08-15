<template>
    <div class="hero min-h-screen bg-base-200">
        <div class="hero-content flex-col lg:flex-row-reverse">
            <img src="@/assets/img/Office management-rafiki.png" class="max-w-sm rounded-lg" />
            <div>
                <h1 class="text-5xl font-bold">Gérez facilement vos tâches</h1>
                <p class="py-6">
                    Simplifiez votre quotidien avec notre solution innovante. Gérez facilement vos tâches grâce à une
                    interface conviviale et intuitive. Ne laissez plus le chaos s'installer – organisez vos journées de
                    manière efficace et atteignez vos objectifs en toute sérénité. Que ce soit pour le travail, les études
                    ou les projets personnels, notre outil vous offre le contrôle dont vous avez besoin pour maximiser votre
                    productivité. Dites adieu au stress de la gestion des tâches et commencez dès aujourd'hui à vivre une
                    vie plus organisée et épanouissante.
                </p>
                <router-link to="/dashboard" class="btn btn-primary">C'est parti</router-link>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Home"
}

</script>