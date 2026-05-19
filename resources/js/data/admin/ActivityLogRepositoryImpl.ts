import {ActivityLogsApi} from '@/data/admin/ActivityLogsApi'

import type {ActivityLog} from '@/domain/admin/models/ActivityLog'
import type {ActivityLogRepository} from '@/domain/admin/repositories/ActivityLogRepository'

export class ActivityLogRepositoryImpl
implements ActivityLogRepository {
  async getAll(
    page: number,
    perPage: number,
  ): Promise<{
    data: ActivityLog[]
    meta: {
      current_page: number
      last_page: number
      per_page: number
      total: number
    }
  }> {
    const response = await ActivityLogsApi.getAll(
      page,
      perPage,
    )

    return {
      data: response.data.data,
      meta: response.data.meta,
    }
  }
}
