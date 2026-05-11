import { onMounted, ref } from "vue"

import { DashboardRepositoryImpl } from "@/data/dashboard/DashboardRepositoryImpl"

import type { DashboardStats } from "@/domain/dashboard/models/DashboardStats"

const repository = new DashboardRepositoryImpl()

export function useDashboard() {
  const loading = ref(false)

  const stats = ref<DashboardStats | null>(null)

  const fetchDashboard = async (): Promise<void> => {
    loading.value = true

    try {
      stats.value = await repository.getStats()
    } finally {
      loading.value = false
    }
  }

  onMounted(fetchDashboard)

  return {
    stats,
    loading,
  }
}
