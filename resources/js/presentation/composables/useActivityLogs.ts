import {onMounted, ref} from 'vue'

import {ActivityLogRepositoryImpl} from '@/data/admin/ActivityLogRepositoryImpl'

import type {ActivityLog} from '@/domain/admin/models/ActivityLog'

const repository = new ActivityLogRepositoryImpl()

export function useActivityLogs() {
  const logs = ref<ActivityLog[]>([])
  const loading = ref(false)

  const page = ref(1)
  const perPage = ref(20)
  const lastPage = ref(1)
  const total = ref(0)

  const fetchLogs = async (): Promise<void> => {
    loading.value = true

    try {
      const response = await repository.getAll(
        page.value,
        perPage.value,
      )

      logs.value = response.data
      lastPage.value = response.meta.last_page
      total.value = response.meta.total
      perPage.value = response.meta.per_page
    } finally {
      loading.value = false
    }
  }

  const goToPage = async (
    targetPage: number,
  ): Promise<void> => {
    if (
      targetPage < 1
      || targetPage > lastPage.value
    ) {
      return
    }

    page.value = targetPage

    await fetchLogs()
  }

  onMounted(fetchLogs)

  return {
    logs,
    loading,
    page,
    perPage,
    lastPage,
    total,

    fetchLogs,
    goToPage,
  }
}
