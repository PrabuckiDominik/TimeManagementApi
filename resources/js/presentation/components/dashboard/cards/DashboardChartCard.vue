<template>
  <div
    class="rounded-2xl border border-gray-300 bg-white p-6 shadow-sm"
  >
    <h3 class="text-lg font-semibold text-gray-900">
      {{ title }}
    </h3>

    <div class="mt-6 h-[320px]">
      <slot />
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string
}>()
</script>
