<template>
    <NavBar />

    <section>
        <div class="flex items-center">
            <div class="card w-96 bg-base-100 shadow-2xl m-10">
                <div class="card-body">
                    <h3 class="card-title">En cours</h3>
                    <!-- <p>If a dog chews shoes whose shoes does he choose?</p> -->
                    <draggable class="list-group mt-10" :list="list1" group="people" @change="log" itemKey="name">
                        <template #item="{ element, index }">
                            <div class="list-group-item">{{ index }} - {{ element.name }}</div>
                        </template>
                    </draggable>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" @click="add">Ajouter une tâche</button>
                    </div>
                </div>
            </div>

            <div class="card w-96 bg-base-100 shadow-xl m-10">

                <div class="card-body">
                    <h3 class="card-title">Terminé</h3>
                    <!-- <p>If a dog chews shoes whose shoes does he choose?</p> -->
                    <draggable class="list-group mt-10" :list="list2" group="people" @change="log" itemKey="name">
                        <template #item="{ element, index }">
                            <div class="list-group-item">
                                {{ index }} - {{ element.name }}
                                <button @click="removeItem(index)">Supprimer</button>
                            </div>
                        </template>
                    </draggable>
                    <div class="card-actions justify-end">
                        <button class="btn btn-primary" @click="add">Ajouter une tâche</button>
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