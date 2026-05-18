<script setup lang="ts">
import { ref, reactive } from 'vue'
import { useI18n } from 'vue-i18n'

import { useLogin } from '@/presentation/composables/useLogin'

import AuthCard from '@/presentation/components/auth/AuthCard.vue'
import AuthHeader from '@/presentation/components/auth/AuthHeader.vue'
import AuthInput from '@/presentation/components/auth/AuthInput.vue'
import AuthSubmitButton from '@/presentation/components/auth/AuthSubmitButton.vue'
import AuthFooter from '@/presentation/components/auth/AuthFooter.vue'

const { t } = useI18n()

const { login, loading, errors } = useLogin()

const showPassword = ref(false)

const form = reactive({
  email: '',
  password: '',
})

const submit = async () => {
  await login({
    email: form.email,
    password: form.password,
  })
}
</script>

<template>
  <AuthCard>
    <AuthHeader
      :title="t('auth.login.title')"
      :subtitle="t('auth.login.subtitle')"
    />

    <form class="space-y-4" @submit.prevent="submit">
      <AuthInput
        id="login-email"
        v-model="form.email"
        type="email"
        :label="t('auth.login.email')"
        :error="errors.email"
      />

      <div class="relative">
        <AuthInput
          id="login-password"
          v-model="form.password"
          :type="showPassword ? 'text' : 'password'"
          :label="t('auth.login.password')"
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

      <p v-if="errors.general" class="text-sm text-red-500">
        {{ errors.general[0] }}
      </p>

      <AuthSubmitButton
        :loading="loading"
        :label="t('auth.login.submit')"
      />

      <div class="text-right">
        <RouterLink
          to="/forgot-password"
          class="text-sm text-violet-600 hover:underline"
        >
          {{ t('auth.login.forgotPassword') }}
        </RouterLink>
      </div>
    </form>

    <AuthFooter
      :text="t('auth.login.noAccount')"
      :link-text="t('auth.login.register')"
      link="/register"
    />
  </AuthCard>
</template>
