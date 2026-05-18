<template>
  <div
    class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
  >
    <h2 class="text-xl font-semibold text-gray-900">
      {{ $t('dashboard.grid.upcoming') }}
    </h2>

    <div class="mt-6 space-y-4">
      <UpcomingDeadlineCard
        v-for="task in tasks"
        :key="task.id"
        :task="task"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import UpcomingDeadlineCard from '@/presentation/components/dashboard/cards/UpcomingDeadlineCard.vue'

import type {UpcomingDeadlineTask} from '@/domain/dashboard/models/DashboardStats'

defineProps<{
  tasks: UpcomingDeadlineTask[]
}>()
</script>
