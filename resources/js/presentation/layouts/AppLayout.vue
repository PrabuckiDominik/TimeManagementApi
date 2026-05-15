<template>
  <div class="min-h-screen bg-gray-50">
    <AppSidebar />

    <div class="flex min-h-screen flex-col lg:ml-72">
      <AppTopbar
        @open-sidebar="mobileSidebarOpen = true"
      />

      <AppContainer>
        <slot />
      </AppContainer>
    </div>

    <AppMobileSidebar
      :open="mobileSidebarOpen"
      @close="mobileSidebarOpen = false"
    />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

import AppContainer from '@/presentation/components/layout/AppContainer.vue'
import AppMobileSidebar from '@/presentation/components/layout/AppMobileSidebar.vue'
import AppSidebar from '@/presentation/components/layout/AppSidebar.vue'
import AppTopbar from '@/presentation/components/layout/AppTopbar.vue'

const mobileSidebarOpen = ref(false)
</script>
