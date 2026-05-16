<template>
  <div
    class="flex flex-col gap-3 rounded-2xl border border-gray-200 bg-gray-50 p-4 sm:flex-row sm:items-center sm:justify-between"
  >
    <template v-if="editing">
      <div class="flex flex-1 flex-col gap-3 sm:flex-row">
        <input
          v-model="title"
          type="text"
          maxlength="255"
          class="w-full rounded-xl border border-gray-300 px-4 py-2 outline-none transition focus:border-indigo-500"
        >

        <input
          v-model="color"
          type="color"
          class="h-11 w-16 rounded-xl border border-gray-300 bg-white p-1"
        >
      </div>

      <div class="flex gap-2">
        <button
          type="button"
          class="rounded-xl border border-gray-300 px-4 py-2 text-gray-700 transition hover:bg-white"
          @click="cancel"
        >
          {{ $t('categories.actions.cancel') }}
        </button>

        <AppButton
          type="button"
          :disabled="saving"
          @click="save"
        >
          {{ $t('categories.actions.save') }}
        </AppButton>
      </div>
    </template>

    <template v-else>
      <RouterLink
        :to="`/tasks?category_id=${category.id}`"
        class="flex min-w-0 items-center gap-3"
      >
        <span
          class="size-4 shrink-0 rounded-full"
          :style="{
            backgroundColor: category.color ?? '#6366f1',
          }"
        />

        <span class="truncate font-medium text-gray-900">
          {{ category.title }}
        </span>
      </RouterLink>

      <div class="flex gap-2">
        <button
          type="button"
          class="rounded-xl px-3 py-2 text-sm text-gray-600 transition hover:bg-white"
          @click="editing = true"
        >
          {{ $t('categories.actions.edit') }}
        </button>

        <button
          type="button"
          class="rounded-xl px-3 py-2 text-sm text-red-600 transition hover:bg-red-50"
          @click="$emit('delete', category)"
        >
          {{ $t('categories.actions.delete') }}
        </button>
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

import AppButton from '@/presentation/components/ui/AppButton.vue'

import type { Category } from '@/domain/categories/models/Category'

const props = defineProps<{
  category: Category
  saving: boolean
}>()

const emit = defineEmits<{
  update: [category: Category, payload: { title: string, color: string | null }]
  delete: [category: Category]
}>()

const editing = ref(false)
const title = ref(props.category.title)
const color = ref(props.category.color ?? '#6366f1')

const cancel = (): void => {
  title.value = props.category.title
  color.value = props.category.color ?? '#6366f1'
  editing.value = false
}

const save = (): void => {
  if (!title.value.trim()) {
    return
  }

  emit('update', props.category, {
    title: title.value.trim(),
    color: color.value,
  })

  editing.value = false
}
</script>
