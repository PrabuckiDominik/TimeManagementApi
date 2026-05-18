import {onMounted, ref} from 'vue'

import {TagRepositoryImpl} from '@/data/tags/TagRepositoryImpl'

import type {StoreTagDto} from '@/domain/tags/dto/StoreTagDto'
import type {UpdateTagDto} from '@/domain/tags/dto/UpdateTagDto'
import type {Tag} from '@/domain/tags/models/Tag'

type FormErrors = Record<string, string[]>

const repository = new TagRepositoryImpl()

export function useTags() {
  const tags = ref<Tag[]>([])
  const loading = ref(false)
  const saving = ref(false)
  const errors = ref<FormErrors>({})

  const fetchTags = async (): Promise<void> => {
    loading.value = true

    try {
      tags.value = await repository.getAll()
    } finally {
      loading.value = false
    }
  }

  const createTag = async (dto: StoreTagDto): Promise<void> => {
    saving.value = true
    errors.value = {}

    try {
      const tag = await repository.create(dto)

      tags.value.push(tag)
      tags.value.sort((a, b) => a.name.localeCompare(b.name))
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors
      }

      throw e
    } finally {
      saving.value = false
    }
  }

  const updateTag = async (
    tag: Tag,
    dto: UpdateTagDto,
  ): Promise<void> => {
    saving.value = true
    errors.value = {}

    try {
      const updatedTag = await repository.update(tag.id, dto)

      tags.value = tags.value
        .map(item => item.id === updatedTag.id ? updatedTag : item)
        .sort((a, b) => a.name.localeCompare(b.name))
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors
      }

      throw e
    } finally {
      saving.value = false
    }
  }

  const deleteTag = async (tag: Tag): Promise<void> => {
    saving.value = true

    try {
      await repository.delete(tag.id)

      tags.value = tags.value.filter(item => item.id !== tag.id)
    } finally {
      saving.value = false
    }
  }

  onMounted(fetchTags)

  return {
    tags,
    loading,
    saving,
    errors,

    fetchTags,
    createTag,
    updateTag,
    deleteTag,
  }
}
