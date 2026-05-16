import axios from 'axios'

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

  config.headers['Accept-Language'] = String(i18n.global.locale.value)

  return config
})

httpClient.interceptors.response.use(
  response => response,
  async error => {
    if (error.response?.status === 401) {
      authStorage.clear()

      window.location.href = '/login'
    }

    return await Promise.reject(error)
  },
)
