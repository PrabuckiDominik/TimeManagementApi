<template>
  <AppLayout>
    <div class="mx-auto max-w-4xl space-y-6">
      <ProfileHeader />

      <ProfileCard
        v-if="user"
        :user="user"
        :form="form"
        :editing="editing"
        :saving="saving"
        :errors="errors"
        @edit="editing = true"
        @save="updateProfile"
        @cancel="cancelEdit"
      />

      <ProfileLanguageCard />

      <ProfileSecurityCard />

      <ProfileLogoutCard />
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/presentation/layouts/AppLayout.vue'

import ProfileCard from '@/presentation/components/profile/cards/ProfileCard.vue'
import ProfileHeader from '@/presentation/components/profile/ProfileHeader.vue'
import ProfileLanguageCard from '@/presentation/components/profile/cards/ProfileLanguageCard.vue'
import ProfileLogoutCard from '@/presentation/components/profile/cards/ProfileLogoutCard.vue'
import ProfileSecurityCard from '@/presentation/components/profile/cards/ProfileSecurityCard.vue'

import {useProfile} from '@/presentation/composables/useProfile'

const {
  user,
  form,
  saving,
  editing,
  errors,
  updateProfile,
  cancelEdit,
} = useProfile()
</script>
