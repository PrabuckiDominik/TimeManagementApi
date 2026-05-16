import { TaskApi } from '@/data/task/TaskApi'

import type { StoreTaskDto } from '@/domain/tasks/dto/StoreTaskDto'
import type { Task } from '@/domain/tasks/models/Task'
import type { TaskRepository } from '@/domain/tasks/repositories/TaskRepository'
import {type UpdateTaskDto} from '@/domain/tasks/dto/UpdateTaskDto'

export class TaskRepositoryImpl implements TaskRepository {
  async getAll(): Promise<Task[]> {
    const response = await TaskApi.getAll()

    return response.data.data
  }

  async create(dto: StoreTaskDto): Promise<Task> {
    const response = await TaskApi.create(dto)

    return response.data.data
  }

  async update(id: number, dto: UpdateTaskDto): Promise<Task> {
    const response = await TaskApi.update(id, dto)

    return response.data.data
  }

  async delete(id: number): Promise<void> {
    await TaskApi.delete(id)
  }
}
