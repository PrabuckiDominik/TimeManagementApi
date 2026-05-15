import { httpClient } from '@/data/http/httpClient'

export const CategoryApi = {
  async getAll() {
    return await httpClient.get('/api/categories')
  },
}
