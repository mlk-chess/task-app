<template>
    <div class="navbar bg-base-100">
        <div class="flex-1">
            <a class="btn btn-ghost normal-case text-xl">TaskApp</a>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1">
                <li><router-link to="/login">Connexion</router-link></li>
                <li><router-link to="/register">S'inscrire</router-link></li>
            </ul>
        </div>
    </div>
</template>