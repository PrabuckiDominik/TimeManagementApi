import {ref} from 'vue'
import {useRouter} from 'vue-router'

import {AuthRepositoryImpl} from '@/data/auth/AuthRepositoryImpl'

import {authStorage} from '@/shared/auth/authStorage'

const repository = new AuthRepositoryImpl()

export function useLogout() {
  const router = useRouter()

  const loading = ref(false)

  const logout = async (): Promise<void> => {
    loading.value = true

    try {
      await repository.logout()
    } finally {
      authStorage.clear()

      await router.push('/login')

      loading.value = false
    }
  }

  return {
    logout,
    loading,
  }
}
