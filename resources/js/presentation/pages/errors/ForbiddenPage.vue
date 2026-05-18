<template>
  <div class="flex min-h-screen items-center justify-center bg-gray-50 px-6">
    <div class="max-w-md text-center">
      <h1 class="text-5xl font-bold text-red-700">
        403
      </h1>

      <h2 class="mt-4 text-2xl font-semibold text-gray-900">
        {{ $t('errors.forbidden.title') }}
      </h2>

      <p class="mt-3 text-gray-700">
        {{ $t('errors.forbidden.description') }}
      </p>
    </div>
  </div>
</template>
