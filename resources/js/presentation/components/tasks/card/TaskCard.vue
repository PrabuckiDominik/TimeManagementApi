<template>
  <AppCard
    class="transition"
    :class="isCompleted
      ? 'bg-gray-100'
      : 'hover:border-indigo-300'"
  >
    <div class="flex items-start gap-4">
      <button
        type="button"
        class="mt-1 flex size-6 shrink-0 items-center justify-center rounded-full border transition"
        :class="isCompleted
          ? 'border-green-600 bg-green-100 text-green-800'
          : 'border-gray-400 hover:border-indigo-600'"
        :aria-label="isCompleted
          ? $t('tasks.actions.mark_as_todo')
          : $t('tasks.actions.mark_as_done')"
        @click="emit('toggleDone', task)"
      >
        <span
          v-if="isCompleted"
          aria-hidden="true"
        >
          ✓
        </span>
      </button>

      <div class="min-w-0 flex-1">
        <h3
          class="break-words text-lg font-semibold"
          :class="isCompleted
            ? 'text-gray-700 line-through'
            : 'text-gray-900'"
        >
          {{ task.name }}
        </h3>

        <p
          v-if="task.description"
          class="mt-2 break-words text-sm text-gray-700"
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
            class="rounded-md bg-green-100 px-3 py-1 text-xs font-medium text-green-800"
          >
            {{ $t('tasks.completed') }}:
            {{ formatDate(task.completed_at) }}
          </span>

          <span
            v-if="task.due_date"
            class="rounded-md px-3 py-1 text-xs font-medium"
            :class="task.is_overdue
              ? 'bg-red-100 text-red-800'
              : 'bg-gray-100 text-gray-800'"
          >
            {{ $t('tasks.due') }}:
            {{ formatDate(task.due_date) }}
          </span>

          <span
            v-for="tag in task.tags"
            :key="tag.id"
            class="text-xs text-gray-600"
          >
            #{{ tag.name }}
          </span>
        </div>
      </div>

      <div
        class="relative shrink-0"
        @keydown="handleEscape"
      >
        <button
          type="button"
          class="rounded-lg p-2 text-gray-700 transition hover:bg-gray-100 hover:text-gray-900"
          :aria-label="$t('tasks.actions.open_menu')"
          :aria-expanded="menuOpen"
          aria-haspopup="menu"
          @click="menuOpen = !menuOpen"
        >
          <span aria-hidden="true">
            ⋮
          </span>
        </button>

        <div
          v-if="menuOpen"
          role="menu"
          class="absolute right-0 z-20 mt-2 w-40 rounded-xl border border-gray-300 bg-white py-2 shadow-lg"
        >
          <button
            type="button"
            role="menuitem"
            class="block w-full px-4 py-2 text-left text-sm text-gray-800 transition hover:bg-gray-100"
            @click="handleEdit"
          >
            {{ $t('tasks.actions.edit') }}
          </button>

          <button
            type="button"
            role="menuitem"
            class="block w-full px-4 py-2 text-left text-sm text-red-800 transition hover:bg-red-100"
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
import {computed, ref} from 'vue'

import AppBadge from '@/presentation/components/ui/AppBadge.vue'
import AppCard from '@/presentation/components/ui/AppCard.vue'

import type {Task} from '@/domain/tasks/models/Task'

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

const handleEscape = (event: KeyboardEvent): void => {
  if (event.key === 'Escape') {
    menuOpen.value = false
  }
}
</script>
