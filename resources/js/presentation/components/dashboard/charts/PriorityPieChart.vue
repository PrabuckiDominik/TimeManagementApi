<template>
  <Pie :data="chartData" :options="options" />
</template>

<script setup lang='ts'>
import {
  ArcElement,
  Chart as ChartJS,
  Legend,
  Tooltip,
} from 'chart.js'

import { computed } from 'vue'

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

const chartData = computed(() => ({
  labels: props.data.map(item => item.priority),

  datasets: [
    {
      data: props.data.map(item => item.count),
      backgroundColor: [
        '#10B981',
        '#F59E0B',
        '#EF4444',
      ],
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
  },
}
</script>
