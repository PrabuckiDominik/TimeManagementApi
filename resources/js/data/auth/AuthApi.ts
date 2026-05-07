import { httpClient } from '@/data/http/httpClient'
import type { LoginDto } from '@/domain/auth/dto/LoginDto'
import type { RegisterDto } from '@/domain/auth/dto/RegisterDto'

export const AuthApi = {
  async login(dto: LoginDto) {
    return await httpClient.post('/api/auth/login', dto)
  },

  async register(dto: RegisterDto) {
    return await httpClient.post('/api/auth/register', dto)
  },
}
