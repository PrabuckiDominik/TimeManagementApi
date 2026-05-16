<script setup lang="ts">
defineProps<{
  title: string
  subtitle: string
}>()
</script>

<template>
  <div class="mb-8">
    <h2 class="text-4xl font-bold text-slate-800">
      {{ title }}
    </h2>

    <p class="mt-2 text-slate-500">
      {{ subtitle }}
    </p>
  </div>
</template>
