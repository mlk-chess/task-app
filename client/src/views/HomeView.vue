<template>
    <NavBar />
    <Home />
    <Footer />
    <div class="toast">
        <Toast type="success" message="Test notification" />
        <Toast type="info" message="A new update has been done" />
        <Toast type="error" message="A new update has been done" />
    </div>
</template>

<script setup>
import NavBar from "../components/NavBar.vue";
import Footer from "../components/Footer.vue";
import Home from "../components/Home.vue";
import Toast from "@/components/UI/Toast.vue";


</script>