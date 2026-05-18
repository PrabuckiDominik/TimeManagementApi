import {httpClient} from '@/data/http/httpClient'

import type {StoreTagDto} from '@/domain/tags/dto/StoreTagDto'
import type {UpdateTagDto} from '@/domain/tags/dto/UpdateTagDto'

export const TagApi = {
  async getAll() {
    return await httpClient.get('/api/tags')
  },

  async create(dto: StoreTagDto) {
    return await httpClient.post('/api/tags', dto)
  },

  async update(id: number, dto: UpdateTagDto) {
    return await httpClient.put(`/api/tags/${id}`, dto)
  },

  async delete(id: number) {
    return await httpClient.delete(`/api/tags/${id}`)
  },
}
