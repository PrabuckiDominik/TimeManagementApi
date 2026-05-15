import { TaskApi } from '@/data/task/TaskApi'

import type { StoreTaskDto } from '@/domain/tasks/dto/StoreTaskDto'
import type { Task } from '@/domain/tasks/models/Task'
import type { TaskRepository } from '@/domain/tasks/repositories/TaskRepository'

export class CategoryRepositoryImpl implements TaskRepository {
  async getAll(): Promise<Task[]> {
    const response = await TaskApi.getAll()

    return response.data.data
  }

  async create(dto: StoreTaskDto): Promise<Task> {
    const response = await TaskApi.create(dto)

    return response.data.data
  }
}
