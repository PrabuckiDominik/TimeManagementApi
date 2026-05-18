<template>
  <div
    class="flex size-10 items-center justify-center rounded-full bg-indigo-700 font-semibold text-white"
  >
    {{ initials }}
  </div>
</template>

<script setup lang="ts">
defineProps<{
  initials: string
}>()
</script>
