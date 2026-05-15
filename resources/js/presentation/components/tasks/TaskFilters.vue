<template>
  <AppCard>
    <div class="flex flex-wrap items-center gap-4">
      <input
        :value="search"
        type="text"
        :placeholder="$t('tasks.filters.search_placeholder')"
        class="w-full rounded-xl border border-gray-200 px-4 py-2 outline-none transition focus:border-indigo-500 md:w-80"
        @input="onSearchInput"
      >

      <select
        :value="status"
        class="rounded-xl border border-gray-200 px-4 py-2 outline-none"
        @change="onStatusChange"
      >
        <option value="">
          {{ $t('tasks.status.all') }}
        </option>

        <option value="todo">
          {{ $t('tasks.status.todo') }}
        </option>

        <option value="in_progress">
          {{ $t('tasks.status.in_progress') }}
        </option>

        <option value="done">
          {{ $t('tasks.status.done') }}
        </option>
      </select>
    </div>
  </AppCard>
</template>

<script setup lang="ts">
import AppCard from '@/presentation/components/ui/AppCard.vue'

defineProps<{
  search: string
  status: string
}>()

const emit = defineEmits<{
  (e: 'update:search', value: string): void
  (e: 'update:status', value: string): void
}>()

const onSearchInput = (event: Event): void => {
  emit(
    'update:search',
    (event.target as HTMLInputElement).value,
  )
}

const onStatusChange = (event: Event): void => {
  emit(
    'update:status',
    (event.target as HTMLSelectElement).value,
  )
}
</script>
