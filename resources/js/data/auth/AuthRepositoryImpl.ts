import { AuthApi } from '@/data/auth/AuthApi'

import type { LoginDto } from '@/domain/auth/dto/LoginDto'
import type { RegisterDto } from '@/domain/auth/dto/RegisterDto'

import type { AuthRepository } from '@/domain/auth/repositories/AuthRepository'
import type { AuthResponse } from '@/domain/auth/models/AuthResponse'

export class AuthRepositoryImpl implements AuthRepository {
  async login(dto: LoginDto): Promise<AuthResponse> {
    const response = await AuthApi.login(dto)

    return {
      token: response.data.token,
      user: response.data.user,
    }
  }

  async register(dto: RegisterDto): Promise<void> {
    await AuthApi.register(dto)
  }
}
