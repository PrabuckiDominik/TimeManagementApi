import { createI18n } from 'vue-i18n'

import enAuth from '@/shared/i18n/locales/en/auth'
import plAuth from '@/shared/i18n/locales/pl/auth'
import enDashboard from '@/shared/i18n/locales/en/dashboard'
import plDashboard from '@/shared/i18n/locales/pl/dashboard'

export const i18n = createI18n({
  legacy: false,
  locale: 'pl',
  fallbackLocale: 'en',
  messages: {
    pl: {
      auth: plAuth,
      dashboard: plDashboard,
    },
    en: {
      auth: enAuth,
      dashboard: enDashboard,
    },
  },
})
