import {onMounted, ref} from 'vue'

import {CategoryRepositoryImpl} from '@/data/categories/CategoryRepositoryImpl'

import type {Category} from '@/domain/categories/models/Category'
import type {StoreCategoryDto} from '@/domain/categories/dto/StoreCategoryDto'
import type {UpdateCategoryDto} from '@/domain/categories/dto/UpdateCategoryDto'

type FormErrors = Record<string, string[]>

const repository = new CategoryRepositoryImpl()

export function useCategories() {
  const categories = ref<Category[]>([])
  const loading = ref(false)
  const saving = ref(false)
  const errors = ref<FormErrors>({})

  const fetchCategories = async (): Promise<void> => {
    loading.value = true

    try {
      categories.value = await repository.getAll()
    } finally {
      loading.value = false
    }
  }

  const createCategory = async (dto: StoreCategoryDto): Promise<void> => {
    saving.value = true
    errors.value = {}

    try {
      const category = await repository.create(dto)

      categories.value.push(category)
      categories.value.sort((a, b) => a.title.localeCompare(b.title))
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors
      }
    } finally {
      saving.value = false
    }
  }

  const updateCategory = async (
    category: Category,
    dto: UpdateCategoryDto,
  ): Promise<void> => {
    saving.value = true
    errors.value = {}

    try {
      const updatedCategory = await repository.update(category.id, dto)

      categories.value = categories.value
        .map(item => item.id === updatedCategory.id ? updatedCategory : item)
        .sort((a, b) => a.title.localeCompare(b.title))
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors
      }
    } finally {
      saving.value = false
    }
  }

  const deleteCategory = async (category: Category): Promise<void> => {
    saving.value = true

    try {
      await repository.delete(category.id)

      categories.value = categories.value.filter(item => item.id !== category.id)
    } finally {
      saving.value = false
    }
  }

  onMounted(fetchCategories)

  return {
    categories,
    loading,
    saving,
    errors,

    fetchCategories,
    createCategory,
    updateCategory,
    deleteCategory,
  }
}
