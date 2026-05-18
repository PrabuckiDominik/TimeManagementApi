<template>
  <AppCard>
    <form
      class="flex flex-col gap-3 sm:flex-row sm:items-start"
      @submit.prevent="submitCreate"
    >
      <div class="flex-1">
        <FormTextInput
          id="category-title"
          v-model="form.title"
          :label="$t('categories.form.title_label')"
          :placeholder="$t('categories.form.title_placeholder')"
          :error="errors.title"
          :maxlength="255"
          hide-label
        />
      </div>

      <div>
        <label
          for="category-color"
          class="sr-only"
        >
          {{ $t('categories.form.color_label') }}
        </label>

        <input
          id="category-color"
          v-model="form.color"
          type="color"
          class="h-12 w-16 rounded-xl border border-gray-300 bg-white p-1"
        >
      </div>

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
import { useI18n } from 'vue-i18n'

import AppButton from '@/presentation/components/ui/AppButton.vue'
import AppCard from '@/presentation/components/ui/AppCard.vue'
import AppSkeleton from '@/presentation/components/ui/AppSkeleton.vue'
import FormTextInput from '@/presentation/components/ui/forms/FormTextInput.vue'
import CategoryListItem from '@/presentation/components/categories/CategoryListItem.vue'

import { useCategories } from '@/presentation/composables/useCategories'

import type { Category } from '@/domain/categories/models/Category'

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
      title: [
        String(t('categories.validation.title_required')),
      ],
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
