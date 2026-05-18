import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'

import { AuthRepositoryImpl } from '@/data/auth/AuthRepositoryImpl'

const authRepository = new AuthRepositoryImpl()

type FormErrors = Record<string, string[]>

export function useRegister() {
  const router = useRouter()

  const loading = ref(false)
  const errors = ref<FormErrors>({})

  const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  })

  const submit = async (): Promise<void> => {
    loading.value = true
    errors.value = {}

    try {
      await authRepository.register(form)

      await router.push('/login?registered=success')
    } catch (error: any) {
      if (error.response?.status === 422) {
        errors.value = error.response.data.errors
      } else {
        errors.value = {
          general: [
            error.response?.data?.message ?? 'Registration failed.',
          ],
        }
      }

      throw error
    } finally {
      loading.value = false
    }
  }

  return {
    form,
    submit,
    loading,
    errors,
  }
}
