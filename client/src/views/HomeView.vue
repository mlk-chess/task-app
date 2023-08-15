<template>
    <template v-if="!isLoading">
        <NavBar />
        <Home />
        <Footer />
    </template>
    <template v-else>
        <Loading />
    </template>
</template>

<script setup>
import NavBar from "../components/NavBar.vue";
import Footer from "../components/Footer.vue";
import Home from "../components/Home.vue";
import Loading from "../components/UI/Loading.vue";
import { ref } from "vue";


const isLoading = ref(true);
setTimeout(() => (isLoading.value = false), 1000)

</script>