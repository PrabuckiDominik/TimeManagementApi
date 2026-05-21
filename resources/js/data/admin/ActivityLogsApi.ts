import {httpClient} from '@/data/http/httpClient'

export const ActivityLogsApi = {
  async getAll(
    page = 1,
    perPage = 20,
  ) {
    return await httpClient.get('/api/admin/activity-logs', {
      params: {
        page,
        per_page: perPage,
      },
    })
  },
}
