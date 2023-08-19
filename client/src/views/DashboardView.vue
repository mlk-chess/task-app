<template>
    <NavBar />

    <section class="m-10">
        <Calendar  />
    </section>

    <Footer />
</template>

<script setup>
import NavBar from "../components/NavBar.vue";
import Footer from "../components/Footer.vue";
import Calendar from "../components/UI/Calendar.vue";

</script>