<template>
  <AppCard>
    <div class="flex flex-wrap items-center gap-4">
      <label
        for="tasks-search"
        class="sr-only"
      >
        {{ $t('tasks.filters.search_label') }}
      </label>

      <input
        id="tasks-search"
        :value="search"
        type="text"
        :placeholder="$t('tasks.filters.search_placeholder')"
        class="w-full rounded-xl border border-gray-300 px-4 py-2 text-gray-900 outline-none transition placeholder:text-gray-500 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200 md:w-80"
        @input="onSearchInput"
      >

      <label
        for="tasks-status"
        class="sr-only"
      >
        {{ $t('tasks.filters.status_label') }}
      </label>

      <select
        id="tasks-status"
        :value="status"
        class="rounded-xl border border-gray-300 px-4 py-2 text-gray-900 outline-none transition focus:border-indigo-600 focus:ring-2 focus:ring-indigo-200"
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
