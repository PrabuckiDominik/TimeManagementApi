<template>
  <header
    class="sticky top-0 z-20 border-b border-gray-200 bg-white/90 backdrop-blur"
  >
    <div class="flex items-center justify-between px-4 py-4 lg:px-8">
      <div class="flex items-center gap-3">
        <button
          class="rounded-xl border border-gray-200 p-2 lg:hidden"
          @click="$emit('open-sidebar')"
        >
          ☰
        </button>

        <div>
          <h2 class="text-xl font-semibold text-gray-900">
            Dashboard
          </h2>

          <p class="text-sm text-gray-500">
            Welcome back
          </p>
        </div>
      </div>

      <div class="flex items-center gap-4">
        <button
          class="relative rounded-xl border border-gray-200 p-2"
        >
          🔔

          <span
            class="absolute -right-1 -top-1 flex size-5 items-center justify-center rounded-full bg-red-500 text-xs text-white"
          >
            5
          </span>
        </button>

        <AppAvatar initials="JD" />
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import AppAvatar from "@/presentation/components/ui/AppAvatar.vue"

defineEmits<{
  "open-sidebar": []
}>()
</script>
