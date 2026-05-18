<template>
  <FormField
    :id="id"
    :label="label"
    :error="error"
    :hide-label="hideLabel"
  >
    <select
      :id="id"
      :value="modelValue ?? ''"
      :aria-invalid="Boolean(error?.length)"
      :aria-describedby="error?.length ? `${id}-error` : undefined"
      class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
      @change="$emit('update:modelValue', normalizeValue(($event.target as HTMLSelectElement).value))"
    >
      <slot />
    </select>
  </FormField>
</template>

<script setup lang="ts">
import FormField from '@/presentation/components/ui/forms/FormField.vue'

defineProps<{
  id: string
  label: string
  modelValue: string | number | null
  error?: string[]
  hideLabel?: boolean
}>()

defineEmits<{
  'update:modelValue': [value: string | number | null]
}>()

const normalizeValue = (value: string): string | null => {
  return value === '' ? null : value
}
</script>
