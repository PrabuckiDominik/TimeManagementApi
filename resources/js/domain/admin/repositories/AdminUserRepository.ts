import type {ManagedUser} from '@/domain/admin/models/ManagedUser'
import type {UpdateManagedUserDto} from '@/domain/admin/dto/UpdateManagedUserDto'

export interface AdminUserRepository {
  getAll: (
    page: number,
    perPage: number,
  ) => Promise<{
    data: ManagedUser[]
    meta: {
      current_page: number
      last_page: number
      per_page: number
      total: number
    }
  }>

  update: (
    id: number,
    dto: UpdateManagedUserDto,
  ) => Promise<ManagedUser>

  delete: (id: number) => Promise<void>
}
