<template>
  <FormField
    :id="id"
    :label="label"
    :error="error"
    :hide-label="hideLabel"
  >
    <template
      v-if="$slots.meta"
      #meta
    >
      <slot name="meta" />
    </template>

    <input
      :id="id"
      :value="modelValue"
      :type="type"
      :maxlength="maxlength"
      :placeholder="placeholder"
      :aria-invalid="Boolean(error?.length)"
      :aria-describedby="error?.length ? `${id}-error` : undefined"
      class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    >
  </FormField>
</template>

<script setup lang="ts">
import FormField from '@/presentation/components/ui/forms/FormField.vue'

withDefaults(
  defineProps<{
    id: string
    label: string
    modelValue: string | null
    type?: string
    placeholder?: string
    maxlength?: number
    error?: string[]
    hideLabel?: boolean
  }>(),
  {
    type: 'text',
    placeholder: '',
    maxlength: undefined,
    error: undefined,
  },
)

defineEmits<{
  'update:modelValue': [value: string]
}>()
</script>
