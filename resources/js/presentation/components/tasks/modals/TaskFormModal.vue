<template>
  <div
    class="fixed inset-0 z-50 bg-black/40 sm:p-4"
    @click.self="$emit('close')"
  >
    <div class="flex min-h-full items-end justify-center sm:items-start sm:py-10">
      <div
        class="flex max-h-dvh w-full flex-col bg-white shadow-xl sm:max-h-[calc(100dvh-5rem)] sm:max-w-2xl sm:rounded-2xl"
      >
        <div class="flex shrink-0 items-center justify-between border-b px-5 py-4 sm:px-6 sm:py-5">
          <h2 class="text-xl font-semibold text-gray-900 sm:text-2xl">
            {{ task ? $t('tasks.modal.edit_title') : $t('tasks.modal.title') }}
          </h2>

          <button
            type="button"
            class="text-2xl text-gray-500 transition hover:text-gray-700"
            @click="$emit('close')"
          >
            ×
          </button>
        </div>

        <form
          class="flex min-h-0 flex-1 flex-col"
          @submit.prevent="submit"
        >
          <div class="min-h-0 flex-1 space-y-5 overflow-y-auto p-5 sm:px-6">
            <div>
              <div class="flex items-center justify-between">
                <label class="text-sm font-medium text-gray-700">
                  {{ $t('tasks.modal.fields.name') }} *
                </label>

                <span
                  class="text-xs"
                  :class="form.name.length > 255 ? 'text-red-500' : 'text-gray-400'"
                >
                  {{ form.name.length }}/255
                </span>
              </div>

              <input
                v-model="form.name"
                type="text"
                maxlength="255"
                class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
                :placeholder="$t('tasks.modal.placeholders.name')"
              >

              <p
                v-if="errors.name"
                class="mt-2 text-sm text-red-500"
              >
                {{ errors.name[0] }}
              </p>
            </div>

            <div>
              <div class="flex items-center justify-between">
                <label class="text-sm font-medium text-gray-700">
                  {{ $t('tasks.modal.fields.description') }}
                </label>

                <span
                  class="text-xs"
                  :class="(form.description?.length ?? 0) > 255 ? 'text-red-500' : 'text-gray-400'"
                >
                  {{ form.description?.length ?? 0 }}/255
                </span>
              </div>

              <textarea
                v-model="form.description"
                rows="4"
                maxlength="255"
                class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
                :placeholder="$t('tasks.modal.placeholders.description')"
              />

              <p
                v-if="errors.description"
                class="mt-2 text-sm text-red-500"
              >
                {{ errors.description[0] }}
              </p>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
              <div>
                <label class="text-sm font-medium text-gray-700">
                  {{ $t('tasks.modal.fields.priority') }}
                </label>

                <select
                  v-model="form.priority"
                  class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
                >
                  <option value="low">
                    {{ $t('tasks.priority.low') }}
                  </option>

                  <option value="medium">
                    {{ $t('tasks.priority.medium') }}
                  </option>

                  <option value="high">
                    {{ $t('tasks.priority.high') }}
                  </option>
                </select>
              </div>

              <div>
                <label class="text-sm font-medium text-gray-700">
                  {{ $t('tasks.modal.fields.status') }}
                </label>

                <select
                  v-model="form.status"
                  class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
                >
                  <option value="todo">
                    {{ $t('tasks.status.todo') }}
                  </option>

                  <option value="in_progress">
                    {{ $t('tasks.status.in_progress') }}
                  </option>

                  <option value="done">
                    {{ $t('tasks.status.done') }}
                  </option>
                </select>
              </div>

              <div>
                <label class="text-sm font-medium text-gray-700">
                  {{ $t('tasks.modal.fields.deadline') }}
                </label>

                <input
                  v-model="form.due_date"
                  type="date"
                  class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
                >
              </div>

              <div>
                <label class="text-sm font-medium text-gray-700">
                  {{ $t('tasks.modal.fields.category') }}
                </label>

                <select
                  v-model="form.category_id"
                  class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
                >
                  <option :value="null">
                    {{ $t('tasks.modal.placeholders.no_category') }}
                  </option>

                  <option
                    v-for="category in categories"
                    :key="category.id"
                    :value="category.id"
                  >
                    {{ category.title }}
                  </option>
                </select>
              </div>
            </div>

            <div>
              <label class="text-sm font-medium text-gray-700">
                {{ $t('tasks.modal.fields.tags') }}
              </label>

              <div class="mt-3 flex max-h-28 flex-wrap gap-2 overflow-y-auto pr-1 sm:max-h-none">
                <label
                  v-for="tag in tags"
                  :key="tag.id"
                  class="cursor-pointer rounded-full border px-3 py-1 text-sm transition"
                  :class="form.tag_ids.includes(tag.id)
                    ? 'border-indigo-500 bg-indigo-50 text-indigo-600'
                    : 'border-gray-200 text-gray-600 hover:border-gray-300'"
                >
                  <input
                    v-model="form.tag_ids"
                    type="checkbox"
                    class="hidden"
                    :value="tag.id"
                  >

                  #{{ tag.name }}
                </label>
              </div>
            </div>
          </div>

          <div class="flex shrink-0 flex-col-reverse gap-3 border-t bg-white px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
            <button
              type="button"
              class="rounded-xl px-4 py-3 text-gray-600 transition hover:bg-gray-100 sm:py-2"
              @click="$emit('close')"
            >
              {{ $t('tasks.modal.cancel') }}
            </button>

            <AppButton type="submit">
              {{ task ? $t('tasks.modal.update') : $t('tasks.modal.create') }}
            </AppButton>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {
  onMounted,
  onUnmounted,
  reactive,
  ref,
} from 'vue'
import { useI18n } from 'vue-i18n'

