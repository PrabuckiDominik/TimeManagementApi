<template>
  <AppLayout>
    <div class="space-y-6">
      <AdminUsersHeader :total="total" />

      <template v-if="loading">
        <div class="space-y-4">
          <AppSkeleton
            v-for="item in 5"
            :key="item"
            height="h-20"
          />
        </div>
      </template>

      <AdminUsersTable
        v-else
        :users="users"
        :page="page"
        :last-page="lastPage"
        :saving="saving"
        @edit="editingUser = $event"
        @delete="handleDelete"
        @change-page="goToPage"
      />

      <AdminUserEditModal
        v-if="editingUser"
        :user="editingUser"
        :saving="saving"
        :errors="errors"
        @close="editingUser = null"
        @save="handleUpdate"
      />
    </div>
  </AppLayout>
</template>

<script setup lang="ts">
import {ref} from 'vue'
import {useI18n} from 'vue-i18n'

import AppLayout from '@/presentation/layouts/AppLayout.vue'
import AppSkeleton from '@/presentation/components/ui/AppSkeleton.vue'

import AdminUsersHeader from '@/presentation/components/admin/AdminUsersHeader.vue'
import AdminUsersTable from '@/presentation/components/admin/AdminUsersTable.vue'
import AdminUserEditModal from '@/presentation/components/admin/modal/AdminUserEditModal.vue'

import {useAdminUsers} from '@/presentation/composables/useAdminUsers'

import type {ManagedUser} from '@/domain/admin/models/ManagedUser'
import type {UpdateManagedUserDto} from '@/domain/admin/dto/UpdateManagedUserDto'

const {t} = useI18n()

const editingUser = ref<ManagedUser | null>(null)

const {
  users,
  loading,
  saving,
  errors,
  page,
  lastPage,
  total,
  updateUser,
  deleteUser,
  goToPage,
} = useAdminUsers()

const handleUpdate = async (dto: UpdateManagedUserDto): Promise<void> => {
  if (!editingUser.value) {
    return
  }

  await updateUser(editingUser.value, dto)

  editingUser.value = null
}

const handleDelete = async (user: ManagedUser): Promise<void> => {
  if (!confirm(String(t('admin.users.confirm_delete')))) {
    return
  }

  await deleteUser(user)
}
</script>
