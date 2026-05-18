import type {StoreTagDto} from '@/domain/tags/dto/StoreTagDto'
import type {UpdateTagDto} from '@/domain/tags/dto/UpdateTagDto'
import type {Tag} from '@/domain/tags/models/Tag'

export interface TagRepository {
  getAll: () => Promise<Tag[]>
  create: (dto: StoreTagDto) => Promise<Tag>
  update: (id: number, dto: UpdateTagDto) => Promise<Tag>
  delete: (id: number) => Promise<void>
}
