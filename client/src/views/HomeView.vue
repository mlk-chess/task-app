<template>
    <NavBar />
    <Home />
    <Footer />
    <Toast type="success" message="Test notification" />
</template>

<script setup>
import NavBar from "../components/NavBar.vue";
import Footer from "../components/Footer.vue";
import Home from "../components/Home.vue";
import Toast from "@/components/UI/Toast.vue";


</script>