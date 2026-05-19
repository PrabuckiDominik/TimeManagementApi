import {httpClient} from '@/data/http/httpClient'

import type {UpdateManagedUserDto} from '@/domain/admin/dto/UpdateManagedUserDto'

export const AdminUsersApi = {
  async getAll(
    page = 1,
    perPage = 15,
  ) {
    return await httpClient.get('/api/admin/users', {
      params: {
        page,
        per_page: perPage,
      },
    })
  },

  async update(
    id: number,
    dto: UpdateManagedUserDto,
  ) {
    return await httpClient.put(
      `/api/admin/users/${id}`,
      dto,
    )
  },

  async delete(id: number) {
    return await httpClient.delete(
      `/api/admin/users/${id}`,
    )
  },
}
