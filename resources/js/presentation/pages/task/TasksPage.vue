<template>
  <AppLayout>
    <div class="space-y-6">
      <TaskHeader
        :total-tasks="filteredTasks.length"
        @create="createModalOpen = true"
      />

      <TaskFilters
        v-model:search="search"
        v-model:status="status"
      />

      <TaskTagsPanel @changed="fetchTasks" />

      <template v-if="loading">
        <div class="space-y-4">
          <AppSkeleton
            v-for="item in 6"
            :key="item"
            height="h-40"
          />
        </div>
      </template>

      <TaskList
        v-else
        :tasks="filteredTasks"
        @edit="openEditModal"
        @delete="handleDeleteTask"
        @toggle-done="toggleTaskDone"
      />

      <TaskFormModal
        v-if="createModalOpen"
        @close="createModalOpen = false"
        @saved="handleCreateTask"
      />

      <TaskFormModal
        v-if="editingTask"
        :task="editingTask"
        @close="editingTask = null"
        @saved="handleUpdateTask"
      />
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import {computed, ref} from 'vue'

import AppLayout from '@/presentation/layouts/AppLayout.vue'
import AppSkeleton from '@/presentation/components/ui/AppSkeleton.vue'

import TaskFilters from '@/presentation/components/tasks/TaskFilters.vue'
import TaskHeader from '@/presentation/components/tasks/TaskHeader.vue'
import TaskList from '@/presentation/components/tasks/TaskList.vue'
import TaskFormModal from '@/presentation/components/tasks/modals/TaskFormModal.vue'
import TaskTagsPanel from '@/presentation/components/tasks/tags/TaskTagsPanel.vue'
import {useTasks} from '@/presentation/composables/useTasks'
import type {StoreTaskDto} from '@/domain/tasks/dto/StoreTaskDto'
import type {Task} from '@/domain/tasks/models/Task'
import {useRoute} from 'vue-router'
import {useI18n} from 'vue-i18n'

const route = useRoute()

const {
  tasks,
  loading,
  fetchTasks,
  createTask,
  updateTask,
  deleteTask,
  toggleTaskDone,
} = useTasks()

const search = ref('')
const status = ref('')
const createModalOpen = ref(false)
const editingTask = ref<Task | null>(null)

const filteredTasks = computed(() => {
  const categoryId = route.query.category_id
    ? Number(route.query.category_id)
    : null

  return tasks.value.filter(task => {
    const query = search.value.toLowerCase()

    const matchesSearch =
      task.name.toLowerCase().includes(query)
      || (task.description?.toLowerCase().includes(query) ?? false)
      || task.tags.some(tag =>
        tag.name.toLowerCase().includes(query),
      )

    const matchesStatus =
      status.value === '' || task.status === status.value

    const matchesCategory =
      categoryId === null || task.category?.id === categoryId

    return matchesSearch && matchesStatus && matchesCategory
  })
})

const openEditModal = (task: Task): void => {
  editingTask.value = task
}

const handleCreateTask = async (dto: StoreTaskDto): Promise<void> => {
  await createTask(dto)

  createModalOpen.value = false
}

const handleUpdateTask = async (dto: StoreTaskDto): Promise<void> => {
  if (!editingTask.value) {
    return
  }

  await updateTask(editingTask.value, dto)

  editingTask.value = null
}

const {t} = useI18n()
const handleDeleteTask = async (task: Task): Promise<void> => {
  if (!confirm(String(t('tasks.confirm_delete')))) {
    return
  }

  await deleteTask(task)
}
</script>
