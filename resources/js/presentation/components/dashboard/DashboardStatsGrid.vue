<template>
  <div
    class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4"
  >
    <DashboardStatCard
      :title="$t('dashboard.grid.total_tasks')"
      :value="stats?.task_stats?.total_tasks ?? 0"
    />

    <DashboardStatCard
      :title="$t('dashboard.grid.completed')"
      :value="stats?.task_stats?.completed ?? 0"
    />

    <DashboardStatCard
      :title="$t('dashboard.grid.in_progress')"
      :value="stats?.task_stats?.in_progress ?? 0"
    />

    <DashboardStatCard
      :title="$t('dashboard.grid.overdue')"
      :value="stats?.task_stats?.overdue ?? 0"
      danger
    />
  </div>
</template>

<script setup lang="ts">
import DashboardStatCard from '@/presentation/components/dashboard/cards/DashboardStatCard.vue'
import type { DashboardStats } from '@/domain/dashboard/models/DashboardStats'

defineProps<{
  stats: DashboardStats
}>()
</script>
