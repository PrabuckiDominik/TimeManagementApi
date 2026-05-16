import { createI18n } from 'vue-i18n'

import enAuth from '@/shared/i18n/locales/en/auth'
import plAuth from '@/shared/i18n/locales/pl/auth'
import enDashboard from '@/shared/i18n/locales/en/dashboard'
import plDashboard from '@/shared/i18n/locales/pl/dashboard'
import plTasks from '@/shared/i18n/locales/pl/tasks'
import enTasks from '@/shared/i18n/locales/en/tasks'
import plSidebar from '@/shared/i18n/locales/pl/sidebar'
import enSidebar from '@/shared/i18n/locales/en/sidebar'
import plProfile from '@/shared/i18n/locales/pl/profile'
import enProfile from '@/shared/i18n/locales/en/profile'
import plCategories from '@/shared/i18n/locales/pl/categories'
import enCategories from '@/shared/i18n/locales/en/categories'

export const i18n = createI18n({
  legacy: false,
  locale: localStorage.getItem('locale') ?? 'pl',
  fallbackLocale: 'en',
  messages: {
    pl: {
      auth: plAuth,
      dashboard: plDashboard,
      tasks: plTasks,
      sidebar: plSidebar,
      profile: plProfile,
      categories: plCategories,
    },
    en: {
      auth: enAuth,
      dashboard: enDashboard,
      tasks: enTasks,
      sidebar: enSidebar,
      profile: enProfile,
      categories: enCategories,
    },
  },
})
