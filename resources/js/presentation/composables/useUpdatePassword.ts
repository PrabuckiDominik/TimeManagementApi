import {reactive, ref} from 'vue'
import {useI18n} from 'vue-i18n'

import {AuthRepositoryImpl} from '@/data/auth/AuthRepositoryImpl'

type FormErrors = Record<string, string[]>

const repository = new AuthRepositoryImpl()

export function useUpdatePassword() {
  const {t} = useI18n()

  const loading = ref(false)
  const success = ref<string | null>(null)
  const errors = ref<FormErrors>({})

  const form = reactive({
    current_password: '',
    new_password: '',
    new_password_confirmation: '',
  })

  const reset = (): void => {
    form.current_password = ''
    form.new_password = ''
    form.new_password_confirmation = ''
  }

  const submit = async (): Promise<void> => {
    errors.value = {}
    success.value = null

    if (!form.current_password) {
      errors.value.current_password = [
        String(t('profile.password.validation.current_required')),
      ]
    }

    if (form.new_password.length < 8) {
      errors.value.new_password = [
        String(t('profile.password.validation.new_min')),
      ]
    }

    if (form.new_password !== form.new_password_confirmation) {
      errors.value.new_password_confirmation = [
        String(t('profile.password.validation.confirmed')),
      ]
    }

    if (Object.keys(errors.value).length > 0) {
      return
    }

    loading.value = true

    try {
      await repository.updatePassword({...form})

      success.value = String(t('profile.password.success'))

      reset()
    } catch (e: any) {
      if (e.response?.status === 422) {
        errors.value = e.response.data.errors ?? {
          general: [e.response.data.message],
        }

        return
      }

      if (e.response?.status === 429) {
        errors.value = {
          general: [
            e.response?.data?.message ?? String(t('profile.password.throttled')),
          ],
        }

        return
      }

      errors.value = {
        general: [
          e.response?.data?.message ?? String(t('profile.password.failed')),
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
    reset,
  }
}
