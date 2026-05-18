<template>
  <div
    class="inline-flex items-center gap-2 rounded-full border border-gray-300 bg-gray-100 px-3 py-2 text-sm"
  >
    <template v-if="editing">
      <FormTextInput
        :id="`tag-name-${tag.id}`"
        v-model="name"
        :label="$t('tasks.tags.name_label')"
        :maxlength="255"
        hide-label
      />

      <button
        type="button"
        class="font-medium text-indigo-800 transition hover:text-indigo-900 disabled:text-gray-500"
        :disabled="saving"
        @click="save"
      >
        {{ $t('tasks.tags.save_short') }}
      </button>

      <button
        type="button"
        class="text-gray-700 transition hover:text-gray-900"
        @click="cancel"
      >
        {{ $t('tasks.tags.cancel_short') }}
      </button>
    </template>

    <template v-else>
      <span class="font-medium text-gray-900">
        #{{ tag.name }}
      </span>

      <button
        type="button"
        class="text-gray-700 transition hover:text-indigo-800"
        @click="editing = true"
      >
        {{ $t('tasks.tags.edit') }}
      </button>

      <button
        type="button"
        class="text-red-700 transition hover:text-red-900"
        @click="$emit('delete', tag)"
      >
        {{ $t('tasks.tags.delete') }}
      </button>
    </template>
  </div>
</template>

<script setup lang="ts">
import {ref} from 'vue'

import FormTextInput from '@/presentation/components/ui/forms/FormTextInput.vue'

import type {Tag} from '@/domain/tags/models/Tag'

const props = defineProps<{
  tag: Tag
  saving: boolean
}>()

const emit = defineEmits<{
  update: [tag: Tag, name: string]
  delete: [tag: Tag]
}>()

const editing = ref(false)
const name = ref(props.tag.name)

const cancel = (): void => {
  name.value = props.tag.name
  editing.value = false
}

const save = (): void => {
  const value = name.value.trim()

  if (!value) {
    return
  }

  emit('update', props.tag, value)

  editing.value = false
}
</script>
