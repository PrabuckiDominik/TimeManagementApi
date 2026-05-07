<script setup lang="ts">
import { useRegister } from "@/presentation/composables/useRegister"
import { useI18n } from "vue-i18n"

import AuthCard from "@/presentation/components/auth/AuthCard.vue"
import AuthHeader from "@/presentation/components/auth/AuthHeader.vue"
import AuthInput from "@/presentation/components/auth/AuthInput.vue"
import AuthSubmitButton from "@/presentation/components/auth/AuthSubmitButton.vue"
import AuthFooter from "@/presentation/components/auth/AuthFooter.vue"

const { t } = useI18n()

const {
  form,
  submit,
  loading,
  errors,
} = useRegister()
</script>

<template>
  <AuthCard>
    <AuthHeader
      :title="t('auth.register.title')"
      :subtitle="t('auth.register.subtitle')"
    />

    <form @submit.prevent="submit" class="space-y-4">
      <AuthInput
        v-model="form.name"
        :label="t('auth.register.name')"
        placeholder="Jan Kowalski"
        :error="errors.name"
      />

      <AuthInput
        v-model="form.email"
        type="email"
        :label="t('auth.register.email')"
        placeholder="kowalski@example.com"
        :error="errors.email"
      />

      <AuthInput
        v-model="form.password"
        type="password"
        :label="t('auth.register.password')"
        placeholder="********"
        :error="errors.password"
      />

      <AuthInput
        v-model="form.password_confirmation"
        type="password"
        :label="t('auth.register.passwordConfirmation')"
        placeholder="********"
      />

      <AuthSubmitButton
        :loading="loading"
        :label="t('auth.register.submit')"
      />
    </form>

    <AuthFooter
      :text="t('auth.register.alreadyHaveAccount')"
      :link-text="t('auth.register.login')"
      link="/login"
    />
  </AuthCard>
</template>
