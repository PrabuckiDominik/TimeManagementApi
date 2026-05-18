<template>
  <div class="space-y-8">
    <TaskStatusSection
      v-if="todoTasks.length"
      :title="$t('tasks.sections.todo')"
      :tasks="todoTasks"
      @edit="$emit('edit', $event)"
      @delete="$emit('delete', $event)"
      @toggle-done="$emit('toggleDone', $event)"
    />

    <TaskStatusSection
      v-if="inProgressTasks.length"
      :title="$t('tasks.sections.in_progress')"
      :tasks="inProgressTasks"
      @edit="$emit('edit', $event)"
      @delete="$emit('delete', $event)"
      @toggle-done="$emit('toggleDone', $event)"
    />

    <TaskStatusSection
      v-if="doneTasks.length"
      :title="$t('tasks.sections.done')"
      :tasks="doneTasks"
      @edit="$emit('edit', $event)"
      @delete="$emit('delete', $event)"
      @toggle-done="$emit('toggleDone', $event)"
    />

    <AppCard
      v-if="tasks.length === 0"
      class="text-center text-sm text-gray-600"
    >
      {{ $t('tasks.empty') }}
    </AppCard>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

import AppCard from '@/presentation/components/ui/AppCard.vue'
import TaskStatusSection from '@/presentation/components/tasks/sections/TaskStatusSection.vue'

import type { Task } from '@/domain/tasks/models/Task'

const props = defineProps<{
  tasks: Task[]
}>()

const sortByDueDate = (tasks: Task[]): Task[] => {
  return [...tasks].sort((a, b) => {
    if (!a.due_date && !b.due_date) {
      return 0
    }

    if (!a.due_date) {
      return 1
    }

    if (!b.due_date) {
      return -1
    }

    return new Date(a.due_date).getTime() - new Date(b.due_date).getTime()
  })
}

const todoTasks = computed(() =>
  sortByDueDate(
    props.tasks.filter(task => task.status === 'todo'),
  ),
)

const inProgressTasks = computed(() =>
  sortByDueDate(
    props.tasks.filter(task => task.status === 'in_progress'),
  ),
)

const doneTasks = computed(() =>
  sortByDueDate(
    props.tasks.filter(task => task.status === 'done'),
  ),
)

defineEmits<{
  edit: [task: Task]
  delete: [task: Task]
  toggleDone: [task: Task]
}>()
</script>
