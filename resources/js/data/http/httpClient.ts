import axios from 'axios'

import { router } from '@/presentation/router'

import { authStorage } from '@/shared/auth/authStorage'
import { i18n } from '@/shared/i18n'

export const httpClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  withCredentials: true,
})

httpClient.interceptors.request.use(config => {
  const token = authStorage.getToken()

  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  config.headers['Accept-Language'] = String(
    i18n.global.locale.value,
  )

  return config
})

httpClient.interceptors.response.use(
  response => response,

  error => {
    if (!error.response) {
      void router.push('/offline')

      throw error
    }

    const status = error.response.status

    if (status === 401) {
      authStorage.clear()

      void router.push('/login?session=expired')

      throw error
    }

    if (
      status === 403
      && !router.currentRoute.value.meta.guestOnly
    ) {
      void router.push('/403')

      throw error
    }

    if (status >= 500) {
      void router.push('/500')

      throw error
    }

    throw error
  },
)
