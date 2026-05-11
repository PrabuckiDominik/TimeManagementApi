<template>
  <div
    class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4"
  >
    <DashboardStatCard
      title="Total Tasks"
      :value="stats.total_tasks"
    />

    <DashboardStatCard
      title="Completed"
      :value="stats.completed"
    />

    <DashboardStatCard
      title="In Progress"
      :value="stats.in_progress"
    />

    <DashboardStatCard
      title="Overdue"
      :value="stats.overdue"
      danger
    />
  </div>
</template>

<script setup lang="ts">
import DashboardStatCard from "@/presentation/components/dashboard/cards/DashboardStatCard.vue"

import type { DashboardStats } from "@/domain/dashboard/models/DashboardStats"

defineProps<{
  stats: DashboardStats
}>()
</script>
