import { createI18n } from 'vue-i18n'

import enAuth from './locales/en/auth'
import plAuth from './locales/pl/auth'

export const i18n = createI18n({
  legacy: false,
  locale: 'pl',
  fallbackLocale: 'en',
  messages: {
    pl: {
      auth: plAuth,
    },
    en: {
      auth: enAuth,
    },
  },
})
