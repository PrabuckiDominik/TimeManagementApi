<script setup lang="ts">
defineProps<{
  label: string
  type?: string
  modelValue: string
  placeholder?: string
  error?: string[]
}>()

defineEmits<(e: 'update:modelValue', value: string) => void>()
</script>

<template>
  <div class="mb-5">
    <label class="mb-2 block text-sm font-medium text-slate-700">
      {{ label }}
    </label>

    <input
      :type="type ?? 'text'"
      :value="modelValue"
      :placeholder="placeholder"
      class="w-full rounded-xl border border-slate-300 px-4 py-3 outline-none transition focus:border-violet-500 focus:ring-2 focus:ring-violet-300"
      @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
    >

    <p
      v-if="error?.length"
      class="mt-2 text-sm text-red-500"
    >
      {{ error[0] }}
    </p>
  </div>
</template>
