<template>
    <NavBar />

    <!-- <section class="m-10">
        <Calendar />
    </section> -->

    <section>
        <Sortable :list="elements" item-key="id" tag="div" :options="options">
            <template #header>
                <header>
                    <h1>SortableJS Vue3 Demo</h1>
                </header>
            </template>
            <template #item="{ element, index }">
                <div class="draggable" :key="element.id">
                    {{ element.name }}
                </div>
            </template>
            <template #footer>
                <footer class="draggable">A footer</footer>
            </template>
        </Sortable>
    </section>

    <Footer />
</template>

<script setup>
import NavBar from "../components/NavBar.vue";
import Footer from "../components/Footer.vue";
import Calendar from "../components/UI/Calendar.vue";
import { Sortable } from "sortablejs-vue3";
import { ref, watch } from 'vue';

const elements = ref([
    {
        'id': 1,
        'name': 'task1'
    }, {
        'id': 2,
        'name': 'task2'
    }, {
        'id': 3,
        'name': 'task3'
    }, {
        'id': 4,
        'name': 'task4'
    },
])

const options = ref({
    onEnd: (evt) => {
        console.log(evt);
    }
})

watch(elements, (newVal, oldVal) => {
    console.log(newVal);
})


</script>