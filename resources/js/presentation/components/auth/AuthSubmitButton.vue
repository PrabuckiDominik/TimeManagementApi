<script setup lang="ts">
defineProps<{
  loading?: boolean
  label: string
}>()
</script>

<template>
  <button
    type="submit"
    :disabled="loading"
    class="mt-4 w-full rounded-xl bg-gradient-to-r from-blue-500 to-violet-600 px-4 py-3 text-lg font-semibold text-white shadow-lg transition hover:scale-[1.01] hover:opacity-95 disabled:cursor-not-allowed disabled:opacity-70"
  >
    {{ loading ? "Loading..." : label }}
  </button>
</template>
