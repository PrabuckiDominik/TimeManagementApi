import type { User } from '@/domain/auth/models/User'

export interface AuthResponse {
  token: string
  user: User
}
