<template>
  <AppCard>
    <h2 class="text-xl font-semibold text-gray-900">
      {{ $t('profile.security.title') }}
    </h2>

    <button
      v-if="!editing"
      type="button"
      class="mt-6 block w-full rounded-xl border border-gray-200 p-4 text-left transition hover:bg-gray-50"
      @click="editing = true"
    >
      <span class="block font-medium text-gray-900">
        {{ $t('profile.security.change_password') }}
      </span>

      <span class="mt-1 block text-sm text-gray-700">
        {{ $t('profile.security.change_password_description') }}
      </span>
    </button>

    <form
      v-else
      class="mt-6 space-y-4"
      @submit.prevent="submit"
    >
      <p
        v-if="errors.general"
        class="rounded-xl bg-red-100 px-4 py-3 text-sm text-red-800"
      >
        {{ errors.general[0] }}
      </p>

      <p
        v-if="success"
        class="rounded-xl bg-green-100 px-4 py-3 text-sm text-green-800"
      >
        {{ success }}
      </p>

      <div>
        <label for="current-password"
               class="text-sm font-medium text-gray-700"
        >
          {{ $t('profile.password.current') }}
        </label>

        <input
          id="current-password"
          v-model="form.current_password"
          type="password"
          class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
        >

        <p
          v-if="errors.current_password"
          class="mt-2 text-sm text-red-700"
        >
          {{ errors.current_password[0] }}
        </p>
      </div>

      <div>
        <label for="new-password"
               class="text-sm font-medium text-gray-700"
        >
          {{ $t('profile.password.new') }}
        </label>

        <input
          id="new-password"
          v-model="form.new_password"
          type="password"
          class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
        >

        <p
          v-if="errors.new_password"
          class="mt-2 text-sm text-red-500"
        >
          {{ errors.new_password[0] }}
        </p>
      </div>

      <div>
        <label for="new-password-confirmation"
               class="text-sm font-medium text-gray-700"
        >
          {{ $t('profile.password.confirmation') }}
        </label>

        <input
          id="new-password-confirmation"
          v-model="form.new_password_confirmation"
          type="password"
          class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
        >

        <p
          v-if="errors.new_password_confirmation"
          class="mt-2 text-sm text-red-500"
        >
          {{ errors.new_password_confirmation[0] }}
        </p>
      </div>

      <div class="flex flex-col-reverse gap-3 sm:flex-row">
        <button
          type="button"
          class="rounded-xl border border-gray-300 px-4 py-2 text-gray-700 transition hover:bg-gray-50"
          @click="cancel"
        >
          {{ $t('profile.actions.cancel') }}
        </button>

        <AppButton
          type="submit"
          :disabled="loading"
        >
          {{
            loading
              ? $t('profile.password.updating')
              : $t('profile.security.change_password')
          }}
        </AppButton>
      </div>
    </form>
  </AppCard>
</template>

<script setup lang="ts">
import { ref } from 'vue'

import AppButton from '@/presentation/components/ui/AppButton.vue'
import AppCard from '@/presentation/components/ui/AppCard.vue'

import { useUpdatePassword } from '@/presentation/composables/useUpdatePassword'

const editing = ref(false)

const {
  form,
  loading,
  success,
  errors,
  submit,
  reset,
} = useUpdatePassword()

const cancel = (): void => {
  reset()

  editing.value = false
}
</script>
