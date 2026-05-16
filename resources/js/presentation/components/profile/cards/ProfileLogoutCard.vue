<template>
  <AppCard>
    <button
      type="button"
      class="w-full rounded-xl bg-red-50 p-4 font-medium text-red-600 transition hover:bg-red-100 disabled:cursor-not-allowed disabled:opacity-50"
      :disabled="loading"
      @click="logout"
    >
      {{
        loading
          ? $t('profile.actions.logging_out')
          : $t('profile.actions.logout')
      }}
    </button>
  </AppCard>
</template>

<script setup lang="ts">
import AppCard from '@/presentation/components/ui/AppCard.vue'

import { useLogout } from '@/presentation/composables/useLogout'

const {
  logout,
  loading,
} = useLogout()
</script>
