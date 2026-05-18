<template>
  <section class="space-y-4">
    <div class="flex items-center justify-between">
      <h2 class="text-sm font-semibold uppercase tracking-wide text-gray-700">
        {{ title }} ({{ tasks.length }})
      </h2>
    </div>

    <div
      v-if="tasks.length === 0"
      class="rounded-2xl border border-dashed border-gray-200 bg-white p-8 text-center text-sm text-gray-500"
    >
      No tasks found
    </div>

    <div
      v-else
      class="space-y-4"
    >
      <TaskCard
        v-for="task in tasks"
        :key="task.id"
        :task="task"
        @edit="$emit('edit', $event)"
        @delete="$emit('delete', $event)"
        @toggle-done="$emit('toggleDone', $event)"
      />
    </div>
  </section>
</template>

<script setup lang="ts">
import TaskCard from '@/presentation/components/tasks/card/TaskCard.vue'

import type {Task} from '@/domain/tasks/models/Task'

defineProps<{
  title: string
  tasks: Task[]
}>()

defineEmits<{
  edit: [task: Task]
  delete: [task: Task]
  toggleDone: [task: Task]
}>()
</script>
