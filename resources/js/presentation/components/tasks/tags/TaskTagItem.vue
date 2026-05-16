<template>
  <div
    class="inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-3 py-2 text-sm"
  >
    <template v-if="editing">
      <input
        v-model="name"
        type="text"
        maxlength="255"
        class="w-32 bg-transparent outline-none"
        @keydown.enter.prevent="save"
        @keydown.esc.prevent="cancel"
      >

      <button
        type="button"
        class="font-medium text-indigo-600"
        :disabled="saving"
        @click="save"
      >
        {{ $t('tasks.tags.save_short') }}
      </button>

      <button
        type="button"
        class="text-gray-500"
        @click="cancel"
      >
        {{ $t('tasks.tags.cancel_short') }}
      </button>
    </template>

    <template v-else>
      <span class="font-medium text-gray-700">
        #{{ tag.name }}
      </span>

      <button
        type="button"
        class="text-gray-400 transition hover:text-indigo-600"
        @click="editing = true"
      >
        {{ $t('tasks.tags.edit') }}
      </button>

      <button
        type="button"
        class="text-gray-400 transition hover:text-red-600"
        @click="$emit('delete', tag)"
      >
        {{ $t('tasks.tags.delete') }}
      </button>
    </template>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

import type { Tag } from '@/domain/tags/models/Tag'

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
