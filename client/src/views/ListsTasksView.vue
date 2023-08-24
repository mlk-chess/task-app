<template>
    <Loading v-if="isLoad" />
    <template v-else>
        <NavBar />

        <div class="flex m-10 sm:flex-col md:flex-row">
            <div class="card w-96 bg-base-100 shadow-xl m-10" v-for="list in lists">
                <div class="card-body">
                    <h2 class="card-title">{{ list.name }}</h2>
                    <div class="card-actions justify-end">
                        <button class="btn">Consulter</button>
                    </div>
                </div>
            </div>
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

const lists = ref([])
const isLoad = ref(true);

onMounted(async () => {
    await fetchUsers();
})

const fetchUsers = async () => {
    const token = jsCookie.get('jwt')
    const requestToken = new Request(
        "https://localhost/list_tasks",
        {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token
            }
        });

    fetch(requestToken)
        .then(response => response.status === 200 && response.json())
        .then(data => {
            lists.value = data["hydra:member"]
            console.table(data["hydra:member"])
        })

    isLoad.value = false;
}

</script>