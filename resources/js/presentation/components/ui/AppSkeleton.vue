<template>
  <div
    class="animate-pulse rounded-2xl bg-gray-200"
    :class="height"
  />
</template>

<script setup lang='ts'>
withDefaults(
  defineProps<{
    height?: string
  }>(),
  {
    height: 'h-32',
  },
)
</script>
