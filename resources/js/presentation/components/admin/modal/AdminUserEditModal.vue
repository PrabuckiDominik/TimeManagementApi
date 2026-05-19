<template>
  <div
    class="fixed inset-0 z-50 bg-black/40 sm:p-4"
    @click.self="$emit('close')"
  >
    <div class="flex min-h-full items-end justify-center sm:items-center">
      <AppCard class="w-full max-w-lg">
        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
          <h2 class="text-xl font-semibold text-gray-900">
            {{ $t('admin.users.edit_title') }}
          </h2>

          <button
            type="button"
            class="text-2xl text-gray-700 transition hover:text-gray-900"
            @click="$emit('close')"
          >
            ×
          </button>
        </div>

        <form
          class="mt-5 space-y-4"
          @submit.prevent="submit"
        >
          <FormTextInput
            id="admin-user-name"
            v-model="form.name"
            :label="$t('admin.users.fields.name')"
            :error="errors.name"
            :maxlength="255"
          />

          <FormTextInput
            id="admin-user-email"
            v-model="form.email"
            type="email"
            :label="$t('admin.users.fields.email')"
            :error="errors.email"
            :maxlength="255"
          />

          <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button
              type="button"
              class="rounded-xl border border-gray-300 px-4 py-2 text-gray-800 transition hover:bg-gray-100"
              @click="$emit('close')"
            >
              {{ $t('admin.users.actions.cancel') }}
            </button>

            <AppButton
              type="submit"
              :disabled="saving"
            >
              {{ $t('admin.users.actions.save') }}
            </AppButton>
          </div>
        </form>
      </AppCard>
    </div>
  </div>
</template>

<script setup lang="ts">
import {reactive} from 'vue'

import AppButton from '@/presentation/components/ui/AppButton.vue'
import AppCard from '@/presentation/components/ui/AppCard.vue'
import FormTextInput from '@/presentation/components/ui/forms/FormTextInput.vue'

import type {ManagedUser} from '@/domain/admin/models/ManagedUser'
import type {UpdateManagedUserDto} from '@/domain/admin/dto/UpdateManagedUserDto'

const props = defineProps<{
  user: ManagedUser
  saving: boolean
  errors: Record<string, string[]>
}>()

const emit = defineEmits<{
  close: []
  save: [dto: UpdateManagedUserDto]
}>()

const form = reactive<UpdateManagedUserDto>({
  name: props.user.name,
  email: props.user.email,
})

const submit = (): void => {
  emit('save', {
    name: form.name.trim(),
    email: form.email.trim(),
  })
}
</script>
