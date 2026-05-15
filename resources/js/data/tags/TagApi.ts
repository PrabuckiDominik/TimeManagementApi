import { httpClient } from '@/data/http/httpClient'

export const TagApi = {
  async getAll() {
    return await httpClient.get('/api/tags')
  },
}
