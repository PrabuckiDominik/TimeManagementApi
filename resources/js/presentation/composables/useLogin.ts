import {ref} from 'vue'
import {useRouter} from 'vue-router'

import {AuthRepositoryImpl} from '@/data/auth/AuthRepositoryImpl'
import {authStorage} from '@/shared/auth/authStorage'

import type {LoginDto} from '@/domain/auth/dto/LoginDto'

type FormErrors = Record<string, string[]>

export function useLogin(
  repository = new AuthRepositoryImpl(),
) {
  const router = useRouter()

  const loading = ref(false)
  const errors = ref<FormErrors>({})

  const login = async (dto: LoginDto): Promise<void> => {
    loading.value = true
    errors.value = {}

    try {
      const result = await repository.login(dto)

      authStorage.setToken(result.token)
      authStorage.setUser(result.user)

      await router.push('/dashboard')
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors
      } else if (e.response?.status === 403) {
        errors.value = {
          general: [
            e.response?.data?.message ?? 'Invalid credentials.',
          ],
        }
      } else {
        errors.value = {
          general: [
            e.response?.data?.message ?? 'Login failed.',
          ],
        }
      }
    } finally {
      loading.value = false
    }
  }

  return {
    login,
    loading,
    errors,
  }
}
