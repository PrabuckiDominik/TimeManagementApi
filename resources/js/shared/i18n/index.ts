import { createI18n } from 'vue-i18n'

import enAuth from '@/shared/i18n/locales/en/auth'
import plAuth from '@/shared/i18n/locales/pl/auth'
import enDashboard from '@/shared/i18n/locales/en/dashboard'
import plDashboard from '@/shared/i18n/locales/pl/dashboard'
import plTasks from '@/shared/i18n/locales/pl/tasks'
import enTasks from '@/shared/i18n/locales/en/tasks'
import plSidebar from '@/shared/i18n/locales/pl/sidebar'
import enSidebar from '@/shared/i18n/locales/en/sidebar'

export const i18n = createI18n({
  legacy: false,
  locale: 'pl',
  fallbackLocale: 'en',
  messages: {
    pl: {
      auth: plAuth,
      dashboard: plDashboard,
      tasks: plTasks,
      sidebar: plSidebar,
    },
    en: {
      auth: enAuth,
      dashboard: enDashboard,
      tasks: enTasks,
      sidebar: enSidebar,
    },
  },
})
