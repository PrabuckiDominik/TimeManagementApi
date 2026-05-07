import { reactive, ref } from "vue"
import { useRouter } from "vue-router"

import { AuthRepositoryImpl } from "@/data/auth/AuthRepositoryImpl"

const authRepository = new AuthRepositoryImpl()

export function useRegister() {
  const router = useRouter()

  const loading = ref(false)

  const errors = ref<Record<string, string[]>>({})

  const form = reactive({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  })

  const submit = async (): Promise<void> => {
    loading.value = true

    errors.value = {}

    try {
      await authRepository.register(form)

      await router.push("/login")
    } catch (error: any) {
      if (error.response?.status === 422) {
        errors.value = error.response.data.errors
      }
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
