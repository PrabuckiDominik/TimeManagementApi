<script>
import { appConfig } from "@/appConfig"
import {defineComponent} from "vue";

export default defineComponent({
  computed: {
    appConfig() {
      return appConfig
    }
  }
})

</script>
<template>
  <div class="flex flex-col items-center">
    <div
      class="flex h-16 w-16 items-center justify-center rounded-2xl border-4 border-white bg-white/10 backdrop-blur"
    >
      <span class="text-2xl font-bold text-white">✓</span>
    </div>

    <h1 class="mt-3 text-3xl sm:text-4xl font-bold text-white text-center">
      {{ appConfig.name }}
    </h1>

    <p class="mt-2 text-lg text-white/80">
      Manage your tasks efficiently
    </p>
  </div>
</template>
