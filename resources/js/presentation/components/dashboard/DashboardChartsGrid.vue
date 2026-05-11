<template>
  <div class="grid grid-cols-1 gap-6 2xl:grid-cols-2">
    <DashboardChartCard title="Task Status Distribution">
      <StatusPieChart
        :data="stats.status_distribution"
      />
    </DashboardChartCard>

    <DashboardChartCard title="Priority Distribution">
      <PriorityPieChart
        :data="stats.priority_distribution"
      />
    </DashboardChartCard>

    <DashboardChartCard title="Tasks by Category">
      <CategoryBarChart
        :data="stats.category_distribution"
      />
    </DashboardChartCard>

    <DashboardChartCard title="Completion Trend">
      <CompletionTrendChart
        :data="stats.completion_trend"
      />
    </DashboardChartCard>
  </div>
</template>

<script setup lang="ts">
import DashboardChartCard from "@/presentation/components/dashboard/cards/DashboardChartCard.vue"

import StatusPieChart from "@/presentation/components/dashboard/charts/StatusPieChart.vue"
import PriorityPieChart from "@/presentation/components/dashboard/charts/PriorityPieChart.vue"
import CategoryBarChart from "@/presentation/components/dashboard/charts/CategoryBarChart.vue"
import CompletionTrendChart from "@/presentation/components/dashboard/charts/CompletionTrendChart.vue"

import type { DashboardStats } from "@/domain/dashboard/models/DashboardStats"

defineProps<{
  stats: DashboardStats
}>()
</script>
