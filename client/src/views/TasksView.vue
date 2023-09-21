<template>
    <NavBar />

    <section>

        <ul class="steps flex justify-center">
            <li v-for="contributor in contributors" class="step step-primary">
                <div class="list-item-content">
                    <div class="list-item-title">
                        {{ contributor.username }}
                    </div>
                    <div class="list-item-subtitle">
                        {{ contributor.email }}
                    </div>
                </div>
            </li>
        </ul>
    </section>

    <section>
        <div class="flex justify-center sm:flex-col md:flex-row">
            <div class="card w-96 bg-base-100 shadow-2xl sm:m-0 md:m-10">
                <div class="card-body">
                    <h3 class="card-title">En cours</h3>
                    <draggable class="mt-10 cursor-grab active:cursor-grabbing focus:cursor-grabbing" :list="list1"
                        group="tasks" itemKey="name">
                        <template #item="{ element, index }">
                            <div class="alert alert-info mb-5 flex justify-between" @click="handleItemClick(element)"
                                onclick="updateModal.showModal()">
                                <span>{{ element.name }}</span>
                                <div class="-space-x-6">
                                    <div class="avatar">
                                        <div v-for="contributor in element.assignTo"
                                            class="alert alert-primary w-12 h-12 rounded-full text-2xl font-semibold flex justify-center items-center">
                                            <span class="flex items-center justify-center w-full h-full">
                                                {{ contributor.username[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </template>
                    </draggable>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" onclick="todo.showModal()" @click="() => {
                            dateend = null
                            priority = 1
                            taskAssignedContributors = []
                        }">
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
                                <div>
                                    <input v-model="newCard" class="textarea mt-10 mb-5"
                                        style="width: -webkit-fill-available;" placeholder="Description de la tâche" />

                                    <span class="text-gray-700 dark:text-gray-400">Assigner à</span>

                                    <ul class="grid w-full gap-6 md:grid-cols-3">
                                        <li v-for="contributor in contributors">
                                            <input type="checkbox" :id="contributor.username" :value="contributor['@id']"
                                                v-model="taskAssignedContributors" class="hidden peer" required="" />


                                            <label :for="contributor.username"
                                                class="inline-flex items-center justify-between w-full p-5 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600">
                                                <div class="block">
                                                    <p class="w-full text-lg font-semibold truncate">{{ contributor.username
                                                    }}</p>
                                                </div>
                                            </label>
                                        </li>
                                    </ul>

                                    <div class="mt-5">
                                        <label class="block text-sm">
                                            <span class="text-gray-700 dark:text-gray-400">Date d'échéance</span>
                                            <input type="date"
                                                class="mt-1 block w-full rounded-md border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                                v-model="dateend" />
                                        </label>
                                    </div>

                                    <div class="mt-5">
                                        <span class="text-gray-700 dark:text-gray-400">Priorité</span>
                                        <input type="range" min="0" max="4" class="range" step="1" v-model="priority" />
                                        <div class="w-full flex justify-between text-xs px-2">
                                            <span>|</span>
                                            <span>|</span>
                                            <span>|</span>
                                            <span>|</span>
                                            <span>|</span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template #actions>
                                <div class="flex">
                                    <button @click="createCard(0)" class="btn btn-primary mt-5">
                                        Ajouter
                                    </button>
                                </div>
                            </template>
                        </Modal>
                    </div>
                </div>
            </div>

            <div class="card w-96 bg-base-100 shadow-xl sm:m-0 md:m-10">
                <div class="card-body">
                    <h3 class="card-title">Terminé</h3>
                    <draggable class="mt-10 cursor-grab active:cursor-grabbing focus:cursor-grabbing" :list="list2"
                        group="tasks" itemKey="name">
                        <template #item="{ element, index }">
                            <div class="alert alert-warning mb-5 hover:opacity-75 flex justify-between"
                                @click="handleItemClick(element)" onclick="updateModal.showModal()">
                                <span>{{ element.name }}</span>
                                <div class="-space-x-6">
                                    <div class="avatar">
                                        <div v-for="contributor in element.assignTo"
                                            class="alert w-12 h-12 rounded-full text-2xl font-semibold flex justify-center items-center">
                                            <span class="flex items-center justify-center w-full h-full">{{
                                                contributor.username[0] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </draggable>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" onclick="done.showModal()" @click="() => {
                            dateend = null
                            priority = 1
                            taskAssignedContributors = []
                        }">
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
                                <div>
                                    <input v-model="newCard" class="textarea mt-10 mb-5"
                                        style="width: -webkit-fill-available;" placeholder="Description de la tâche" />

                                    <span class="text-gray-700 dark:text-gray-400">Assigner à</span>

                                    <ul class="grid w-full gap-6 md:grid-cols-3">
                                        <li v-for="contributor in contributors">
                                            <input type="checkbox" :id="contributor.username" :value="contributor['@id']"
                                                v-model="taskAssignedContributors" class="hidden peer" required="" />


                                            <label :for="contributor.username"
                                                class="inline-flex items-center justify-between w-full p-5 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600">
                                                <div class="block">
                                                    <p class="w-full text-lg font-semibold truncate">{{ contributor.username
                                                    }}</p>
                                                </div>
                                            </label>
                                        </li>
                                    </ul>

                                    <div class="mt-5">
                                        <label class="block text-sm">
                                            <span class="text-gray-700 dark:text-gray-400">Date d'échéance</span>
                                            <input type="date"
                                                class="mt-1 block w-full rounded-md border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                                v-model="dateend" />
                                        </label>
                                    </div>

                                    <div class="mt-5">
                                        <span class="text-gray-700 dark:text-gray-400">Priorité</span>
                                        <input type="range" min="0" max="4" class="range" step="1" v-model="priority" />
                                        <div class="w-full flex justify-between text-xs px-2">
                                            <span>|</span>
                                            <span>|</span>
                                            <span>|</span>
                                            <span>|</span>
                                            <span>|</span>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template #actions>
                                <div class="flex">
                                    <button @click="createCard(1)" class="btn btn-primary mt-5">
                                        Ajouter
                                    </button>
                                </div>
                            </template>
                        </Modal>
                        <Modal id="updateModal">
                            <template #header>
                                Personnaliser la carte
                            </template>
                            <template #content>
                                <div>
                                    <textarea v-model="taskItem" class="textarea mt-10"
                                        style="width: -webkit-fill-available;"></textarea>

                                    <span class="text-gray-700 dark:text-gray-400">Assigner à</span>

                                    <ul class="grid w-full gap-6 md:grid-cols-3">
                                        <li v-for="contributor in contributors">
                                            <input type="checkbox" :id="contributor.username" :value="contributor['@id']"
                                                @change="assignTo(taskItemId, contributor['@id'], $event.target.checked)"
                                                class="hidden peer" required=""
                                                :checked="taskAssignedContributors?.includes(contributor['@id'])" />

                                            <label :for="contributor.username"
                                                class="inline-flex items-center justify-between w-full p-5 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-600">
                                                <div class="block">
                                                    <p class="w-full text-lg font-semibold truncate">{{ contributor.username
                                                    }}</p>
                                                </div>
                                            </label>
                                        </li>
                                    </ul>

                                    <div class="mt-5">
                                        <label class="block text-sm">
                                            <span class="text-gray-700 dark:text-gray-400">Date d'échéance</span>
                                            <input type="date"
                                                class="mt-1 block w-full rounded-md border-transparent focus:border-gray-500 focus:bg-white focus:ring-0"
                                                v-model="dateend" />
                                        </label>
                                    </div>

                                    <div class="mt-5">
                                        <span class="text-gray-700 dark:text-gray-400">Priorité</span>
                                        <input type="range" min="0" max="4" class="range" step="1" v-model="priority" />
                                        <div class="w-full flex justify-between text-xs px-2">
                                            <span>|</span>
                                            <span>|</span>
                                            <span>|</span>
                                            <span>|</span>
                                            <span>|</span>
                                        </div>
                                    </div>

                                </div>
                            </template>
                            <template #actions>
                                <div class="flex">
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
                                </div>
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
const taskAssignedContributors = ref([]);
const newCard = ref('');
const token = jsCookie.get('jwt');
const dateend = ref(null);
const priority = ref(1);

const handleItemClick = (element) => {
    taskItem.value = element.name;
    let id = element["@id"];
    id = id.split("/");
    id = id[id.length - 1];
    taskItemId.value = parseInt(id);

    const requestToken = new Request(
        "https://kaitokid.fr/api/tasks/" + taskItemId.value,
        {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        });

    fetch(requestToken)
        .then(response => response.status === 200 && response.json())
        .then(data => {
            if (data) {
                taskAssignedContributors.value = data.assignTo
                const date = data.dueDate?.split("T")[0]
                dateend.value = date ?? null
                priority.value = data.priority ?? 1
            }
        })
}


watch(list1.value, (newList, oldList) => {
    newList.forEach((item) => {
        if (item.status === 1) {

            let id = item['@id']
            id = id.split("/")
            id = id[id.length - 1]

            const request = new Request(
                'https://kaitokid.fr/api/tasks/' + id,
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
                })
                .catch(error => {
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

            const request = new Request(
                'https://kaitokid.fr/api/tasks/' + id,
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
                })
                .catch(error => {
                });
        }
    })

})

const createCard = async (status) => {
    try {
        const url = window.location.href;
        const idList = url.substring(url.lastIndexOf('/') + 1);

        const request = new Request(
            'https://kaitokid.fr/api/tasks',
            {
                method: 'POST',
                headers: {
                    "Authorization": "Bearer " + token,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    name: newCard.value,
                    belongsToList: "/api/list_tasks/" + idList,
                    assignTo: taskAssignedContributors.value,
                    dueDate: dateend.value,
                    priority: parseInt(priority.value),
                    status: status
                })
            }
        );

        const response = await fetch(request);

        if (response.ok) {
            list1.value = [];
            list2.value = [];
            await fetchUsers();

            newCard.value = '';
        } else {
            console.error("Erreur lors de la création de la carte.");
        }
    } catch (error) {
        console.error("Une erreur s'est produite lors de la création de la carte.", error);
    }
}


const removeItemById = async (taskId) => {
    try {
        const request = new Request(
            `https://kaitokid.fr/api/tasks/${taskId}`,
            {
                method: 'DELETE',
                headers: {
                    "Authorization": "Bearer " + token,
                    "Content-Type": "application/json"
                }
            }
        );

        const response = await fetch(request);

        if (response.ok) {
            if (list1.value.some(item => item["@id"].endsWith(taskId))) {
                list1.value = list1.value.filter(item => !item["@id"].endsWith(taskId));
            } else if (list2.value.some(item => item["@id"].endsWith(taskId))) {
                list2.value = list2.value.filter(item => !item["@id"].endsWith(taskId));
            }
        } else {
            console.error("Erreur lors de la suppression de l'élément.");
        }
    } catch (error) {
        console.error("Une erreur s'est produite lors de la suppression de l'élément.", error);
    }
}


const editItem = async (taskId) => {
    try {
        const request = new Request(
            `https://kaitokid.fr/api/tasks/${taskId}`,
            {
                method: 'PATCH',
                headers: {
                    "Authorization": "Bearer " + token,
                    "Content-Type": "application/merge-patch+json"
                },
                body: JSON.stringify({
                    name: taskItem.value,
                    dueDate: dateend.value,
                    priority: parseInt(priority.value),
                    assignTo: taskAssignedContributors.value
                })
            }
        );

        const response = await fetch(request);

        if (response.ok) {
            const updatedItem = list1.value.find(item => item["@id"].endsWith(taskId));
            if (updatedItem) {
                updatedItem.name = taskItem.value;
            }
            list1.value = [];
            list2.value = [];
            await fetchUsers();
            
        } else {
            console.error("Erreur lors de la mise à jour de la tâche.");
        }
    } catch (error) {
        console.error("Une erreur s'est produite lors de la mise à jour de la tâche.", error);
    }
};


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

const assignTo = async (taskId, contributorId, isChecked) => {
    const request = new Request(
        `https://kaitokid.fr/api/tasks/${taskId}`,
        {
            method: 'PATCH',
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/merge-patch+json"
            },
            body: JSON.stringify({
                assignTo: isChecked
                    ? [...taskAssignedContributors.value, contributorId]
                    : taskAssignedContributors.value.filter(id => id !== contributorId)
            })
        }
    );

    const response = await fetch(request);

    if (response.ok) {
        if (isChecked) {
            taskAssignedContributors.value.push(contributorId);
        } else {
            taskAssignedContributors.value = taskAssignedContributors.value.filter(id => id !== contributorId);
        }
    } else {
        console.error("Erreur lors de la modification de l'attribution.");
    }
};



onMounted(async () => {
    await fetchUsers();
})

const fetchUsers = async () => {
    const url = window.location.href;
    const idList = url.substring(url.lastIndexOf('/') + 1);

    const requestToken = new Request(
        "https://kaitokid.fr/api/get-list/" + idList,
        {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        });

    fetch(requestToken)
        .then(response => response.status === 200 && response.json())
        .then(data => {
            if (data) {
                const tasks = data["hydra:member"][2]

                tasks.forEach((task) => {
                    if (task.status === 0) {
                        list1.value.push(task)
                    } else {
                        list2.value.push(task)
                    }
                })
                contributors.value = data["hydra:member"][1]
            }
        })
}

</script>