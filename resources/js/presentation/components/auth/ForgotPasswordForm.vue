<script setup lang="ts">
import { useI18n } from 'vue-i18n'

import AuthCard from '@/presentation/components/auth/AuthCard.vue'
import AuthFooter from '@/presentation/components/auth/AuthFooter.vue'
import AuthHeader from '@/presentation/components/auth/AuthHeader.vue'
import AuthInput from '@/presentation/components/auth/AuthInput.vue'
import AuthSubmitButton from '@/presentation/components/auth/AuthSubmitButton.vue'

import { useForgotPassword } from '@/presentation/composables/useForgotPassword'

const { t } = useI18n()

const {
  form,
  loading,
  success,
  errors,
  submit,
} = useForgotPassword()
</script>

<template>
  <AuthCard>
    <AuthHeader
      :title="t('auth.forgot_password.title')"
      :subtitle="t('auth.forgot_password.subtitle')"
    />

    <form
      class="space-y-4"
      @submit.prevent="submit"
    >
      <AuthInput
        id="forgot-password-email"
        v-model="form.email"
        type="email"
        :label="t('auth.forgot_password.email')"
        :error="errors.email"
      />

      <p
        v-if="errors.general"
        class="text-sm text-red-500"
      >
        {{ errors.general[0] }}
      </p>

      <p
        v-if="success"
        class="rounded-xl bg-green-50 px-4 py-3 text-sm text-green-600"
      >
        {{ success }}
      </p>

      <AuthSubmitButton
        :loading="loading"
        :label="t('auth.forgot_password.submit')"
      />
    </form>

    <AuthFooter
      :text="t('auth.forgot_password.remember_password')"
      :link-text="t('auth.forgot_password.login')"
      link="/login"
    />
  </AuthCard>
</template>
