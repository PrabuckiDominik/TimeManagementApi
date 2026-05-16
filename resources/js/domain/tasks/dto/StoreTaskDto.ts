import {type TaskStatus} from '@/domain/tasks/types/TaskStatus'
import {type TaskPriority} from '@/domain/tasks/types/TaskPriority'

export interface StoreTaskDto {
  name: string
  description: string | null
  priority: TaskPriority | null
  status: TaskStatus | null
  due_date: string | null
  category_id: number | null
  tag_ids: number[]
}
