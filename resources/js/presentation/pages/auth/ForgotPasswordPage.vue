<script setup lang="ts">
import AppLogo from '@/presentation/components/AppLogo.vue'
import ForgotPasswordForm from '@/presentation/components/auth/ForgotPasswordForm.vue'
import AuthLayout from '@/presentation/layouts/AuthLayout.vue'
</script>

<template>
  <AuthLayout>
    <div class="space-y-6">
      <AppLogo class="scale-90 sm:scale-100" />

      <ForgotPasswordForm />
    </div>
  </AuthLayout>
</template>
