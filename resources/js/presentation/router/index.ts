import { createRouter, createWebHistory } from 'vue-router'

import { authStorage } from '@/shared/auth/authStorage'

import DashboardPage from '@/presentation/pages/dashboard/DashboardPage.vue'
import LoginPage from '@/presentation/pages/auth/LoginPage.vue'
import ProfilePage from '@/presentation/pages/profile/ProfilePage.vue'
import RegisterPage from '@/presentation/pages/auth/RegisterPage.vue'
import TasksPage from '@/presentation/pages/task/TasksPage.vue'
import ResetPasswordPage from '@/presentation/pages/auth/ResetPasswordPage.vue'
import ForgotPasswordPage from '@/presentation/pages/auth/ForgotPasswordPage.vue'
import CategoriesPage from '@/presentation/pages/category/CategoriesPage.vue'

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
      },
    },

    {
      path: '/register',
      component: RegisterPage,
      meta: {
        guestOnly: true,
      },
    },

    {
      path: '/dashboard',
      component: DashboardPage,
      meta: {
        requiresAuth: true,
      },
    },

    {
      path: '/tasks',
      component: TasksPage,
      meta: {
        requiresAuth: true,
      },
    },

    {
      path: '/profile',
      component: ProfilePage,
      meta: {
        requiresAuth: true,
      },
    },

    {
      path: '/forgot-password',
      component: ForgotPasswordPage,
      meta: {
        guestOnly: true,
      },
    },

    {
      path: '/reset-password/:token',
      component: ResetPasswordPage,
      meta: {
        guestOnly: true,
      },
    },

    {
      path: '/categories',
      component: CategoriesPage,
      meta: {
        requiresAuth: true,
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
