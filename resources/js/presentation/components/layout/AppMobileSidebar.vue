<template>
  <Transition name="fade">
    <div
      v-if="open"
      class="fixed inset-0 z-40 bg-black/50 lg:hidden"
      @click="emit('close')"
    />
  </Transition>

  <Transition name="slide">
    <aside
      v-if="open"
      class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-xl lg:hidden"
    >
      <div class="flex items-center justify-between border-b border-gray-100 p-6">
        <h1 class="text-2xl font-bold text-gray-900">
          {{ appName }}
        </h1>

        <button
          class="rounded-xl border border-gray-300 p-2 text-gray-800 transition hover:bg-gray-100"
          :aria-label="$t('profile.actions.cancel')"
          @click="emit('close')"
        >
          <span aria-hidden="true">✕</span>
        </button>
      </div>

      <nav class="space-y-2 overflow-y-auto p-4">
        <RouterLink
          to="/dashboard"
          class="block rounded-xl px-4 py-3 text-sm font-medium transition"
          :class="isActive('/dashboard')
            ? 'bg-indigo-100 text-indigo-800'
            : 'text-gray-800 hover:bg-gray-100'"
          @click="emit('close')"
        >
          {{ $t('sidebar.dashboard') }}
        </RouterLink>

        <RouterLink
          to="/tasks"
          class="block rounded-xl px-4 py-3 text-sm font-medium transition"
          :class="isTasksActive
            ? 'bg-indigo-100 text-indigo-800'
            : 'text-gray-800 hover:bg-gray-100'"
          @click="emit('close')"
        >
          {{ $t('sidebar.tasks') }}
        </RouterLink>

        <RouterLink
          to="/profile"
          class="block rounded-xl px-4 py-3 text-sm font-medium transition"
          :class="isActive('/profile')
            ? 'bg-indigo-100 text-indigo-800'
            : 'text-gray-800 hover:bg-gray-100'"
          @click="emit('close')"
        >
          {{ $t('sidebar.profile') }}
        </RouterLink>

        <RouterLink
          v-if="isAdmin"
          to="/admin/users"
          class="block rounded-xl px-4 py-3 text-sm font-medium transition"
          :class="isActive('/admin/users')
            ? 'bg-indigo-100 text-indigo-800'
            : 'text-gray-800 hover:bg-gray-100'"
          @click="emit('close')"
        >
          {{ $t('sidebar.admin_users') }}
        </RouterLink>

        <RouterLink
          v-if="isAdmin"
          to="/admin/activity-logs"
          class="block rounded-xl px-4 py-3 text-sm font-medium transition"
          :class="isActive('/admin/activity-logs')
            ? 'bg-indigo-100 text-indigo-800'
            : 'text-gray-800 hover:bg-gray-100'"
          @click="emit('close')"
        >
          {{ $t('sidebar.activity_logs') }}
        </RouterLink>

        <div class="pt-6">
          <div class="mb-2 flex items-center justify-between px-4">
            <span class="text-xs font-semibold uppercase tracking-wide text-gray-600">
              {{ $t('sidebar.categories') }}
            </span>

            <RouterLink
              to="/categories"
              class="text-lg font-semibold text-gray-600 transition hover:text-indigo-800"
              :aria-label="$t('sidebar.add_category')"
              @click="emit('close')"
            >
              +
            </RouterLink>
          </div>

          <div class="space-y-1">
            <RouterLink
              v-for="category in categories"
              :key="category.id"
              :to="`/tasks?category_id=${category.id}`"
              class="flex items-center rounded-xl px-4 py-3 text-sm font-medium transition"
              :class="isCategoryActive(category.id)
                ? 'bg-indigo-100 text-indigo-800'
                : 'text-gray-700 hover:bg-gray-100'"
              @click="emit('close')"
            >
              <span
                class="mr-3 size-2 rounded-full"
                :style="{ backgroundColor: category.color ?? '#4338ca' }"
              />

              <span class="truncate">
                {{ category.title }}
              </span>
            </RouterLink>
          </div>
        </div>
      </nav>
    </aside>
  </Transition>
</template>

<script setup lang="ts">
import {computed} from 'vue'
import {useRoute} from 'vue-router'

import {useCategories} from '@/presentation/composables/useCategories'
import {hasAdminRole} from '@/shared/auth/hasAdminRole'

const isAdmin = computed(() => hasAdminRole())

const {open} = defineProps<{
  open: boolean
}>()

const emit = defineEmits<{
  close: []
}>()

const route = useRoute()

const {
  categories,
} = useCategories()

const appName =
  import.meta.env.VITE_APP_NAME ?? 'Time Management'

const isActive = (path: string): boolean => {
  return route.path.startsWith(path)
}

const isTasksActive = computed(() =>
  route.path === '/tasks' && !route.query.category_id,
)

const isCategoryActive = (categoryId: number): boolean => {
  return route.path === '/tasks'
    && Number(route.query.category_id) === categoryId
}
</script>
