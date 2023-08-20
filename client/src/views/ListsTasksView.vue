<template>
    <NavBar />

    <section>
        <div class="flex items-center sm:flex-col md:flex-row">
            <div class="card w-96 bg-base-100 shadow-2xl m-10">
                <div class="card-body">
                    <h3 class="card-title">En cours</h3>
                    <draggable class="mt-10" :list="list1" group="tasks" @change="log" itemKey="name">
                        <template #item="{ element, index }">
                            <div class="alert mb-5">
                                <span>{{ element.name }}</span>
                            </div>
                        </template>
                    </draggable>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" onclick="todo.showModal()">Ajouter une tâche</button>
                        <Modal id="todo">
                            <template #header>
                                Ajouter une tâche à "En cours"
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
                    <draggable class="mt-10" :list="list2" group="tasks" @change="log" itemKey="name">
                        <template #item="{ element, index }">
                            <div class="alert mb-5 flex justify-between">
                                <span>{{ element.name }}</span>
                                <button @click="removeItem(index)">Supprimer</button>
                            </div>
                        </template>
                    </draggable>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" onclick="done.showModal()">Ajouter une tâche</button>
                        <Modal id="done">
                            <template #header>
                                Ajouter une tâche à "Terminé"
                            </template>
                            <template #content>
                                <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" />
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
import { ref, watch } from "vue";
import draggable from "vuedraggable";
import Modal from "../components/UI/Modal.vue";

const list1 = ref([
    { name: "John", id: 1 },
    { name: "Joao", id: 2 },
    { name: "Jean", id: 3 },
    { name: "Gerard", id: 4 }
]);

const list2 = ref([
    { name: "Juan", id: 5 },
    { name: "Edgard", id: 6 },
    { name: "Johnson", id: 7 }
]);

watch(list1.value, (newX) => {
    console.table(newX)
    console.log(newX[0].name)
})

const add = () => {
    list2.value.push({ name: "Mohamed" });
};

const remove = () => {
    list1.value.pop();
}

const removeItem = (e) => {
    const indexToRemove = e;
    list2.value.splice(indexToRemove, 1);
}

const replace = () => {
    list1.value = [{ name: "Edgard" }];
};

const clone = (el) => {
    return {
        name: el.name + " cloned"
    };
};

const log = (evt) => {
    console.log(evt);
};

</script>