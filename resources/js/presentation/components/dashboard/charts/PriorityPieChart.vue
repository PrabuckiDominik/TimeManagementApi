<template>
  <Pie
    :data="chartData"
    :options="options"
  />
</template>

<script setup lang="ts">
import {
  ArcElement,
  Chart as ChartJS,
  Legend,
  Tooltip,
} from 'chart.js'
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { Pie } from 'vue-chartjs'

import type { PriorityDistribution } from '@/domain/dashboard/models/DashboardStats'

ChartJS.register(
  ArcElement,
  Tooltip,
  Legend,
)

const props = defineProps<{
  data: PriorityDistribution[]
}>()

const { t } = useI18n()

const chartData = computed(() => ({
  labels: props.data.map(item =>
    t(`tasks.priority.${item.priority}`),
  ),

  datasets: [
    {
      data: props.data.map(item => item.count),
      backgroundColor: props.data.map(item => {
        switch (item.priority) {
        case 'low':
          return '#10B981'

        case 'medium':
          return '#F59E0B'

        case 'high':
          return '#EF4444'

        default:
          return '#6366F1'
        }
      }),
    },
  ],
}))

const options = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false,
    },
    tooltip: {
      callbacks: {
        label(context: { label: string, parsed: number }) {
          return `${context.label}: ${context.parsed}`
        },
      },
    },
  },
}
</script>
