import {onMounted, reactive, ref} from 'vue'

import {authStorage} from '@/shared/auth/authStorage'
import {ProfileRepositoryImpl} from '@/data/profile/ProfileRepositoryImpl'

import type {User} from '@/domain/auth/models/User'
import type {UpdateProfileDto} from '@/domain/profile/dto/UpdateProfileDto'

type FormErrors = Record<string, string[]>

const repository = new ProfileRepositoryImpl()

export function useProfile() {
  const user = ref<User | null>(authStorage.getUser())
  const loading = ref(false)
  const saving = ref(false)
  const editing = ref(false)
  const errors = ref<FormErrors>({})

  const form = reactive<UpdateProfileDto>({
    name: user.value?.name ?? '',
  })

  const fetchProfile = async (): Promise<void> => {
    loading.value = true

    try {
      user.value = await repository.get()

      authStorage.setUser(user.value)

      form.name = user.value.name
    } finally {
      loading.value = false
    }
  }

  const updateProfile = async (): Promise<void> => {
    errors.value = {}

    if (!form.name.trim()) {
      errors.value.name = ['Name is required.']

      return
    }

    saving.value = true

    try {
      const updatedUser = await repository.update({
        name: form.name.trim(),
      })

      user.value = updatedUser

      authStorage.setUser(updatedUser)

      editing.value = false
    } finally {
      saving.value = false
    }
  }

  const cancelEdit = (): void => {
    form.name = user.value?.name ?? ''

    editing.value = false
  }

  onMounted(fetchProfile)

  return {
    user,
    form,
    loading,
    saving,
    editing,
    errors,

    updateProfile,
    cancelEdit,
  }
}
