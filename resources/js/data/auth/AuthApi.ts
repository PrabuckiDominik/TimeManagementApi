import { httpClient } from "@/data/http/httpClient"
import type { LoginDto } from "@/domain/auth/dto/LoginDto"
import type { RegisterDto } from "@/domain/auth/dto/RegisterDto"

export class AuthApi {
  static async login(dto: LoginDto) {
    return httpClient.post("/api/auth/login", dto)
  }

  static async register(dto: RegisterDto) {
    return httpClient.post("/api/auth/register", dto)
  }
}
