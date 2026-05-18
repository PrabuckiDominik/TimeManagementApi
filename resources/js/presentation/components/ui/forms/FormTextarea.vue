<template>
  <FormField
    :id="id"
    :label="label"
    :error="error"
  >
    <template
      v-if="$slots.meta"
      #meta
    >
      <slot name="meta" />
    </template>

    <textarea
      :id="id"
      :value="modelValue"
      :rows="rows"
      :maxlength="maxlength"
      :placeholder="placeholder"
      :aria-invalid="Boolean(error?.length)"
      :aria-describedby="error?.length ? `${id}-error` : undefined"
      class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
      @input="$emit('update:modelValue', ($event.target as HTMLTextAreaElement).value)"
    />
  </FormField>
</template>

<script setup lang="ts">
import FormField from '@/presentation/components/ui/forms/FormField.vue'

withDefaults(
  defineProps<{
    id: string
    label: string
    modelValue: string | null
    rows?: number
    placeholder?: string
    maxlength?: number
    error?: string[]
  }>(),
  {
    rows: 4,
    placeholder: '',
    maxlength: undefined,
    error: undefined,
  },
)

defineEmits<{
  'update:modelValue': [value: string]
}>()
</script>
