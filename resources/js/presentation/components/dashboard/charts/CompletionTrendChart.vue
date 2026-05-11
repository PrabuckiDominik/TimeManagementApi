<template>
  <Line
    :data="chartData"
    :options="options"
  />
</template>

<script setup lang="ts">
import {
  CategoryScale,
  Chart as ChartJS,
  Legend,
  LineElement,
  LinearScale,
  PointElement,
  Tooltip,
} from "chart.js"

import { computed } from "vue"

import { Line } from "vue-chartjs"

import type { CompletionTrend } from "@/domain/dashboard/models/DashboardStats"

ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Tooltip,
  Legend,
)

const props = defineProps<{
  data: CompletionTrend
}>()

const chartData = computed(() => ({
  labels: props.data.days.map(day =>
    new Date(day.date).toLocaleDateString(),
  ),

  datasets: [
    {
      label: "Completed tasks",
      data: props.data.days.map(day => day.count),

      borderColor: "#6366F1",
      backgroundColor: "#6366F1",

      tension: 0.4,
    },
  ],
}))

const options = {
  responsive: true,
  maintainAspectRatio: false,
}
</script>
