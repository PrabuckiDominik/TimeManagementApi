<script setup lang="ts">
import AuthLayout from "@/presentation/layouts/AuthLayout.vue"
import AppLogo from "@/presentation/components/AppLogo.vue"
import LoginForm from "@/presentation/components/auth/LoginForm.vue"
</script>

<template>
  <AuthLayout>
    <div class="space-y-6">
      <AppLogo class="scale-90 sm:scale-100" />
      <LoginForm />
    </div>
  </AuthLayout>
</template>
