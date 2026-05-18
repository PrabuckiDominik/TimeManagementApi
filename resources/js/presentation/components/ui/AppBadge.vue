<template>
  <span
    class="rounded-full px-3 py-1 text-sm font-medium"
    :class="variantClasses"
  >
    <slot />
  </span>
</template>

<script setup lang='ts'>
import {computed} from 'vue'

const props = defineProps<{
  variant?: 'success' | 'danger' | 'warning'
}>()

const variantClasses = computed(() => {
  switch (props.variant) {
  case 'danger':
    return 'bg-red-100 text-red-800'

  case 'warning':
    return 'bg-yellow-100 text-yellow-800'

  default:
    return 'bg-green-100 text-green-800'
  }
})
</script>
