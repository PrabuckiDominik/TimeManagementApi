<template>
  <header class="sticky top-0 z-20 border-b border-gray-200 bg-white/90 backdrop-blur">
    <div class="flex items-center justify-between p-4 lg:px-8">
      <div class="flex items-center gap-3">
        <button
          class="rounded-xl border border-gray-200 p-2 lg:hidden"
          @click="$emit('open-sidebar')"
        >
          ☰
        </button>
      </div>
    </div>
  </header>
</template>

<script setup lang='ts'>
defineEmits<{
  'open-sidebar': []
}>()
</script>
