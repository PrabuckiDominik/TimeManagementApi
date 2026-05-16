<template>
  <AppCard
    class="transition"
    :class="isCompleted
      ? 'bg-gray-50 opacity-70'
      : 'hover:border-indigo-200'"
  >
    <div class="flex items-start gap-4">
      <button
        type="button"
        class="mt-1 flex size-6 shrink-0 items-center justify-center rounded-full border transition"
        :class="isCompleted
          ? 'border-green-400 bg-green-50 text-green-500'
          : 'border-gray-300 hover:border-indigo-400'"
        @click="emit('toggleDone', task)"
      >
        <span v-if="isCompleted">
          ✓
        </span>
      </button>

      <div class="min-w-0 flex-1">
        <h3
          class="break-words text-lg font-semibold"
          :class="isCompleted
            ? 'text-gray-400 line-through'
            : 'text-gray-900'"
        >
          {{ task.name }}
        </h3>

        <p
          v-if="task.description"
          class="mt-2 break-words text-sm"
          :class="isCompleted
            ? 'text-gray-400'
            : 'text-gray-500'"
        >
          {{ task.description }}
        </p>

        <div class="mt-4 flex flex-wrap items-center gap-2">
          <AppBadge :variant="priorityVariant">
            {{ $t(`tasks.priority.${task.priority}`) }}
          </AppBadge>

          <span
            v-if="task.category"
            class="rounded-md px-3 py-1 text-xs font-medium text-white"
            :style="{
              backgroundColor: task.category.color ?? '#6366f1',
            }"
          >
            {{ task.category.title }}
          </span>

          <span
            v-if="task.completed_at"
            class="rounded-md bg-green-50 px-3 py-1 text-xs font-medium text-green-600"
          >
            {{ $t('tasks.completed') }}:
            {{ formatDate(task.completed_at) }}
          </span>

          <span
            v-if="task.due_date"
            class="rounded-md px-3 py-1 text-xs font-medium"
            :class="task.is_overdue
              ? 'bg-red-100 text-red-600'
              : 'bg-gray-100 text-gray-600'"
          >
            {{ $t('tasks.due') }}:
            {{ formatDate(task.due_date) }}
          </span>

          <span
            v-for="tag in task.tags"
            :key="tag.id"
            class="text-xs text-gray-400"
          >
            #{{ tag.name }}
          </span>
        </div>
      </div>

      <div class="relative shrink-0">
        <button
          type="button"
          class="rounded-lg p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
          @click="menuOpen = !menuOpen"
        >
          ⋮
        </button>

        <div
          v-if="menuOpen"
          class="absolute right-0 z-20 mt-2 w-40 rounded-xl border border-gray-200 bg-white py-2 shadow-lg"
        >
          <button
            type="button"
            class="block w-full px-4 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-50"
            @click="handleEdit"
          >
            {{ $t('tasks.actions.edit') }}
          </button>

          <button
            type="button"
            class="block w-full px-4 py-2 text-left text-sm text-red-600 transition hover:bg-red-50"
            @click="handleDelete"
          >
            {{ $t('tasks.actions.delete') }}
          </button>
        </div>
      </div>
    </div>
  </AppCard>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'

import AppBadge from '@/presentation/components/ui/AppBadge.vue'
import AppCard from '@/presentation/components/ui/AppCard.vue'

import type { Task } from '@/domain/tasks/models/Task'

const props = defineProps<{
  task: Task
}>()

const emit = defineEmits<{
  edit: [task: Task]
  delete: [task: Task]
  toggleDone: [task: Task]
}>()

const menuOpen = ref(false)

const isCompleted = computed(() =>
  props.task.status === 'done',
)

const priorityVariant = computed(() => {
  switch (props.task.priority) {
  case 'high':
    return 'danger'

  case 'medium':
    return 'warning'

  default:
    return 'success'
  }
})

const formatDate = (date: string): string => {
  return new Date(date).toLocaleDateString()
}

const handleEdit = (): void => {
  menuOpen.value = false

  emit('edit', props.task)
}

const handleDelete = (): void => {
  menuOpen.value = false

  emit('delete', props.task)
}
</script>
