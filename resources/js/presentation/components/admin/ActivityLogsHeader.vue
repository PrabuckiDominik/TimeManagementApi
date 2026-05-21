<template>
  <div>
    <h1 class="text-3xl font-bold text-gray-900">
      {{ $t('admin.activity.title') }}
    </h1>

    <p class="mt-2 text-gray-700">
      {{ $t('admin.activity.total', {count: total}) }}
    </p>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  total: number
}>()
</script>
