<template>
  <AppLayout>
    <div class="space-y-6">
      <DashboardHeader />

      <template v-if="loading">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
          <div
            v-for="item in 4"
            :key="item"
            class="h-32 animate-pulse rounded-2xl bg-gray-200"
          />
        </div>
      </template>

      <template v-else-if="stats">
        <DashboardStatsGrid :stats="stats" />

        <DashboardEmptyState
          v-if="stats.task_stats.total_tasks === 0"
        />

        <template v-else>
          <DashboardChartsGrid :stats="stats" />

          <DashboardUpcomingDeadlines
            v-if="stats.upcoming_deadlines.tasks.length > 0"
            :tasks="stats.upcoming_deadlines.tasks"
          />
        </template>
      </template>
    </div>
  </AppLayout>
</template>

<script setup lang='ts'>
import AppLayout from '@/presentation/layouts/AppLayout.vue'

import DashboardHeader from '@/presentation/components/dashboard/DashboardHeader.vue'
import DashboardStatsGrid from '@/presentation/components/dashboard/DashboardStatsGrid.vue'
import DashboardChartsGrid from '@/presentation/components/dashboard/DashboardChartsGrid.vue'
import DashboardUpcomingDeadlines from '@/presentation/components/dashboard/DashboardUpcomingDeadlines.vue'
import DashboardEmptyState from '@/presentation/components/dashboard/DashboardEmptyState.vue'

import { useDashboard } from '@/presentation/composables/useDashboard'

const { stats, loading } = useDashboard()
</script>
