<template>
  <div
    class="flex flex-col gap-3 rounded-2xl bg-gray-50 p-4 sm:flex-row sm:items-center sm:justify-between"
  >
    <div class="min-w-0">
      <h4 class="truncate font-medium text-gray-900">
        {{ task.name }}
      </h4>

      <p class="mt-1 text-sm text-gray-700">
        {{ task.category?.title ?? $t('dashboard.task.no_category') }}
      </p>

      <p
        v-if="task.due_date"
        class="mt-1 text-sm text-gray-700"
      >
        {{ $t('dashboard.task.due') }}:
        {{ formatDate(task.due_date) }}
      </p>
    </div>

    <div
      class="w-fit shrink-0 rounded-full px-3 py-1 text-sm font-medium"
      :class="task.is_overdue
        ? 'bg-red-100 text-red-800'
        : 'bg-green-100 text-green-800'"
    >
      {{ task.is_overdue ? $t('dashboard.task.overdue') : $t('dashboard.task.upcoming') }}
    </div>
  </div>
</template>

<script setup lang='ts'>
import type {UpcomingDeadlineTask} from '@/domain/dashboard/models/DashboardStats'

defineProps<{
  task: UpcomingDeadlineTask
}>()

const formatDate = (date: string): string => {
  return new Date(date).toLocaleDateString()
}
</script>
