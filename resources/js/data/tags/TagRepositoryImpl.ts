import { TagApi } from '@/data/tags/TagApi'

import type { StoreTagDto } from '@/domain/tags/dto/StoreTagDto'
import type { UpdateTagDto } from '@/domain/tags/dto/UpdateTagDto'
import type { Tag } from '@/domain/tags/models/Tag'
import type { TagRepository } from '@/domain/tags/repositories/TagRepository'

export class TagRepositoryImpl implements TagRepository {
  async getAll(): Promise<Tag[]> {
    const response = await TagApi.getAll()

    return response.data.data
  }

  async create(dto: StoreTagDto): Promise<Tag> {
    const response = await TagApi.create(dto)

    return response.data.data
  }

  async update(id: number, dto: UpdateTagDto): Promise<Tag> {
    const response = await TagApi.update(id, dto)

    return response.data.data
  }

  async delete(id: number): Promise<void> {
    await TagApi.delete(id)
  }
}
