import type {User} from '@/domain/auth/models/User'
import type {UpdateProfileDto} from '@/domain/profile/dto/UpdateProfileDto'

export interface ProfileRepository {
  get: () => Promise<User>
  update: (dto: UpdateProfileDto) => Promise<User>
}
