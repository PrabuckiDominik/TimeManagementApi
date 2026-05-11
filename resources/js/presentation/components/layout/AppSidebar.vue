<template>
  <aside
    class="hidden lg:flex lg:w-72 lg:flex-col border-r border-gray-200 bg-white"
  >
    <div class="border-b border-gray-100 p-6">
      <h1 class="text-2xl font-bold text-gray-900">
        {{ appName }}
      </h1>
    </div>

    <nav class="flex-1 space-y-2 overflow-y-auto p-4">
      <RouterLink
        to="/dashboard"
        class="flex items-center rounded-xl px-4 py-3 text-sm font-medium transition"
        :class="isActive('/dashboard')
          ? 'bg-indigo-50 text-indigo-600'
          : 'text-gray-700 hover:bg-gray-100'"
      >
        Dashboard
      </RouterLink>

      <RouterLink
        to="/tasks"
        class="flex items-center rounded-xl px-4 py-3 text-sm font-medium transition"
        :class="isActive('/tasks')
          ? 'bg-indigo-50 text-indigo-600'
          : 'text-gray-700 hover:bg-gray-100'"
      >
        Tasks
      </RouterLink>

      <RouterLink
        to="/profile"
        class="flex items-center rounded-xl px-4 py-3 text-sm font-medium transition"
        :class="isActive('/profile')
          ? 'bg-indigo-50 text-indigo-600'
          : 'text-gray-700 hover:bg-gray-100'"
      >
        Profile
      </RouterLink>
    </nav>
  </aside>
</template>

<script setup lang="ts">
import { useRoute } from "vue-router"

const route = useRoute()

const appName =
  import.meta.env.VITE_APP_NAME ?? "TaskFlow"

const isActive = (path: string): boolean => {
  return route.path.startsWith(path)
}
</script>
