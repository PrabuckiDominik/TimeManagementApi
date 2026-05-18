<template>
  <AppCard>
    <div class="flex items-center justify-between gap-4">
      <div>
        <h2 class="text-lg font-semibold text-gray-900">
          {{ $t('tasks.tags.title') }}
        </h2>

        <p class="mt-1 text-sm text-gray-700">
          {{ $t('tasks.tags.subtitle') }}
        </p>
      </div>

      <button
        type="button"
        class="rounded-xl bg-indigo-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-indigo-800"
        :aria-label="$t('tasks.tags.create')"
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
        <FormTextInput
          id="new-tag-name"
          v-model="form.name"
          :label="$t('tasks.tags.name_label')"
          :placeholder="$t('tasks.tags.name_placeholder')"
          :error="errors.name"
          :maxlength="255"
          hide-label
        />
      </div>

      <div class="flex gap-2">
        <button
          type="button"
          class="rounded-xl border border-gray-400 px-4 py-2 text-gray-800 transition hover:bg-gray-100"
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
      class="mt-5 rounded-xl border border-dashed border-gray-300 p-6 text-center text-sm text-gray-700"
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
import {reactive, ref} from 'vue'

import AppButton from '@/presentation/components/ui/AppButton.vue'
import AppCard from '@/presentation/components/ui/AppCard.vue'
import AppSkeleton from '@/presentation/components/ui/AppSkeleton.vue'
import FormTextInput from '@/presentation/components/ui/forms/FormTextInput.vue'
import TaskTagItem from '@/presentation/components/tasks/tags/TaskTagItem.vue'

import {useTags} from '@/presentation/composables/useTags'

import type {Tag} from '@/domain/tags/models/Tag'
import {useI18n} from 'vue-i18n'

const emit = defineEmits<{
  changed: []
}>()

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
      name: [
        String(t('tasks.tags.validation.name_required')),
      ],
    }

    return
  }

  await createTag({
    name: form.name.trim(),
  })

  emit('changed')

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

const {t} = useI18n()
const handleDelete = async (tag: Tag): Promise<void> => {
  if (!confirm(String(t('tasks.tags.confirm_delete')))) {
    return
  }

  await deleteTag(tag)

  emit('changed')
}
</script>
