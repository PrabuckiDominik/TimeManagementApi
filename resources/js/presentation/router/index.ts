import { createRouter, createWebHistory } from "vue-router"
import LoginPage from "@/presentation/pages/auth/LoginPage.vue"
import RegisterPage from "@/presentation/pages/auth/RegisterPage.vue"

export const router = createRouter({
  history: createWebHistory(),
  routes: [
    {
      path: "/",
      redirect: "/register",
    },
    {
      path: "/login",
      component: LoginPage,
    },
    {
      path: "/register",
      component: RegisterPage,
    },
  ],
})
