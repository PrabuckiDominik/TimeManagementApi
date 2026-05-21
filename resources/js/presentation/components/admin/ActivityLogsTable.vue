<template>
  <AppCard>
    <div
      v-if="logs.length === 0"
      class="text-center text-sm text-gray-700"
    >
      {{ $t('admin.activity.empty') }}
    </div>

    <div
      v-else
      class="overflow-x-auto"
    >
      <table class="w-full text-left text-sm">
        <thead>
          <tr class="border-b border-gray-300 text-gray-700">
            <th class="px-4 py-3 font-semibold">
              {{ $t('admin.activity.fields.date') }}
            </th>

            <th class="px-4 py-3 font-semibold">
              {{ $t('admin.activity.fields.event') }}
            </th>

            <th class="px-4 py-3 font-semibold">
              {{ $t('admin.activity.fields.description') }}
            </th>

            <th class="px-4 py-3 font-semibold">
              {{ $t('admin.activity.fields.causer') }}
            </th>

            <th class="px-4 py-3 font-semibold">
              {{ $t('admin.activity.fields.subject') }}
            </th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="log in logs"
            :key="log.id"
            class="border-b border-gray-200"
          >
            <td class="p-4 text-gray-800">
              {{ formatDate(log.created_at) }}
            </td>

            <td class="p-4">
              <span class="rounded-md bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-800">
                {{ log.event ?? '-' }}
              </span>
            </td>

            <td class="p-4 font-medium text-gray-900">
              {{ log.description }}
            </td>

            <td class="p-4 text-gray-800">
              <template v-if="log.causer">
                {{ log.causer.name }}
                <span class="block text-xs text-gray-600">
                  {{ log.causer.email }}
                </span>
              </template>

              <template v-else>
                -
              </template>
            </td>

            <td class="p-4 text-gray-800">
              {{ shortSubject(log.subject_type) }}
              <span
                v-if="log.subject_id"
                class="block text-xs text-gray-600"
              >
                ID: {{ log.subject_id }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="mt-6 flex items-center justify-between">
        <button
          type="button"
          class="rounded-xl border border-gray-300 px-4 py-2 text-gray-800 disabled:opacity-50"
          :disabled="page <= 1"
          @click="$emit('changePage', page - 1)"
        >
          {{ $t('admin.pagination.previous') }}
        </button>

        <span class="text-sm text-gray-700">
          {{ page }} / {{ lastPage }}
        </span>

        <button
          type="button"
          class="rounded-xl border border-gray-300 px-4 py-2 text-gray-800 disabled:opacity-50"
          :disabled="page >= lastPage"
          @click="$emit('changePage', page + 1)"
        >
          {{ $t('admin.pagination.next') }}
        </button>
      </div>
    </div>
  </AppCard>
</template>

<script setup lang="ts">
import AppCard from '@/presentation/components/ui/AppCard.vue'

import type {ActivityLog} from '@/domain/admin/models/ActivityLog'

defineProps<{
  logs: ActivityLog[]
  page: number
  lastPage: number
}>()

defineEmits<{
  changePage: [page: number]
}>()

const formatDate = (date: string): string => {
  return new Date(date).toLocaleString()
}

const shortSubject = (
  subjectType: string | null,
): string => {
  if (!subjectType) {
    return '-'
  }

  return subjectType.split('\\').pop() ?? subjectType
}
</script>
