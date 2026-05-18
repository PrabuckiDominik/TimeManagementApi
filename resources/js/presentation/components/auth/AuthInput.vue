<script setup lang="ts">
withDefaults(
  defineProps<{
    id: string
    label: string
    type?: string
    modelValue: string
    placeholder?: string
    error?: string[]
  }>(),
  {
    type: 'text',
    placeholder: '',
    error: undefined,
  },
)

defineEmits<{
  'update:modelValue': [value: string]
}>()
</script>

<template>
  <div class="mb-5">
    <label
      :for="id"
      class="mb-2 block text-sm font-medium text-slate-700"
    >
      {{ label }}
    </label>

    <input
      :id="id"
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :aria-invalid="Boolean(error?.length)"
      :aria-describedby="error?.length ? `${id}-error` : undefined"
      class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-300"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    >

    <p
      v-if="error?.length"
      :id="`${id}-error`"
      class="mt-2 text-sm text-red-500"
    >
      {{ error[0] }}
    </p>
  </div>
</template>
