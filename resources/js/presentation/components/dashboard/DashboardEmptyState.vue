<template>
  <AppCard class="text-center">
    <h2 class="text-xl font-semibold text-gray-900">
      {{ $t('dashboard.empty.title') }}
    </h2>

    <p class="mt-2 text-gray-600">
      {{ $t('dashboard.empty.description') }}
    </p>
  </AppCard>
</template>

<script setup lang="ts">
import AppCard from '@/presentation/components/ui/AppCard.vue'
</script>
