<template>
  <Pie
    :data="chartData"
    :options="options"
  />
</template>

<script setup lang="ts">
import {ArcElement, Chart as ChartJS, Legend, Tooltip} from 'chart.js'
import {computed} from 'vue'
import {useI18n} from 'vue-i18n'
import {Pie} from 'vue-chartjs'

import type {StatusDistribution} from '@/domain/dashboard/models/DashboardStats'

ChartJS.register(
  ArcElement,
  Tooltip,
  Legend,
)

const props = defineProps<{
  data: StatusDistribution[]
}>()

const {t} = useI18n()

const chartData = computed(() => ({
  labels: props.data.map(item =>
    t(`tasks.status.${item.status}`),
  ),

  datasets: [
    {
      data: props.data.map(item => item.count),
      backgroundColor: props.data.map(item => {
        switch (item.status) {
        case 'todo':
          return '#3B82F6'

        case 'in_progress':
          return '#F59E0B'

        case 'done':
          return '#10B981'

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
