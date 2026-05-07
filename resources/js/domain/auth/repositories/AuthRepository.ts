import type { LoginDto } from '@/domain/auth/dto/LoginDto'
import type { RegisterDto } from '@/domain/auth/dto/RegisterDto'

import type { AuthResponse } from '@/domain/auth/models/AuthResponse'

export interface AuthRepository {
  login: (dto: LoginDto) => Promise<AuthResponse>

  register: (dto: RegisterDto) => Promise<void>
}
