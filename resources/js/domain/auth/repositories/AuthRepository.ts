import type { LoginDto } from '@/domain/auth/dto/LoginDto'
import type { RegisterDto } from '@/domain/auth/dto/RegisterDto'
import type { AuthResponse } from '@/domain/auth/models/AuthResponse'
import {type UpdatePasswordDto} from '@/domain/auth/dto/UpdatePasswordDto'
import {type ResetPasswordDto} from '@/domain/auth/dto/ResetPasswordDto'
import {type ForgotPasswordDto} from '@/domain/auth/dto/ForgotPasswordDto'

export interface AuthRepository {
  login: (dto: LoginDto) => Promise<AuthResponse>
  register: (dto: RegisterDto) => Promise<void>
  logout: () => Promise<void>
  updatePassword: (dto: UpdatePasswordDto) => Promise<void>
  forgotPassword: (dto: ForgotPasswordDto) => Promise<string>
  resetPassword: (dto: ResetPasswordDto) => Promise<string>
}
