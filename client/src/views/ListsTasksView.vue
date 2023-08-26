<template>
    <Loading v-if="isLoad" />
    <template v-else>
        <NavBar />

        <div class="flex m-10 sm:flex-col md:flex-row justify-center flex-wrap">
            <div v-for="list in lists"
                class="card w-96 bg-base-100 shadow-xl m-10 transition ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-emerald-500 hover:cursor-pointer duration-300">
                <div class="card-body">
                    <h2 class="card-title">{{ list.name }}</h2>
                    <div class="avatar-group -space-x-6">
                        <div class="avatar">
                            <div class="w-12">
                                <img src="@/assets/img/default-pp.jpeg" />
                            </div>
                        </div>
                        <div class="avatar">
                            <div class="w-12">
                                <img src="@/assets/img/default-pp.jpeg" />
                            </div>
                        </div>
                        <div class="avatar">
                            <div class="w-12">
                                <img src="@/assets/img/default-pp.jpeg" />
                            </div>
                        </div>
                        <div class="avatar">
                            <div class="w-12">
                                <img src="@/assets/img/default-pp.jpeg" />
                            </div>
                        </div>
                    </div>
                    <div class="card-actions justify-end">
                        <button class="btn">Consulter</button>
                    </div>
                </div>
            </div>
            <div onclick="add.showModal()"
                class="card w-96 bg-base-100 shadow-xl m-10 transition ease-in-out hover:-translate-y-1 hover:scale-110 hover:bg-transparent hover:cursor-pointer duration-300">
                <div class="card-body flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </div>
            </div>
        </div>
        <Modal id="add">
            <template #header>
                Créer une liste
            </template>
            <template #content>
                <form @submit.prevent="createList">
                    <input v-model="listName" class="mt-10 input input-bordered input-primary w-full max-w-xs" />

                    <h3 class="mb-5 mt-5 text-lg font-medium">
                        Inviter des contributeurs
                    </h3>
                    <ul class="grid w-full gap-6 md:grid-cols-3">
                        <li v-for="contributor in contributors">
                            <input type="checkbox" :id="contributor.username" :value="contributor.id"
                                @change="assignTo(taskItemId)" class="hidden peer" required="">
                            <label :for="contributor.username"
                                class="inline-flex items-center justify-between w-full p-5 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600">
                                <div class="block">
                                    <p class="w-full text-lg font-semibold truncate">{{ contributor.username
                                    }}</p>
                                </div>
                            </label>
                        </li>
                    </ul>
                </form>
            </template>
            <template #actions>
                <button class="btn btn-primary" @click="createList()">Créer</button>
            </template>
        </Modal>

        <div class="toast">
            <Toast v-if="success !== null" :message=success type="success" />
            <Toast v-if="error !== null" :message=error type="error" />
        </div>

        <Footer />
    </template>
</template>

<script setup>
import NavBar from "@/components/NavBar.vue";
import Footer from "@/components/Footer.vue";
import { onMounted, ref } from "vue";
import jsCookie from 'js-cookie'
import Loading from "@/components/UI/Loading.vue"
import Modal from "../components/UI/Modal.vue";
import jwtDecode from "jwt-decode";
import Toast from "@/components/UI/Toast.vue";

const lists = ref([]);
const isLoad = ref(true);
const listName = ref('');
const contributors = ref([]);

const success = ref(null);
const error = ref(null);

onMounted(async () => {
    await fetchUsers();
})

const fetchUsers = async () => {
    isLoad.value = true;
    const token = jsCookie.get('jwt')
    const requestToken = new Request(
        "https://localhost/api/get-lists",
        {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token
            }
        });

    fetch(requestToken)
        .then(response => response.status === 200 && response.json())
        .then(data => {
            lists.value = data["hydra:member"]["0"]
        }).finally(() => {
            isLoad.value = false;
        })

}

const createList = async () => {
    isLoad.value = true;
    const token = jsCookie.get('jwt')

    let id;
    if (token !== undefined) {
        id = jwtDecode(token).id
    }

    const requestToken = new Request(
        "https://localhost/api/list_tasks",
        {
            method: "POST",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"

            },
            body: JSON.stringify({
                name: listName.value,
                owner: "/api/users/" + id
            }),
        });

    fetch(requestToken)
        .then(response => response.json())
        .then(data => {
            if (data.violations) {
                data.violations[0].propertyPath === "name" ? error.value = "Ce nom de liste existe déjà." : error.value = data.violations[0].message;
                success.value = null;
                setTimeout(() => {
                    error.value = null
                }, 5000);
            } else {
                fetchUsers()
                success.value = "Liste \"" + listName.value + "\" créée !";
                setTimeout(() => {
                    success.value = null
                }, 5000);
            } 
            
            // else{
            //     error.value = "Une erreur est survenue ! Réessayez.";
            //     success.value = null;

            //     setTimeout(() => {
            //         error.value = null
            //     }, 5000);
            // }
        }).finally(() => {
            isLoad.value = false;
        })
}

</script>