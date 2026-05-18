import {httpClient} from '@/data/http/httpClient'

import type {StoreTaskDto} from '@/domain/tasks/dto/StoreTaskDto'
import {type UpdateTaskDto} from '@/domain/tasks/dto/UpdateTaskDto'

export const TaskApi = {
  async getAll() {
    return await httpClient.get('/api/tasks')
  },

  async create(dto: StoreTaskDto) {
    return await httpClient.post('/api/tasks', dto)
  },

  async update(id: number, dto: UpdateTaskDto) {
    return await httpClient.put(`/api/tasks/${id}`, dto)
  },

  async delete(id: number) {
    return await httpClient.delete(`/api/tasks/${id}`)
  },
}
