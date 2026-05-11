import { createRouter, createWebHistory } from 'vue-router'
import LoginPage from '@/presentation/pages/auth/LoginPage.vue'
import RegisterPage from '@/presentation/pages/auth/RegisterPage.vue'
import DashboardPage from "@/presentation/pages/dashboard/DashboardPage.vue";

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      redirect: '/login',
    },
    {
      path: '/login',
      component: LoginPage,
    },
    {
      path: '/register',
      component: RegisterPage,
    },
    {
      path: '/dashboard',
      component: DashboardPage,
    },
  ],
})
