<template>
  <div
    class="flex items-center justify-between rounded-2xl bg-gray-50 p-4"
  >
    <div class="min-w-0">
      <h4 class="truncate font-medium text-gray-900">
        {{ task.name }}
      </h4>

      <p class="mt-1 text-sm text-gray-500">
        {{ task.category?.title ?? "No category" }}
      </p>
    </div>

    <div
      class="rounded-full px-3 py-1 text-sm font-medium"
      :class="task.is_overdue
        ? 'bg-red-100 text-red-600'
        : 'bg-green-100 text-green-600'"
    >
      {{ task.is_overdue ? "Overdue" : "Upcoming" }}
    </div>
  </div>
</template>

<script setup lang="ts">
import type { UpcomingDeadlineTask } from "@/domain/dashboard/models/DashboardStats"

defineProps<{
  task: UpcomingDeadlineTask
}>()
</script>
