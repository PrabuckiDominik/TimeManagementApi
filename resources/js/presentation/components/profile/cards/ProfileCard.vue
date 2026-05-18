<template>
  <AppCard>
    <div class="flex flex-col gap-6 sm:flex-row sm:items-start">
      <AppAvatar :initials="initials" />

      <div class="flex-1">
        <template v-if="!editing">
          <h2 class="text-2xl font-semibold text-gray-900">
            {{ user.name }}
          </h2>

          <p class="mt-2 text-sm text-gray-700">
            {{ user.email }}
          </p>

          <AppButton
            class="mt-4"
            @click="$emit('edit')"
          >
            {{ $t('profile.actions.edit') }}
          </AppButton>
        </template>

        <template v-else>
          <div class="space-y-4">
            <div>
              <label for="profile-name"
                     class="text-sm font-medium text-gray-700"
              >
                {{ $t('profile.fields.name') }}
              </label>

              <input
                id="profile-name"
                v-model="name"
                type="text"
                maxlength="255"
                class="mt-2 w-full rounded-xl border border-gray-300 px-4 py-3 outline-none transition focus:border-indigo-500"
              >

              <p
                v-if="errors.name"
                class="mt-2 text-sm text-red-500"
              >
                {{ errors.name[0] }}
              </p>
            </div>

            <div>
              <label for="profile-email"
                     class="text-sm font-medium text-gray-700"
              >
                {{ $t('profile.fields.email') }}
              </label>

              <input
                id="profile-email"
                :value="user.email"
                disabled
                type="email"
                class="mt-2 w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-gray-700"
              >
            </div>

            <div class="flex flex-col-reverse gap-3 sm:flex-row">
              <button
                type="button"
                class="rounded-xl border border-gray-300 px-4 py-2 text-gray-700 transition hover:bg-gray-50"
                @click="$emit('cancel')"
              >
                {{ $t('profile.actions.cancel') }}
              </button>

              <AppButton
                :disabled="saving"
                @click="$emit('save')"
              >
                {{ $t('profile.actions.save') }}
              </AppButton>
            </div>
          </div>
        </template>
      </div>
    </div>
  </AppCard>
</template>

<script setup lang="ts">
import {computed} from 'vue'

import AppAvatar from '@/presentation/components/ui/AppAvatar.vue'
import AppButton from '@/presentation/components/ui/AppButton.vue'
import AppCard from '@/presentation/components/ui/AppCard.vue'

import type {User} from '@/domain/auth/models/User'
import type {UpdateProfileDto} from '@/domain/profile/dto/UpdateProfileDto'

const props = defineProps<{
  user: User
  form: UpdateProfileDto
  editing: boolean
  saving: boolean
  errors: Record<string, string[]>
}>()

const emit = defineEmits<{
  edit: []
  save: []
  cancel: []
  updateName: [value: string]
}>()

const name = computed({
  get: () => props.form.name,
  set: value => {
    emit('updateName', value)
  },
})

const initials = computed(() =>
  props.user.name
    .split(' ')
    .map(part => part[0])
    .join('')
    .slice(0, 2)
    .toUpperCase(),
)
</script>
