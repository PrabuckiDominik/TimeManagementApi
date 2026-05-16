<script setup lang="ts">
import { useRegister } from '@/presentation/composables/useRegister'
import { useI18n } from 'vue-i18n'
import { ref } from 'vue'

import AuthCard from '@/presentation/components/auth/AuthCard.vue'
import AuthHeader from '@/presentation/components/auth/AuthHeader.vue'
import AuthInput from '@/presentation/components/auth/AuthInput.vue'
import AuthSubmitButton from '@/presentation/components/auth/AuthSubmitButton.vue'
import AuthFooter from '@/presentation/components/auth/AuthFooter.vue'

const { t } = useI18n()

const {
  form,
  submit,
  loading,
  errors,
} = useRegister()

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)
</script>

<template>
  <AuthCard>
    <AuthHeader
      :title="t('auth.register.title')"
      :subtitle="t('auth.register.subtitle')"
    />

    <form class="space-y-4" @submit.prevent="submit">
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

      <div class="relative">
        <AuthInput
          v-model="form.password"
          :type="showPassword ? 'text' : 'password'"
          :label="t('auth.register.password')"
          placeholder="********"
          :error="errors.password"
        />

        <button
          type="button"
          class="absolute right-3 top-9 text-sm text-slate-500 hover:text-slate-700"
          @click="showPassword = !showPassword"
        >
          {{ showPassword ? $t('auth.hide') : $t('auth.show') }}
        </button>
      </div>

      <div class="relative">
        <AuthInput
          v-model="form.password_confirmation"
          :type="showPasswordConfirmation ? 'text' : 'password'"
          :label="t('auth.register.passwordConfirmation')"
          placeholder="********"
          :error="errors.password_confirmation"
        />

        <button
          type="button"
          class="absolute right-3 top-9 text-sm text-slate-500 hover:text-slate-700"
          @click="showPasswordConfirmation = !showPasswordConfirmation"
        >
          {{ showPasswordConfirmation ? $t('auth.hide') : $t('auth.show') }}
        </button>
      </div>

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
