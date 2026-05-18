<template>
  <div>
    <div class="flex items-center justify-between">
      <label
        :for="id"
        :class="hideLabel
          ? 'sr-only'
          : 'text-sm font-medium text-gray-700'"
      >
        {{ label }}
      </label>

      <slot name="meta" />
    </div>

    <div :class="hideLabel ? '' : 'mt-2'">
      <slot />
    </div>

    <p
      v-if="error?.length"
      :id="`${id}-error`"
      class="mt-2 text-sm text-red-500"
    >
      {{ error[0] }}
    </p>
  </div>
</template>

<script setup lang="ts">
withDefaults(
  defineProps<{
    id: string
    label: string
    error?: string[]
    hideLabel?: boolean
  }>(),
  {
    error: undefined,
    hideLabel: false,
  },
)
</script>
