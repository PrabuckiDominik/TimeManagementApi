import { createRouter, createWebHistory } from 'vue-router'

import { authStorage } from '@/shared/auth/authStorage'
import { i18n } from '@/shared/i18n'

import DashboardPage from '@/presentation/pages/dashboard/DashboardPage.vue'
import LoginPage from '@/presentation/pages/auth/LoginPage.vue'
import ProfilePage from '@/presentation/pages/profile/ProfilePage.vue'
import RegisterPage from '@/presentation/pages/auth/RegisterPage.vue'
import TasksPage from '@/presentation/pages/task/TasksPage.vue'
import ResetPasswordPage from '@/presentation/pages/auth/ResetPasswordPage.vue'
import ForgotPasswordPage from '@/presentation/pages/auth/ForgotPasswordPage.vue'
import CategoriesPage from '@/presentation/pages/category/CategoriesPage.vue'

import ForbiddenPage from '@/presentation/pages/errors/ForbiddenPage.vue'
import OfflinePage from '@/presentation/pages/errors/OfflinePage.vue'
import ServerErrorPage from '@/presentation/pages/errors/ServerErrorPage.vue'

export const router = createRouter({
  history: createWebHistory(),

  routes: [
    {
      path: '/',
      redirect: '/dashboard',
    },

    {
      path: '/login',
      component: LoginPage,
      meta: {
        guestOnly: true,
        title: 'auth.login.title',
      },
    },

    {
      path: '/register',
      component: RegisterPage,
      meta: {
        guestOnly: true,
        title: 'auth.register.title',
      },
    },

    {
      path: '/forgot-password',
      component: ForgotPasswordPage,
      meta: {
        guestOnly: true,
        title: 'auth.forgot_password.title',
      },
    },

    {
      path: '/reset-password/:token',
      component: ResetPasswordPage,
      meta: {
        guestOnly: true,
        title: 'auth.reset_password.title',
      },
    },

    {
      path: '/dashboard',
      component: DashboardPage,
      meta: {
        requiresAuth: true,
        title: 'dashboard.title',
      },
    },

    {
      path: '/tasks',
      component: TasksPage,
      meta: {
        requiresAuth: true,
        title: 'tasks.title',
      },
    },

    {
      path: '/categories',
      component: CategoriesPage,
      meta: {
        requiresAuth: true,
        title: 'categories.title',
      },
    },

    {
      path: '/profile',
      component: ProfilePage,
      meta: {
        requiresAuth: true,
        title: 'profile.title',
      },
    },

    {
      path: '/403',
      component: ForbiddenPage,
      meta: {
        title: 'errors.forbidden.title',
      },
    },

    {
      path: '/offline',
      component: OfflinePage,
      meta: {
        title: 'errors.offline.title',
      },
    },

    {
      path: '/500',
      component: ServerErrorPage,
      meta: {
        title: 'errors.server.title',
      },
    },

    {
      path: '/:pathMatch(.*)*',
      redirect: () => {
        return authStorage.getToken()
          ? '/dashboard'
          : '/login'
      },
    },
  ],
})

router.beforeEach(to => {
  const token = authStorage.getToken()

  if (to.meta.requiresAuth && !token) {
    return '/login'
  }

  if (to.meta.guestOnly && token) {
    return '/dashboard'
  }
})

router.afterEach(to => {
  const appName =
    import.meta.env.VITE_APP_NAME ?? 'Time Management'

  const titleKey =
    typeof to.meta.title === 'string'
      ? to.meta.title
      : null

  document.title = titleKey
    ? `${i18n.global.t(titleKey)} | ${appName}`
    : appName
})

export default router
