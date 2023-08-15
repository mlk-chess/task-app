<template>
    <div v-if="!isConnected" class="navbar bg-base-100">
        <div class="flex-1">
            <router-link to="/" class="btn btn-ghost normal-case text-xl">TaskApp</router-link>
        </div>
        <div class="flex-none">
            <ul class="menu menu-horizontal px-1">
                <li><router-link to="/login">Connexion</router-link></li>
                <li><router-link to="/register">S'inscrire</router-link></li>
            </ul>
        </div>
    </div>

    <div v-else class="navbar bg-base-100">
        <div class="navbar-start">
            <div class="dropdown">
                <label tabindex="0" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </label>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                    <li><router-link to="/dashboard">Dashboard</router-link></li>
                    <li><router-link to="/lists">Listes des tâches</router-link></li>
                    <li><router-link to="/tasks">Tâches</router-link></li>
                </ul>
            </div>
        </div>
        <div class="navbar-center">
            <router-link to="/" class="btn btn-ghost normal-case text-xl">TaskApp</router-link>
        </div>
        <div class="navbar-end">
            <button class="btn btn-ghost btn-circle">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="badge badge-xs badge-primary indicator-item"></span>
                </div>
            </button>

            <button @click="logout" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 17l5-5-5-5M19.8 12H9M13 22a10 10 0 1 1 0-20" />
                </svg>
            </button>


        </div>
    </div>
</template>

<script setup>
import jsCookie from 'js-cookie'
import { ref } from 'vue'

const token = jsCookie.get('jwt')
const isConnected = ref(false)

const requestToken = new Request(
    "https://localhost/api/auth",
    {
        method: "POST",
        headers: {
            "Authorization": "Bearer " + token
        }
    });

fetch(requestToken)
    .then((response) => {
        if (response.status === 200) {
            isConnected.value = true
        } else {
            isConnected.value = false
        }
    })

// logout function
const logout = () => {
    jsCookie.remove('jwt')
    window.location.href = '/login'
}

</script>