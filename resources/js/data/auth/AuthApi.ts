import {httpClient} from '@/data/http/httpClient'
import type {LoginDto} from '@/domain/auth/dto/LoginDto'
import type {RegisterDto} from '@/domain/auth/dto/RegisterDto'
import {type UpdatePasswordDto} from '@/domain/auth/dto/UpdatePasswordDto'
import {type ForgotPasswordDto} from '@/domain/auth/dto/ForgotPasswordDto'
import {type ResetPasswordDto} from '@/domain/auth/dto/ResetPasswordDto'

export const AuthApi = {
  async login(dto: LoginDto) {
    return await httpClient.post('/api/auth/login', dto)
  },

  async register(dto: RegisterDto) {
    return await httpClient.post('/api/auth/register', dto)
  },

  async logout() {
    return await httpClient.post('/api/auth/logout')
  },

  async updatePassword(dto: UpdatePasswordDto) {
    return await httpClient.put('/api/auth/change-password', dto)
  },

  async forgotPassword(dto: ForgotPasswordDto) {
    return await httpClient.post('/api/auth/forgot-password', dto)
  },

  async resetPassword(dto: ResetPasswordDto) {
    return await httpClient.post('/api/auth/reset-password', dto)
  },
}
