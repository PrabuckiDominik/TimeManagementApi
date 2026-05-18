import {AuthApi} from '@/data/auth/AuthApi'

import type {LoginDto} from '@/domain/auth/dto/LoginDto'
import type {RegisterDto} from '@/domain/auth/dto/RegisterDto'

import type {AuthRepository} from '@/domain/auth/repositories/AuthRepository'
import type {AuthResponse} from '@/domain/auth/models/AuthResponse'
import {type UpdatePasswordDto} from '@/domain/auth/dto/UpdatePasswordDto'
import {type ForgotPasswordDto} from '@/domain/auth/dto/ForgotPasswordDto'
import {type ResetPasswordDto} from '@/domain/auth/dto/ResetPasswordDto'

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

  async logout(): Promise<void> {
    await AuthApi.logout()
  }

  async updatePassword(dto: UpdatePasswordDto): Promise<void> {
    await AuthApi.updatePassword(dto)
  }

  async forgotPassword(dto: ForgotPasswordDto): Promise<string> {
    const response = await AuthApi.forgotPassword(dto)

    return response.data.message
  }

  async resetPassword(dto: ResetPasswordDto): Promise<string> {
    const response = await AuthApi.resetPassword(dto)

    return response.data.message
  }
}
