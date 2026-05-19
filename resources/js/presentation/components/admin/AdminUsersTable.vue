<template>
  <AppCard>
    <div
      v-if="users.length === 0"
      class="text-center text-sm text-gray-700"
    >
      {{ $t('admin.users.empty') }}
    </div>

    <div
      v-else
      class="overflow-x-auto"
    >
      <table class="w-full text-left text-sm">
        <thead>
          <tr class="border-b border-gray-300 text-gray-700">
            <th class="px-4 py-3 font-semibold">
              {{ $t('admin.users.fields.name') }}
            </th>

            <th class="px-4 py-3 font-semibold">
              {{ $t('admin.users.fields.email') }}
            </th>

            <th class="px-4 py-3 font-semibold">
              {{ $t('admin.users.fields.roles') }}
            </th>

            <th class="px-4 py-3 text-right font-semibold">
              {{ $t('admin.users.fields.actions') }}
            </th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="user in users"
            :key="user.id"
            class="border-b border-gray-200"
          >
            <td class="p-4 font-medium text-gray-900">
              {{ user.name }}
            </td>

            <td class="p-4 text-gray-800">
              {{ user.email }}
            </td>

            <td class="p-4 text-gray-800">
              {{ user.roles?.join(', ') }}
            </td>

            <td class="p-4">
              <div class="flex justify-end gap-2">
                <button
                  type="button"
                  class="rounded-xl px-3 py-2 text-sm text-indigo-800 transition hover:bg-indigo-50"
                  @click="$emit('edit', user)"
                >
                  {{ $t('admin.users.actions.edit') }}
                </button>

                <button
                  type="button"
                  class="rounded-xl px-3 py-2 text-sm text-red-800 transition hover:bg-red-100"
                  :disabled="saving"
                  @click="$emit('delete', user)"
                >
                  {{ $t('admin.users.actions.delete') }}
                </button>
              </div>
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

import type {ManagedUser} from '@/domain/admin/models/ManagedUser'

defineProps<{
  users: ManagedUser[]
  page: number
  lastPage: number
  saving: boolean
}>()

defineEmits<{
  edit: [user: ManagedUser]
  delete: [user: ManagedUser]
  changePage: [page: number]
}>()
</script>
