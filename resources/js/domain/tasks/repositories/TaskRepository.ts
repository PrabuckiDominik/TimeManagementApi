import type {StoreTaskDto} from '@/domain/tasks/dto/StoreTaskDto'
import type {UpdateTaskDto} from '@/domain/tasks/dto/UpdateTaskDto'
import type {Task} from '@/domain/tasks/models/Task'

export interface TaskRepository {
  getAll: () => Promise<Task[]>
  create: (dto: StoreTaskDto) => Promise<Task>
  update: (id: number, dto: UpdateTaskDto) => Promise<Task>
  delete: (id: number) => Promise<void>
}
