import { ref } from 'vue'
import { useRouter } from 'vue-router'

import type { LoginDto } from '@/domain/auth/dto/LoginDto'

import { AuthRepositoryImpl } from '@/data/auth/AuthRepositoryImpl'

type FormErrors = Record<string, string[]>

export function useLogin(
  repository = new AuthRepositoryImpl(),
) {
  const router = useRouter()

  const loading = ref(false)

  const errors = ref<FormErrors>({})

  const login = async (dto: LoginDto) => {
    loading.value = true

    errors.value = {}

    try {
      const result = await repository.login(dto)

      localStorage.setItem('token', result.token)

      localStorage.setItem(
        'user',
        JSON.stringify(result.user),
      )

      await router.push('/dashboard')

      return result
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors
      } else {
        errors.value = {
          general: [
            e.response?.data?.message ?? 'Login failed',
          ],
        }
      }

      throw e
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
