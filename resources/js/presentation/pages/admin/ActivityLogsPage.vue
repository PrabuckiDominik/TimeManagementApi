<template>
  <AppLayout>
    <div class="space-y-6">
      <ActivityLogsHeader :total="total" />

      <template v-if="loading">
        <div class="space-y-4">
          <AppSkeleton
            v-for="item in 6"
            :key="item"
            height="h-20"
          />
        </div>
      </template>

      <ActivityLogsTable
        v-else
        :logs="logs"
        :page="page"
        :last-page="lastPage"
        @change-page="goToPage"
      />
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/presentation/layouts/AppLayout.vue'
import AppSkeleton from '@/presentation/components/ui/AppSkeleton.vue'

import ActivityLogsHeader from '@/presentation/components/admin/ActivityLogsHeader.vue'
import ActivityLogsTable from '@/presentation/components/admin/ActivityLogsTable.vue'

import {useActivityLogs} from '@/presentation/composables/useActivityLogs'

const {
  logs,
  loading,
  page,
  lastPage,
  total,
  goToPage,
} = useActivityLogs()
</script>
