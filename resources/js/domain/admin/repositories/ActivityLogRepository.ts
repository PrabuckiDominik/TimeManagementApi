import type {ActivityLog} from '@/domain/admin/models/ActivityLog'

export interface ActivityLogRepository {
  getAll: (
    page: number,
    perPage: number,
  ) => Promise<{
    data: ActivityLog[]
    meta: {
      current_page: number
      last_page: number
      per_page: number
      total: number
    }
  }>
}
