<template>
  <Transition name="fade">
    <div
      v-if="open"
      class="fixed inset-0 z-40 bg-black/50 lg:hidden"
      @click="$emit('close')"
    />
  </Transition>

  <Transition name="slide">
    <aside
      v-if="open"
      class="fixed inset-y-0 left-0 z-50 w-72 bg-white shadow-xl lg:hidden"
    >
      <div
        class="flex items-center justify-between border-b border-gray-100 p-6"
      >
        <h1 class="text-2xl font-bold text-gray-900">
          {{ appName }}
        </h1>

        <button
          class="rounded-xl border border-gray-200 p-2"
          @click="$emit('close')"
        >
          ✕
        </button>
      </div>

      <nav class="space-y-2 p-4">
        <RouterLink
          to="/dashboard"
          class="block rounded-xl px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100"
          @click="$emit('close')"
        >
          Dashboard
        </RouterLink>

        <RouterLink
          to="/tasks"
          class="block rounded-xl px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100"
          @click="$emit('close')"
        >
          Tasks
        </RouterLink>

        <RouterLink
          to="/profile"
          class="block rounded-xl px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-100"
          @click="$emit('close')"
        >
          Profile
        </RouterLink>
      </nav>
    </aside>
  </Transition>
</template>

<script setup lang="ts">
defineProps<{
  open: boolean
}>()

defineEmits<{
  close: []
}>()

const appName =
  import.meta.env.VITE_APP_NAME ?? "TaskFlow"
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.slide-enter-active,
.slide-leave-active {
  transition: transform 0.25s ease;
}

.slide-enter-from,
.slide-leave-to {
  transform: translateX(-100%);
}
</style>
