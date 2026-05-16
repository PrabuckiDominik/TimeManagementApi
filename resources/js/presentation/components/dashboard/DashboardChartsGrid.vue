<template>
  <div class="grid grid-cols-1 gap-6 2xl:grid-cols-2">
    <DashboardChartCard
      v-if="hasStatusData"
      :title="$t('dashboard.charts.status_distribution')"
    >
      <StatusPieChart :data="stats.status_distribution" />
    </DashboardChartCard>

    <DashboardChartCard
      v-if="hasPriorityData"
      :title="$t('dashboard.charts.priority_distribution')"
    >
      <PriorityPieChart :data="stats.priority_distribution" />
    </DashboardChartCard>

    <DashboardChartCard
      v-if="hasCategoryData"
      :title="$t('dashboard.charts.category_distribution')"
    >
      <CategoryBarChart :data="stats.category_distribution" />
    </DashboardChartCard>

    <DashboardChartCard
      v-if="hasCompletionTrendData"
      :title="$t('dashboard.charts.completion_trend')"
    >
      <CompletionTrendChart :data="stats.completion_trend" />
    </DashboardChartCard>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

import DashboardChartCard from '@/presentation/components/dashboard/cards/DashboardChartCard.vue'

import CategoryBarChart from '@/presentation/components/dashboard/charts/CategoryBarChart.vue'
import CompletionTrendChart from '@/presentation/components/dashboard/charts/CompletionTrendChart.vue'
import PriorityPieChart from '@/presentation/components/dashboard/charts/PriorityPieChart.vue'
import StatusPieChart from '@/presentation/components/dashboard/charts/StatusPieChart.vue'

import type { DashboardStats } from '@/domain/dashboard/models/DashboardStats'

const props = defineProps<{
  stats: DashboardStats
}>()

const hasStatusData = computed(() =>
  props.stats.status_distribution.some(item => item.count > 0),
)

const hasPriorityData = computed(() =>
  props.stats.priority_distribution.some(item => item.count > 0),
)

const hasCategoryData = computed(() =>
  props.stats.category_distribution.some(item => item.count > 0),
)

const hasCompletionTrendData = computed(() =>
  props.stats.completion_trend.days.some(item => item.count > 0),
)
</script>
