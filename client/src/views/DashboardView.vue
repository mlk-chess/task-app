<template>
    <NavBar />

    <!-- <section class="m-10">
        <Calendar />
    </section> -->

    <section>
        <div class="row">
        <div class="col-3">
          <h3>Draggable 1</h3>
          <draggable
            class="list-group"
            :list="list1"
            group="people"
            @change="log"
            itemKey="name"
          >
            <template #item="{ element, index }">
              <div class="list-group-item">{{ element.name }} {{ index }}</div>
            </template>
          </draggable>
        </div>

        <div class="col-3">
          <h3>Draggable 2</h3>
          <button @click="add"> Add + </button>
          <draggable
            class="list-group"
            :list="list2"
            group="people"
            @change="log"
            itemKey="name"
          >
            <template #item="{ element, index }">
              <div class="list-group-item">
                {{ index }} {{ element.name }}
                <button @click="removeItem(index)">Supprimer</button>
            </div>
            </template>
          </draggable>
        </div>

        <!-- <rawDisplayer class="col-3" :value="list1" title="List 1" />

        <rawDisplayer class="col-3" :value="list2" title="List 2" /> -->
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