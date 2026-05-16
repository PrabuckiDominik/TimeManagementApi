import { reactive, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

import { AuthRepositoryImpl } from '@/data/auth/AuthRepositoryImpl'

type FormErrors = Record<string, string[]>

const repository = new AuthRepositoryImpl()

export function useResetPassword() {
  const route = useRoute()
  const router = useRouter()

  const loading = ref(false)
  const success = ref<string | null>(null)
  const errors = ref<FormErrors>({})

  const form = reactive({
    email: String(route.query.email ?? ''),
    password: '',
    password_confirmation: '',
  })

  const submit = async (): Promise<void> => {
    loading.value = true
    success.value = null
    errors.value = {}

    try {
      success.value = await repository.resetPassword({
        email: form.email,
        password: form.password,
        password_confirmation: form.password_confirmation,
        token: String(route.params.token),
      })

      await router.push('/login')
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors

        return
      }

      errors.value = {
        general: [
          e.response?.data?.message ?? 'Failed to reset password.',
        ],
      }
    } finally {
      loading.value = false
    }
  }

  return {
    form,
    loading,
    success,
    errors,
    submit,
  }
}
