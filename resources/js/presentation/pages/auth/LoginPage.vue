<script setup lang="ts">
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { useI18n } from 'vue-i18n'

import AuthLayout from '@/presentation/layouts/AuthLayout.vue'
import AppLogo from '@/presentation/components/AppLogo.vue'
import LoginForm from '@/presentation/components/auth/LoginForm.vue'

const route = useRoute()

const { t } = useI18n()

const successMessage = computed(() => {
  if (route.query.registered === 'success') {
    return t('auth.messages.verification_email_sent')
  }

  if (route.query.verified === 'success') {
    return t('auth.messages.email_verified')
  }

  if (route.query.verified === 'already') {
    return t('auth.messages.email_already_verified')
  }

  if (route.query.verified === 'invalid') {
    return t('auth.messages.invalid_verification_link')
  }

  if (route.query.session === 'expired') {
    return t('auth.messages.session_expired')
  }

  return null
})
</script>

<template>
  <AuthLayout>
    <div class="space-y-6">
      <AppLogo class="scale-90 sm:scale-100" />

      <div
        v-if="successMessage"
        class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700"
      >
        {{ successMessage }}
      </div>

      <LoginForm />
    </div>
  </AuthLayout>
</template>
