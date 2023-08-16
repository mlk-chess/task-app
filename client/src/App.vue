<script setup>
import { ref, watch } from 'vue';
import { RouterView } from 'vue-router'

const theme = ref(localStorage.getItem("theme") || "lemonade");

watch(theme, (newTheme) => {
  document.querySelector("html").setAttribute("data-theme", newTheme);
  localStorage.setItem("theme", newTheme);
});

document.querySelector("html").setAttribute("data-theme", theme.value);
</script>

<template>
    <main>
      <RouterView />
  </main>
</template>