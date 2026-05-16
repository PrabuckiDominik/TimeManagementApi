<script setup lang="ts">
defineProps<{
  text: string
  linkText: string
  link: string
}>()
</script>

<template>
  <div class="mt-8 text-center text-sm text-slate-600">
    {{ text }}

    <RouterLink
      :to="link"
      class="font-semibold text-violet-600 hover:underline"
    >
      {{ linkText }}
    </RouterLink>
  </div>
</template>
