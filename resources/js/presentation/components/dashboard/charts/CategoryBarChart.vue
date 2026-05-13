<template>
  <Bar :data="chartData" :options="options" />
</template>

<script setup lang='ts'>
import {
  BarElement,
  CategoryScale,
  Chart as ChartJS,
  Legend,
  LinearScale,
  Tooltip,
} from 'chart.js'

import { computed } from 'vue'

import { Bar } from 'vue-chartjs'

import type { CategoryDistribution } from '@/domain/dashboard/models/DashboardStats'

ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  Tooltip,
  Legend,
)

const props = defineProps<{
  data: CategoryDistribution[]
}>()

const chartData = computed(() => ({
  labels: props.data.map(item => item.title ?? 'No category'),
  datasets: [
    {
      label: 'Tasks',
      data: props.data.map(item => item.count),
      backgroundColor: props.data.map(
        item => item.color ?? '#6366F1',
      ),
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
