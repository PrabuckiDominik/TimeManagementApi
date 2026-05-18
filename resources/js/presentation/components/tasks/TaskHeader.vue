<template>
  <div
    class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
  >
    <div>
      <h1 class="text-3xl font-bold text-gray-900">
        {{ $t('tasks.title') }}
      </h1>

      <p class="mt-2 text-gray-600">
        {{ $t('tasks.total_tasks', {count: totalTasks}) }}
      </p>

      <AppButton
        :aria-label="$t('tasks.modal.create')"
        @click="$emit('create')"
      >
        {{ $t('tasks.modal.create') }}
      </AppButton>
    </div>
  </div>
</template>

<script setup lang="ts">
import AppButton from '@/presentation/components/ui/AppButton.vue'

defineProps<{
  totalTasks: number
}>()

defineEmits<{
  create: []
}>()
</script>
