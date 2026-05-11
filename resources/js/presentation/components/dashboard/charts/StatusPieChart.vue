<template>
  <Pie :data="chartData" :options="options" />
</template>

<script setup lang="ts">
import {
  ArcElement,
  Chart as ChartJS,
  Legend,
  Tooltip,
} from "chart.js"

import { computed } from "vue"

import { Pie } from "vue-chartjs"

import type { StatusDistribution } from "@/domain/dashboard/models/DashboardStats"

ChartJS.register(
  ArcElement,
  Tooltip,
  Legend,
)

const props = defineProps<{
  data: StatusDistribution[]
}>()

const chartData = computed(() => ({
  labels: props.data.map(item => item.status),

  datasets: [
    {
      data: props.data.map(item => item.count),
      backgroundColor: [
        "#3B82F6",
        "#10B981",
        "#F59E0B",
      ],
    },
  ],
}))

const options = {
  responsive: true,
  maintainAspectRatio: false,
}
</script>
