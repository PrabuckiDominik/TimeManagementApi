<script setup lang="ts">
import {ref} from 'vue'
import {useI18n} from 'vue-i18n'

import AuthCard from '@/presentation/components/auth/AuthCard.vue'
import AuthHeader from '@/presentation/components/auth/AuthHeader.vue'
import AuthInput from '@/presentation/components/auth/AuthInput.vue'
import AuthSubmitButton from '@/presentation/components/auth/AuthSubmitButton.vue'

import {useResetPassword} from '@/presentation/composables/useResetPassword'

const {t} = useI18n()

const {
  form,
  loading,
  errors,
  submit,
} = useResetPassword()

const showPassword = ref(false)
const showPasswordConfirmation = ref(false)
</script>

<template>
  <AuthCard>
    <AuthHeader
      :title="t('auth.reset_password.title')"
      :subtitle="t('auth.reset_password.subtitle')"
    />

    <form
      class="space-y-4"
      @submit.prevent="submit"
    >
      <AuthInput
        id="reset-password-email"
        v-model="form.email"
        type="email"
        :label="t('auth.reset_password.email')"
        :error="errors.email"
      />

      <div class="relative">
        <AuthInput
          id="reset-password-password"
          v-model="form.password"
          :type="showPassword ? 'text' : 'password'"
          :label="t('auth.reset_password.password')"
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
          id="reset-password-password_confirmation"
          v-model="form.password_confirmation"
          :type="showPasswordConfirmation ? 'text' : 'password'"
          :label="t('auth.reset_password.password_confirmation')"
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

      <p
        v-if="errors.general"
        class="text-sm text-red-500"
      >
        {{ errors.general[0] }}
      </p>

      <AuthSubmitButton
        :loading="loading"
        :label="t('auth.reset_password.submit')"
      />
    </form>
  </AuthCard>
</template>
