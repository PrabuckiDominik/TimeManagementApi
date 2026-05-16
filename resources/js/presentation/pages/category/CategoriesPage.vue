<template>
  <AppLayout>
    <div class="space-y-6">
      <CategoriesHeader />

      <CategoriesManager />
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/presentation/layouts/AppLayout.vue'

import CategoriesHeader from '@/presentation/components/categories/CategoriesHeader.vue'
import CategoriesManager from '@/presentation/components/categories/CategoriesManager.vue'
</script>
