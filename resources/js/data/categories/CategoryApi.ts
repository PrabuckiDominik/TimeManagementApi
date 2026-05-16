import { httpClient } from '@/data/http/httpClient'

import type { StoreCategoryDto } from '@/domain/categories/dto/StoreCategoryDto'
import type { UpdateCategoryDto } from '@/domain/categories/dto/UpdateCategoryDto'

export const CategoryApi = {
  async getAll() {
    return await httpClient.get('/api/categories')
  },

  async create(dto: StoreCategoryDto) {
    return await httpClient.post('/api/categories', dto)
  },

  async update(id: number, dto: UpdateCategoryDto) {
    return await httpClient.put(`/api/categories/${id}`, dto)
  },

  async delete(id: number) {
    return await httpClient.delete(`/api/categories/${id}`)
  },
}
