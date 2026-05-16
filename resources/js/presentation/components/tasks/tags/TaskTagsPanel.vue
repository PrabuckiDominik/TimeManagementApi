<template>
  <AppCard>
    <div class="flex items-center justify-between gap-4">
      <div>
        <h2 class="text-lg font-semibold text-gray-900">
          {{ $t('tasks.tags.title') }}
        </h2>

        <p class="mt-1 text-sm text-gray-500">
          {{ $t('tasks.tags.subtitle') }}
        </p>
      </div>

      <button
        type="button"
        class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-700"
        @click="startCreating"
      >
        {{ $t('tasks.tags.create') }}
      </button>
    </div>

    <form
      v-if="creating"
      class="mt-5 flex flex-col gap-3 sm:flex-row"
      @submit.prevent="submitCreate"
    >
      <div class="flex-1">
        <input
          v-model="form.name"
          type="text"
          maxlength="255"
          class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
          :placeholder="$t('tasks.tags.name_placeholder')"
        >

        <p
          v-if="errors.name"
          class="mt-2 text-sm text-red-500"
        >
          {{ errors.name[0] }}
        </p>
      </div>

      <div class="flex gap-2">
        <button
          type="button"
          class="rounded-xl border border-gray-300 px-4 py-2 text-gray-700 transition hover:bg-gray-50"
          @click="cancelCreating"
        >
          {{ $t('tasks.tags.cancel') }}
        </button>

        <AppButton
          type="submit"
          :disabled="saving"
        >
          {{ $t('tasks.tags.save') }}
        </AppButton>
      </div>
    </form>

    <div
      v-if="loading"
      class="mt-5 space-y-3"
    >
      <AppSkeleton
        v-for="item in 3"
        :key="item"
        height="h-12"
      />
    </div>

    <div
      v-else-if="tags.length === 0"
      class="mt-5 rounded-xl border border-dashed border-gray-200 p-6 text-center text-sm text-gray-500"
    >
      {{ $t('tasks.tags.empty') }}
    </div>

    <div
      v-else
      class="mt-5 flex flex-wrap gap-2"
    >
      <TaskTagItem
        v-for="tag in tags"
        :key="tag.id"
        :tag="tag"
        :saving="saving"
        @update="handleUpdate"
        @delete="handleDelete"
      />
    </div>
  </AppCard>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'

import AppButton from '@/presentation/components/ui/AppButton.vue'
import AppCard from '@/presentation/components/ui/AppCard.vue'
import AppSkeleton from '@/presentation/components/ui/AppSkeleton.vue'
import TaskTagItem from '@/presentation/components/tasks/tags/TaskTagItem.vue'

import { useTags } from '@/presentation/composables/useTags'

import type { Tag } from '@/domain/tags/models/Tag'

const {
  tags,
  loading,
  saving,
  errors,
  createTag,
  updateTag,
  deleteTag,
} = useTags()

const creating = ref(false)

const form = reactive({
  name: '',
})

const startCreating = (): void => {
  creating.value = true
}

const cancelCreating = (): void => {
  creating.value = false
  form.name = ''
  errors.value = {}
}

const submitCreate = async (): Promise<void> => {
  if (!form.name.trim()) {
    errors.value = {
      name: ['Name is required.'],
    }

    return
  }

  await createTag({
    name: form.name.trim(),
  })

  form.name = ''
  creating.value = false
}

const handleUpdate = async (
  tag: Tag,
  name: string,
): Promise<void> => {
  await updateTag(tag, {
    name,
  })
  emit('changed')
}

const handleDelete = async (tag: Tag): Promise<void> => {
  if (!confirm(String('Delete this tag?'))) {
    return
  }

  await deleteTag(tag)
  emit('changed')
}

const emit = defineEmits<{
  changed: []
}>()
</script>
