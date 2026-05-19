import {onMounted, ref} from 'vue'

import {AdminUserRepositoryImpl} from '@/data/admin/AdminUserRepositoryImpl'

import type {ManagedUser} from '@/domain/admin/models/ManagedUser'
import type {UpdateManagedUserDto} from '@/domain/admin/dto/UpdateManagedUserDto'

type FormErrors = Record<string, string[]>

const repository = new AdminUserRepositoryImpl()

export function useAdminUsers() {
  const users = ref<ManagedUser[]>([])
  const loading = ref(false)
  const saving = ref(false)
  const errors = ref<FormErrors>({})

  const page = ref(1)
  const perPage = ref(15)
  const lastPage = ref(1)
  const total = ref(0)

  const fetchUsers = async (): Promise<void> => {
    loading.value = true

    try {
      const response = await repository.getAll(
        page.value,
        perPage.value,
      )

      users.value = response.data
      lastPage.value = response.meta.last_page
      total.value = response.meta.total
      perPage.value = response.meta.per_page
    } finally {
      loading.value = false
    }
  }

  const updateUser = async (
    user: ManagedUser,
    dto: UpdateManagedUserDto,
  ): Promise<void> => {
    saving.value = true
    errors.value = {}

    try {
      const updatedUser = await repository.update(
        user.id,
        dto,
      )

      users.value = users.value.map(item =>
        item.id === updatedUser.id ? updatedUser : item,
      )
    } catch (error: any) {
      if (error.response?.status === 422) {
        errors.value = error.response.data.errors
      }

      throw error
    } finally {
      saving.value = false
    }
  }

  const deleteUser = async (
    user: ManagedUser,
  ): Promise<void> => {
    saving.value = true

    try {
      await repository.delete(user.id)

      users.value = users.value.filter(item =>
        item.id !== user.id,
      )

      total.value = Math.max(total.value - 1, 0)

      if (
        users.value.length === 0
        && page.value > 1
      ) {
        page.value -= 1

        await fetchUsers()
      }
    } finally {
      saving.value = false
    }
  }

  const goToPage = async (
    targetPage: number,
  ): Promise<void> => {
    if (
      targetPage < 1
      || targetPage > lastPage.value
    ) {
      return
    }

    page.value = targetPage

    await fetchUsers()
  }

  onMounted(fetchUsers)

  return {
    users,
    loading,
    saving,
    errors,
    page,
    perPage,
    lastPage,
    total,

    fetchUsers,
    updateUser,
    deleteUser,
    goToPage,
  }
}
