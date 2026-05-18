<template>
  <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">
    <div class="flex items-start justify-between">
      <div>
        <p class="text-sm font-medium text-gray-700">
          {{ title }}
        </p>

        <p class="mt-4 text-3xl font-bold text-gray-900">
          {{ value }}
        </p>
      </div>

      <div
        class="flex size-10 items-center justify-center rounded-xl"
        :class="danger ? 'bg-red-200 text-red-800' : 'bg-indigo-200 text-indigo-800'"
      >
        <span class="text-lg font-bold">
          {{ icon }}
        </span>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
withDefaults(
  defineProps<{
    title: string
    value: number
    icon?: string
    danger?: boolean
  }>(),
  {
    icon: 'Σ',
    danger: false,
  },
)
</script>
