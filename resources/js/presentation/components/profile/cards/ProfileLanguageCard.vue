<template>
  <AppCard>
    <h2 class="text-xl font-semibold text-gray-900">
      {{ $t('profile.language.title') }}
    </h2>

    <div class="mt-6">
      <label class="text-sm font-medium text-gray-700">
        {{ $t('profile.language.label') }}
      </label>

      <select
        v-model="selectedLocale"
        class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
      >
        <option value="pl">
          Polski
        </option>

        <option value="en">
          English
        </option>
      </select>
    </div>
  </AppCard>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

import AppCard from '@/presentation/components/ui/AppCard.vue'

const { locale } = useI18n()

const selectedLocale = computed({
  get: () => locale.value,
  set: value => {
    locale.value = value
    localStorage.setItem('locale', value)
  },
})
</script>
