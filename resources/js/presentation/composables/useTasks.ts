import {computed, onMounted, ref} from 'vue'

import {TaskRepositoryImpl} from '@/data/task/TaskRepositoryImpl'

import type {StoreTaskDto} from '@/domain/tasks/dto/StoreTaskDto'
import type {UpdateTaskDto} from '@/domain/tasks/dto/UpdateTaskDto'
import type {Task} from '@/domain/tasks/models/Task'

const repository = new TaskRepositoryImpl()

export const useTasks = () => {
  const tasks = ref<Task[]>([])
  const loading = ref(false)
  const saving = ref(false)
  const error = ref<string | null>(null)

  const replaceTask = (task: Task): void => {
    tasks.value = tasks.value.map(item =>
      item.id === task.id ? task : item,
    )
  }

  const removeTask = (task: Task): void => {
    tasks.value = tasks.value.filter(item => item.id !== task.id)
  }

  const fetchTasks = async (): Promise<void> => {
    loading.value = true
    error.value = null

    try {
      tasks.value = await repository.getAll()
    } catch {
      error.value = 'Failed to load tasks.'
    } finally {
      loading.value = false
    }
  }

  const createTask = async (dto: StoreTaskDto): Promise<Task> => {
    saving.value = true
    error.value = null

    try {
      const task = await repository.create(dto)

      tasks.value.unshift(task)

      return task
    } catch (e) {
      error.value = 'Failed to create task.'

      throw e
    } finally {
      saving.value = false
    }
  }

  const updateTask = async (
    task: Task,
    dto: UpdateTaskDto,
  ): Promise<Task> => {
    saving.value = true
    error.value = null

    try {
      const updatedTask = await repository.update(task.id, dto)

      replaceTask(updatedTask)

      return updatedTask
    } catch (e) {
      error.value = 'Failed to update task.'

      throw e
    } finally {
      saving.value = false
    }
  }

  const deleteTask = async (task: Task): Promise<void> => {
    saving.value = true
    error.value = null

    try {
      await repository.delete(task.id)

      removeTask(task)
    } catch (e) {
      error.value = 'Failed to delete task.'

      throw e
    } finally {
      saving.value = false
    }
  }

  const toggleTaskDone = async (task: Task): Promise<void> => {
    await updateTask(task, {
      status: task.status === 'done' ? 'todo' : 'done',
    })
  }

  onMounted(fetchTasks)

  const todoTasks = computed(() =>
    tasks.value.filter(task => task.status === 'todo'),
  )

  const inProgressTasks = computed(() =>
    tasks.value.filter(task => task.status === 'in_progress'),
  )

  const doneTasks = computed(() =>
    tasks.value.filter(task => task.status === 'done'),
  )

  const activeTasksCount = computed(() =>
    todoTasks.value.length + inProgressTasks.value.length,
  )

  return {
    tasks,
    loading,
    saving,
    error,

    fetchTasks,
    createTask,
    updateTask,
    deleteTask,
    toggleTaskDone,

    todoTasks,
    inProgressTasks,
    doneTasks,
    activeTasksCount,
  }
}