import { CategoryApi } from '@/data/categories/CategoryApi'
import { TagApi } from '@/data/tags/TagApi'

import AppButton from '@/presentation/components/ui/AppButton.vue'

import type { Category } from '@/domain/categories/models/Category'
import type { StoreTaskDto } from '@/domain/tasks/dto/StoreTaskDto'
import type { Task } from '@/domain/tasks/models/Task'
import type { Tag } from '@/domain/tags/models/Tag'

type FormErrors = Record<string, string[]>

const props = defineProps<{
  task?: Task | null
}>()

const emit = defineEmits<{
  close: []
  saved: [dto: StoreTaskDto]
}>()

const { t } = useI18n()

const categories = ref<Category[]>([])
const tags = ref<Tag[]>([])
const errors = ref<FormErrors>({})

const form = reactive<StoreTaskDto>({
  name: props.task?.name ?? '',
  description: props.task?.description ?? null,
  priority: props.task?.priority as StoreTaskDto['priority'] ?? 'medium',
  status: props.task?.status as StoreTaskDto['status'] ?? 'todo',
  due_date: props.task?.due_date?.slice(0, 10) ?? null,
  category_id: props.task?.category?.id ?? null,
  tag_ids: props.task?.tags.map(tag => tag.id) ?? [],
})

const submit = (): void => {
  errors.value = {}

  if (!form.name.trim()) {
    errors.value.name = [
      String(t('tasks.validation.name_required')),
    ]
  }

  if (form.name.length > 255) {
    errors.value.name = [
      String(t('tasks.validation.name_max')),
    ]
  }

  if (
    form.description &&
    form.description.length > 255
  ) {
    errors.value.description = [
      String(t('tasks.validation.description_max')),
    ]
  }

  if (Object.keys(errors.value).length > 0) {
    return
  }

  emit('saved', {
    ...form,
    name: form.name.trim(),
    description: form.description ?? null,
    due_date: form.due_date ?? null,
    category_id: form.category_id ?? null,
  })
}

onMounted(async () => {
  document.body.style.overflow = 'hidden'

  const [categoriesResponse, tagsResponse] = await Promise.all([
    CategoryApi.getAll(),
    TagApi.getAll(),
  ])

  categories.value = categoriesResponse.data.data
  tags.value = tagsResponse.data.data
})

onUnmounted(() => {
  document.body.style.overflow = ''
})
</script>
