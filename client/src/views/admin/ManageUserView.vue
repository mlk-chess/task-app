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
                            <button class="btn btn-warning btn-xs" onclick="adduser.showModal()" @click="clearValues()">
                                Créer
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
                                            <input type="email" placeholder="Email" v-model="email"
                                                class="input input-bordered w-full max-w-xs" />
                                        </div>
                                    </div>

                                    <span>Rôle</span>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Administrateur</span>
                                            <input v-model="role" value="ROLE_USER,ROLE_ADMIN" type="radio" name="radio-102"
                                                class="radio checked:bg-red-500" :checked="role.includes('ROLE_ADMIN')" />
                                        </label>
                                    </div>
                                    <div class="form-control mb-5">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Utilisateur standard</span>
                                            <input v-model="role" value="ROLE_USER" type="radio" name="radio-102"
                                                class="radio checked:bg-blue-500" :checked="role.includes('ROLE_USER')" />
                                        </label>
                                    </div>

                                    <span>Statut du compte</span>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Désactivé</span>
                                            <input v-model="status" type="radio" name="radio-10" value="-1"
                                                class="radio checked:bg-red-500" />
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">A confirmer</span>
                                            <input v-model="status" type="radio" name="radio-10" value="0"
                                                class="radio checked:bg-blue-500" checked />
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Activé</span>
                                            <input v-model="status" value="1" type="radio" name="radio-10"
                                                class="radio checked:bg-green-500" />
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
                            <span class="badge badge-secondary"
                                v-if="user.roles.includes('ROLE_ADMIN') && user.status > 0">Admin</span>
                            <span class="badge badge-secondary"
                                v-else-if="user.roles.includes('ROLE_ADMIN') && user.status === 0">Admin à confirmer</span>
                            <span class="badge badge-success" v-else-if="user.status === 1">Actif</span>

                            <span class="badge" v-else-if="user.status === 0">En attente</span>
                            <span class="badge badge-accent" v-else>Désactivé</span>
                        </td>

                        <th>
                            <label for="detail" class="btn btn-info btn-xs"
                                @click="handleUser(user.username, user.email, user.roles, user.status)">Détails</label>

                            <Modals id="detail">
                                <template #header>
                                    Détails de l'utilisateur
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
                                            <input type="email" placeholder="Email" v-model="email"
                                                class="input input-bordered w-full max-w-xs" />
                                        </div>
                                    </div>

                                    <span>Rôle</span>
                                    <div class="form-control mt-5">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Utilisateur standard</span>
                                            <input v-model="role" type="radio" value='ROLE_USER' name="radio-5"
                                                class="radio checked:bg-green-500" checked />
                                        </label>
                                    </div>
                                    <div class="form-control mb-5">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Administrateur</span>
                                            <input v-model="role" value='ROLE_USER,ROLE_ADMIN' type="radio" name="radio-5"
                                                class="radio checked:bg-blue-500" />
                                        </label>
                                    </div>

                                    <span>Statut du compte</span>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Désactivé</span>
                                            <input v-model="status" type="radio" name="radio-10" value="-1"
                                                class="radio checked:bg-red-500" :checked="user.status < 0" />
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">A confirmer</span>
                                            <input v-model="status" type="radio" name="radio-10" value="0"
                                                class="radio checked:bg-blue-500" :checked="user.status === 0" />
                                        </label>
                                    </div>
                                    <div class="form-control">
                                        <label class="label cursor-pointer">
                                            <span class="label-text">Activé</span>
                                            <input v-model="status" value="1" type="radio" name="radio-10"
                                                class="radio checked:bg-green-500" :checked="user.status > 0" />
                                        </label>
                                    </div>



                                </template>
                                <template #actions>
                                    <div class="flex justify-between w-full">
                                        <div>
                                            <label for="detail" class="btn mt-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                                </svg> </label>
                                        </div>
                                        <div>
                                            <label for="detail" class="btn btn-warning mt-5" @click="edit(user.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon>
                                                </svg> </label>
                                            <label for="detail" class="btn btn-error mt-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>
                                            </label>
                                        </div>
                                    </div>
                                </template>
                            </Modals>
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
        <div v-if="success || error" class="toast">
            <Toast v-if="success" :message=success type="success" />
            <Toast v-if="error" :message=error type="error" />
        </div>
    </section>
    <Footer />
</template>

<script setup>
import NavBar from "../../components/NavBar.vue";
import Footer from "../../components/Footer.vue";
import Modal from "../../components/UI/Modal.vue";
import Toast from "../../components/UI/Toast.vue";
import { onMounted, ref } from "vue";
import jsCookie from 'js-cookie'
import Modals from "../../components/UI/Modals.vue";

const users = ref([]);
const role = ref(["ROLE_USER"]);
const status = ref(0);
const email = ref('');
const username = ref('');
const success = ref(null);
const error = ref(null);
const token = jsCookie.get('jwt');

const clearValues = () => {
    username.value = '';
    email.value = '';
    role.value = ["ROLE_USER"];
    status.value = 0;
}

const fetchUser = async () => {
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
}

onMounted(async () => {
    await fetchUser()
})

const createUser = async () => {

    error.value = null
    success.value = null

    const password = Math.random().toString(36).slice(-8);

    const requestRegister = new Request(
        "https://kaitokid.fr/api/users",
        {
            method: "POST",
            body: JSON.stringify({
                username: username.value,
                email: email.value,
                plainPassword: password,
                roles: [role.value],
                status: parseInt(status.value)
            }),
            headers: {
                "Content-Type": "application/json",
                "Authorization": `Bearer ${token}`
            }
        });

    fetch(requestRegister)
        .then(response => response.json())
        .then(data => {
            if (data.violations) {
                error.value = data.violations[0].message
            } else {
                success.value = "Compte créé !"
                fetchUser();
            }
        })
}

const handleUser = (uname, uemail, urole, ustatus) => {
    username.value = uname;
    email.value = uemail;
    role.value = urole;
    status.value = ustatus;
}

const edit = async (id) => {
    error.value = null;
    success.value = null;

    const requestUpdateUser = new Request(
        `https://kaitokid.fr/api/users/${id}`,
        {
            method: "PATCH",
            body: JSON.stringify({
                username: username.value,
                email: email.value,
                roles: role.value.indexOf(',') > -1 ? role.value.split(',') : [role.value],
                status: parseInt(status.value)
            }),
            headers: {
                "Content-Type": "application/merge-patch+json",
                "Authorization": `Bearer ${token}`
            }
        }
    );

    try {
        const response = await fetch(requestUpdateUser);
        if (!response.ok) {
            const data = await response.json();
            if (data.violations) {
                error.value = data.violations[0].message;
            } else {
                error.value = "Une erreur s'est produite lors de la mise à jour de l'utilisateur.";
            }
        } else {
            success.value = "Informations utilisateur mises à jour avec succès !";
            await fetchUser();
        }
    } catch (error) {
        console.error("An error occurred while updating user:", error);
        error.value = "Une erreur s'est produite lors de la mise à jour de l'utilisateur.";
    }
}

</script>