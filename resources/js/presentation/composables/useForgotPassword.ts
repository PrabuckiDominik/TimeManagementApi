import {reactive, ref} from 'vue'

import {AuthRepositoryImpl} from '@/data/auth/AuthRepositoryImpl'

type FormErrors = Record<string, string[]>

const repository = new AuthRepositoryImpl()

export function useForgotPassword() {
  const loading = ref(false)
  const success = ref<string | null>(null)
  const errors = ref<FormErrors>({})

  const form = reactive({
    email: '',
  })

  const submit = async (): Promise<void> => {
    loading.value = true
    success.value = null
    errors.value = {}

    try {
      success.value = await repository.forgotPassword({
        email: form.email,
      })
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors

        return
      }

      errors.value = {
        general: [
          e.response?.data?.message ?? 'Failed to send reset link.',
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
