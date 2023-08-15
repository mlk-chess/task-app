<template>
    <template v-if="!isLoading">
        <NavBar />
        <Home />
        <Footer />
        <Toast type="success" message="Test notification" />
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
import Toast from "@/components/UI/Toast.vue";

import { ref } from "vue";


const isLoading = ref(true);
setTimeout(() => (isLoading.value = false), 1000)

</script>