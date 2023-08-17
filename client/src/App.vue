<script setup>
import { onMounted, ref } from 'vue';
import { RouterView } from 'vue-router'

onMounted(() => {

  const theme = ref(localStorage.getItem("theme") || "lemonade");
  document.querySelector("html").setAttribute("data-theme", theme.value);
})

</script>

<template>
  <main>
    <RouterView />
  </main>
</template>