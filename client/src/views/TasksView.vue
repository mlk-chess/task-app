<template>
    <NavBar />

    <section>
        <div class="flex justify-center sm:flex-col md:flex-row">
            <div class="card w-96 bg-base-100 shadow-2xl m-10">
                <div class="card-body">
                    <h3 class="card-title">En cours</h3>
                    <draggable class="mt-10 cursor-grab active:cursor-grabbing focus:cursor-grabbing" :list="list1"
                        group="tasks" itemKey="name">
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
                        group="tasks" itemKey="name">
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
const list1 = ref([])
const list2 = ref([]);
const contributors = ref([]);
const token = jsCookie.get('jwt');

const handleItemClick = (element) => {
    taskItem.value = element.name;
    taskItemId.value = element.id;
}


watch(list1.value, (newList, oldList) => {
    newList.forEach((item) => {
        if (item.status === 1) {

            let id = item['@id']
            id = id.split("/")
            id = id[id.length - 1]

            console.log(id)

            const request = new Request(
                'https://localhost/api/tasks/'+id,
                {
                    method: 'PATCH',
                    headers: {
                        "Authorization": "Bearer " + token,
                        "Content-Type": "application/merge-patch+json"
                    },
                    
                    body: JSON.stringify({
                        status: 0
                    })
                }
            )
            fetch(request)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    })

})

watch(list2.value, (newList, oldList) => {
    newList.forEach((item) => {
        if (item.status === 0) {

            let id = item['@id']
            id = id.split("/")
            id = id[id.length - 1]

            console.log(id)

            const request = new Request(
                'https://localhost/api/tasks/' + id,
                {
                    method: 'PATCH',
                    headers: {
                        "Authorization": "Bearer " + token,
                        "Content-Type": "application/merge-patch+json"
                    },

                    body: JSON.stringify({
                        status: 1
                    })
                }
            )
            fetch(request)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        }
    })

})

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

const assignTo = (e) => {
    const indexToEdit = list2.value.findIndex((item) => item.id === e);
    list2.value[indexToEdit].assignTo.push(contributors.value.filter((item) => item.id === e));
    console.table(contributors.value.filter((item) => item.id === e));
}

onMounted(async () => {
    await fetchUsers();
})

const fetchUsers = async () => {

    const url = window.location.href;
    const idList = url.substring(url.lastIndexOf('/') + 1);

    const token = jsCookie.get('jwt')
    const requestToken = new Request(
        "https://localhost/api/get-list/" + idList,
        {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        });

    fetch(requestToken)
        .then(response => response.json())
        .then(data => {
            const tasks = data["hydra:member"][2]

            tasks.forEach((task) => {
                if (task.status === 0) {
                    list1.value.push(task)
                } else {
                    list2.value.push(task)
                }
            })
        })
}

</script>