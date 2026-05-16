import {type TaskPriority} from '@/domain/tasks/types/TaskPriority'
import {type TaskStatus} from '@/domain/tasks/types/TaskStatus'

export interface TaskCategory {
  id: number
  title: string
  color: string | null
}

export interface TaskTag {
  id: number
  name: string
}

export interface Task {
  id: number
  name: string
  description: string | null
  priority: TaskPriority
  status: TaskStatus
  due_date: string | null
  completed_at: string | null
  is_overdue: boolean
  created_at: string
  updated_at: string

  category: TaskCategory | null
  tags: TaskTag[]
}
