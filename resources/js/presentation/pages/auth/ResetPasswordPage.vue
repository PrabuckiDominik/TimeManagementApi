<script setup lang="ts">
import AppLogo from '@/presentation/components/AppLogo.vue'
import ResetPasswordForm from '@/presentation/components/auth/ResetPasswordForm.vue'
import AuthLayout from '@/presentation/layouts/AuthLayout.vue'
</script>

<template>
  <AuthLayout>
    <div class="space-y-6">
      <AppLogo class="scale-90 sm:scale-100" />

      <ResetPasswordForm />
    </div>
  </AuthLayout>
</template>
