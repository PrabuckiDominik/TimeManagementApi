import { DashboardApi } from '@/data/dashboard/DashboardApi'

import type { DashboardRepository } from '@/domain/dashboard/repositories/DashboardRepository'
import type { DashboardStats } from '@/domain/dashboard/models/DashboardStats'

export class DashboardRepositoryImpl implements DashboardRepository {
  async getStats(): Promise<DashboardStats> {
    const response = await DashboardApi.get()

    return response.data.data
  }
}
