<template>
    <NavBar />

    <section>
        <div class="flex items-center justify-center sm:flex-col md:flex-row">
            <div class="card w-96 bg-base-100 shadow-2xl m-10">
                <div class="card-body">
                    <h3 class="card-title">En cours</h3>
                    <draggable class="mt-10 cursor-grab active:cursor-grabbing focus:cursor-grabbing" :list="list1"
                        group="tasks" @change="log" itemKey="name">
                        <template #item="{ element, index }">
                            <div class="alert alert-info mb-5" @click="handleItemClick(element)"
                                onclick="updateModal.showModal()">
                                <span>{{ element.name }}</span>
                            </div>
                        </template>
                    </draggable>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" onclick="todo.showModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Ajouter une carte
                        </button>
                        <Modal id="todo">
                            <template #header>
                                Ajouter une carte
                            </template>
                            <template #content>
                                <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
                            </template>
                        </Modal>
                    </div>
                </div>
            </div>

            <div class="card w-96 bg-base-100 shadow-xl m-10">
                <div class="card-body">
                    <h3 class="card-title">Terminé</h3>
                    <draggable class="mt-10 cursor-grab active:cursor-grabbing focus:cursor-grabbing" :list="list2"
                        group="tasks" @change="log" itemKey="name">
                        <template #item="{ element, index }">
                            <div class="alert alert-warning mb-5 hover:opacity-75" @click="handleItemClick(element)"
                                onclick="updateModal.showModal()">
                                <span>{{ element.name }}</span>
                            </div>
                        </template>
                    </draggable>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" onclick="done.showModal()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Ajouter une carte
                        </button>
                        <Modal id="done">
                            <template #header>
                                Ajouter une carte
                            </template>
                            <template #content>
                                <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
                            </template>
                        </Modal>
                        <Modal id="updateModal">
                            <template #header>
                                Personnaliser la carte
                            </template>
                            <template #content>
                                <form>
                                    <textarea v-model="taskItem" class="textarea mt-10"
                                        style="width: -webkit-fill-available;"></textarea>

                                    <h3 class="mb-5 mt-5 text-lg font-medium">Assigner à:
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
                                <button class="btn btn-secondary" @click="editItem(taskItemId)">Modifier</button>

                                <button class="btn btn-error" @click="removeItemById(taskItemId)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </template>
                        </Modal>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Footer />
</template>

<script setup>
import NavBar from "../components/NavBar.vue";
import Footer from "../components/Footer.vue";
import { onMounted, ref, watch } from "vue";
import draggable from "vuedraggable";
import Modal from "../components/UI/Modal.vue";
import jsCookie from 'js-cookie'

const taskItem = ref('');
const taskItemId = ref(null);

const handleItemClick = (element) => {
    taskItem.value = element.name;
    taskItemId.value = element.id;
}

const list1 = ref([
    { name: "Les utilisateurs devront pouvoir créer, modifier et supprimer des tâches.", id: 1, assignTo: [] },
    { name: "Les tâches devront être affectées à d'autres utilisateurs.", id: 2, assignTo: [] },
    { name: "Les tâches devront être triées par priorité et date d'échéance.", id: 3, assignTo: [] },
    { name: "Les tâches devront pouvoir être marquées comme terminées ou en cours.", id: 4, assignTo: [] }
])

const list2 = ref([
    { name: "Les utilisateurs devront pouvoir créer, modifier et supprimer des listes de tâches.", id: 5, assignTo: [] },
    { name: "Les listes de tâches devront pouvoir contenir plusieurs tâches.", id: 6, assignTo: [] },
    { name: "Les listes de tâches devront être triées par ordre alphabétique.", id: 7, assignTo: [] }
]);

// watch(list1.value, (newX) => {
//     console.table(newX)
// })

watch(list2.value, (newX) => {
    console.table(newX);
})

// watch(taskItem.value, (newX) => {
//     console.table(newX)
// })

const removeItemById = (e) => {
    log(e)
    const indexToRemove = list2.value.findIndex((item) => item.id === e);
    list2.value.splice(indexToRemove, 1);
}

const editItem = (e) => {
    const indexToEdit = list2.value.findIndex((item) => item.id === e);
    list2.value[indexToEdit].name = taskItem.value
    console.table(list2.value[indexToEdit].name);
}

const clone = (el) => {
    return {
        name: el.name + " cloned"
    };
};

const log = (evt) => {
    console.table(evt);
};

const update = (e) => {
    console.log(e);
}

const contributors = ref([]);

const assignTo = (e) => {
    const indexToEdit = list2.value.findIndex((item) => item.id === e);
    list2.value[indexToEdit].assignTo.push(contributors.value.filter((item) => item.id === e));
    console.table(contributors.value.filter((item) => item.id === e));
}

onMounted(async () => {
    console.log()
    await fetchUsers();
})

const fetchUsers = async () => {
    const token = jsCookie.get('jwt')
    const requestToken = new Request(
        "https://localhost/api/users",
        {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token
            }
        });

    fetch(requestToken)
        .then(response => response.status === 200 && response.json())
        .then(data => {
            contributors.value = data["hydra:member"]
            log(data["hydra:member"])
        })
}

</script>