import {AdminUsersApi} from '@/data/admin/AdminUsersApi'

import type {ManagedUser} from '@/domain/admin/models/ManagedUser'
import type {UpdateManagedUserDto} from '@/domain/admin/dto/UpdateManagedUserDto'

import type {AdminUserRepository} from '@/domain/admin/repositories/AdminUserRepository'

export class AdminUserRepositoryImpl
implements AdminUserRepository {
  async getAll(
    page: number,
    perPage: number,
  ): Promise<{
    data: ManagedUser[]
    meta: {
      current_page: number
      last_page: number
      per_page: number
      total: number
    }
  }> {
    const response = await AdminUsersApi.getAll(
      page,
      perPage,
    )

    return {
      data: response.data.data,
      meta: response.data.meta,
    }
  }

  async update(
    id: number,
    dto: UpdateManagedUserDto,
  ): Promise<ManagedUser> {
    const response = await AdminUsersApi.update(
      id,
      dto,
    )

    return response.data.data
  }

  async delete(id: number): Promise<void> {
    await AdminUsersApi.delete(id)
  }
}
