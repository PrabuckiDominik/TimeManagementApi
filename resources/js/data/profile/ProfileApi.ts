import { httpClient } from '@/data/http/httpClient'

import type { UpdateProfileDto } from '@/domain/profile/dto/UpdateProfileDto'

export const ProfileApi = {
  async get() {
    return await httpClient.get('/api/profile')
  },

  async update(dto: UpdateProfileDto) {
    return await httpClient.put('/api/profile', dto)
  },
}
