import { ref } from 'vue'
import type { LoginDto } from '@/domain/auth/dto/LoginDto'
import { AuthRepositoryImpl } from '@/data/auth/AuthRepositoryImpl'

type FormErrors = Record<string, string[]>

export function useLogin(repository = new AuthRepositoryImpl()){

  const loading = ref(false)
  const errors = ref<FormErrors>({})

  const login = async (dto: LoginDto) => {
    loading.value = true
    errors.value = {}

    try {
      const result = await repository.login(dto)

      localStorage.setItem('token', result.token)

      return result
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors
      } else {
        errors.value = {
          general: [e.response?.data?.message ?? 'Login failed'],
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
