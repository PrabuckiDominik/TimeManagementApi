<template>
  <AppCard>
    <form
      class="flex flex-col gap-3 sm:flex-row"
      @submit.prevent="submitCreate"
    >
      <div class="flex-1">
        <input
          v-model="form.title"
          type="text"
          maxlength="255"
          class="w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
          :placeholder="$t('categories.form.title_placeholder')"
        >

        <p
          v-if="errors.title"
          class="mt-2 text-sm text-red-500"
        >
          {{ errors.title[0] }}
        </p>
      </div>

      <input
        v-model="form.color"
        type="color"
        class="h-12 w-16 rounded-xl border border-gray-300 bg-white p-1"
      >

      <AppButton
        type="submit"
        :disabled="saving"
      >
        {{ $t('categories.actions.create') }}
      </AppButton>
    </form>

    <div
      v-if="loading"
      class="mt-6 space-y-3"
    >
      <AppSkeleton
        v-for="item in 4"
        :key="item"
        height="h-16"
      />
    </div>

    <div
      v-else-if="categories.length === 0"
      class="mt-6 rounded-xl border border-dashed border-gray-200 p-8 text-center text-sm text-gray-500"
    >
      {{ $t('categories.empty') }}
    </div>

    <div
      v-else
      class="mt-6 space-y-3"
    >
      <CategoryListItem
        v-for="category in categories"
        :key="category.id"
        :category="category"
        :saving="saving"
        @update="handleUpdate"
        @delete="handleDelete"
      />
    </div>
  </AppCard>
</template>

<script setup lang="ts">
import { reactive } from 'vue'

import AppButton from '@/presentation/components/ui/AppButton.vue'
import AppCard from '@/presentation/components/ui/AppCard.vue'
import AppSkeleton from '@/presentation/components/ui/AppSkeleton.vue'
import CategoryListItem from '@/presentation/components/categories/CategoryListItem.vue'

import { useCategories } from '@/presentation/composables/useCategories'

import type { Category } from '@/domain/categories/models/Category'
import { useI18n } from 'vue-i18n'

const { t } = useI18n()

const {
  categories,
  loading,
  saving,
  errors,
  createCategory,
  updateCategory,
  deleteCategory,
} = useCategories()

const form = reactive({
  title: '',
  color: '#6366f1',
})

const submitCreate = async (): Promise<void> => {
  if (!form.title.trim()) {
    errors.value = {
      title: ['Category title is required.'],
    }

    return
  }

  await createCategory({
    title: form.title.trim(),
    color: form.color,
  })

  form.title = ''
  form.color = '#6366f1'
}

const handleUpdate = async (
  category: Category,
  payload: {
    title: string
    color: string | null
  },
): Promise<void> => {
  await updateCategory(category, payload)
}

const handleDelete = async (category: Category): Promise<void> => {
  if (!confirm(String(t('categories.confirm_delete')))) {
    return
  }

  await deleteCategory(category)
}
</script>
