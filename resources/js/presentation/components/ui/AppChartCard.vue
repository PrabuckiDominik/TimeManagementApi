<template>
  <AppCard>
    <h3 class="text-lg font-semibold text-gray-900">
      {{ title }}
    </h3>

    <div class="mt-6 h-[320px]">
      <slot />
    </div>
  </AppCard>
</template>

<script setup lang="ts">
import AppCard from "@/presentation/components/ui/AppCard.vue"

defineProps<{
  title: string
}>()
</script>
