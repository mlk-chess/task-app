<script setup>
import { onMounted, ref, watch } from 'vue';
import { RouterView } from 'vue-router'
import Loading from './components/UI/Loading.vue';

const theme = ref(localStorage.getItem("theme") || "lemonade");
const isLoading = ref(true)

onMounted(() => {
  isLoading.value = false;
  document.querySelector("html").setAttribute("data-theme", theme.value);
})

</script>

<template>
  <main>
    <section v-if="isLoading">
      <Loading />
    </section>

    <RouterView v-else />
  </main>
</template>