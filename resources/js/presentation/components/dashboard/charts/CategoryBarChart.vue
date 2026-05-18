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
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

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
  labels: props.data.map(item => item.title ?? t('dashboard.task.no_category'),
  ),
  datasets: [
    {
      label: t('dashboard.charts.tasks'),
      data: props.data.map(item => item.count),
      backgroundColor: props.data.map(
        item => item.color ?? '#4338CA',
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
