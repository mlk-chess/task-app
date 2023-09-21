<template>
    <NavBar />

    <section class="m-10">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <label>
                                #id
                            </label>
                        </th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>
                            <button class="btn btn-warning btn-xs" onclick="adduser.showModal()">
                                Créer un utilisateur
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg>
                            </button>
                            <Modal id="adduser">
                                <template #header>
                                    Ajouter un utilisateur
                                </template>
                                <template #content>
                                    <div class="flex flex-col">
                                        <div class="form-control w-full max-w-xs mt-5">
                                            <label class="label">
                                                <span class="label-text">Nom d'utilisateur</span>
                                            </label>
                                            <input type="text" placeholder="Nom d'utilisateur" v-model="username"
                                                class="input input-bordered w-full max-w-xs" />
                                        </div>
                                    </div>
                                    <div class="flex flex-col">
                                        <div class="form-control w-full max-w-xs mt-5 mb-5">
                                            <label class="label">
                                                <span class="label-text">Email</span>
                                            </label>
                                            <input type="text" placeholder="Email" v-model="email"
                                                class="input input-bordered w-full max-w-xs" />
                                        </div>
                                    </div>

                                    <span>Rôle</span>
                                    <div class="form-control mt-5">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Utilisateur standard</span>
                                            <input v-model="role" type="radio" name="radio-5"
                                                class="radio checked:bg-green-500" checked />
                                        </label>
                                    </div>
                                    <div class="form-control mb-5">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Administrateur</span>
                                            <input v-model="role" type="radio" name="radio-5"
                                                class="radio checked:bg-blue-500" />
                                        </label>
                                    </div>

                                    <span>Statut du compte</span>
                                    <div class="form-control mt-5">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Désactivé</span>
                                            <input v-model="status" type="radio" name="radio-10"
                                                class="radio checked:bg-red-500" checked />
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Activé</span>
                                            <input v-model="status" type="radio" name="radio-10"
                                                class="radio checked:bg-blue-500" />
                                        </label>
                                    </div>

                                </template>
                                <template #actions>
                                    <div class="flex">
                                        <button @click="createUser()" class="btn btn-primary mt-5">
                                            Ajouter
                                        </button>
                                    </div>
                                </template>
                            </Modal>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <th>
                            <label>
                                {{ user["@id"].split("/")[3] }}
                            </label>
                        </th>
                        <td>
                            <div class="flex items-center space-x-3">
                                <div>
                                    <div class="font-bold">{{ user.username }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ user.email }}</td>

                        <td>
                            <span class="badge badge-success" v-if="user.status === 1">Actif</span>
                            <span class="badge badge-secondary" v-else-if="user.status === 2">Admin</span>
                            <span class="badge" v-else-if="user.status === 0">En attente</span>
                            <span class="badge badge-accent" v-else>Désactivé</span>
                        </td>

                        <th>
                            <button class="btn btn-info btn-xs">
                                Détails
                            </button>
                        </th>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <Footer />
</template>

<script setup>
import NavBar from "../../components/NavBar.vue";
import Footer from "../../components/Footer.vue";
import Modal from "../../components/UI/Modal.vue";
import { onMounted, ref } from "vue";
import jsCookie from 'js-cookie'

const users = ref([]);
const role = ref([]);
const status = ref(0);
const email = ref('');
const username = ref('');


onMounted(() => {
    const token = jsCookie.get('jwt');
    if (token === undefined) {
        router.push({ name: 'login' })
    } else {
        fetch(`https://kaitokid.fr/api/users`, {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        })
            .then(response => response.json())
            .then((data) => {
                users.value = data["hydra:member"]
            })
    }
})

const createUser = () => {
    console.log(username.value, email.value, role.value, status.value)
}

</script>