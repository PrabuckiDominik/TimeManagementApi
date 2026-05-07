<template>
  <AuthLayout>
    <div class="space-y-6">
      <AppLogo class="scale-90 sm:scale-100" />
      <RegisterForm />
    </div>
  </AuthLayout>
</template>

<script setup lang="ts">
import AuthLayout from "@/presentation/layouts/AuthLayout.vue"
import AppLogo from "@/presentation/components/AppLogo.vue"
import RegisterForm from "@/presentation/components/auth/RegisterForm.vue"
</script>
