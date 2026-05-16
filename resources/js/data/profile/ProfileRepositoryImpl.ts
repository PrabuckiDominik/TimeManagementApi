import { ProfileApi } from '@/data/profile/ProfileApi'

import type { User } from '@/domain/auth/models/User'
import type { UpdateProfileDto } from '@/domain/profile/dto/UpdateProfileDto'
import type { ProfileRepository } from '@/domain/profile/repositories/ProfileRepository'

export class ProfileRepositoryImpl implements ProfileRepository {
  async get(): Promise<User> {
    const response = await ProfileApi.get()

    return response.data.data
  }

  async update(dto: UpdateProfileDto): Promise<User> {
    const response = await ProfileApi.update(dto)

    return response.data.data
  }
}
