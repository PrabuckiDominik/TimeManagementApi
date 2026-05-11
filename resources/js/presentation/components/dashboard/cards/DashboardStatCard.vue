<template>
  <div
    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
  >
    <div class="flex items-start justify-between">
      <div>
        <p class="text-sm font-medium text-gray-500">
          {{ title }}
        </p>

        <h3 class="mt-4 text-4xl font-bold text-gray-900">
          {{ value }}
        </h3>
      </div>

      <div
        class="rounded-xl p-3"
        :class="danger
          ? 'bg-red-100 text-red-600'
          : 'bg-indigo-100 text-indigo-600'"
      >
        ●
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  title: string
  value: number
  danger?: boolean
}>()
</script>
