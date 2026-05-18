import {CategoryApi} from '@/data/categories/CategoryApi'

import type {Category} from '@/domain/categories/models/Category'
import type {StoreCategoryDto} from '@/domain/categories/dto/StoreCategoryDto'
import type {UpdateCategoryDto} from '@/domain/categories/dto/UpdateCategoryDto'
import type {CategoryRepository} from '@/domain/categories/repositories/CategoryRepository'

export class CategoryRepositoryImpl implements CategoryRepository {
  async getAll(): Promise<Category[]> {
    const response = await CategoryApi.getAll()

    return response.data.data
  }

  async create(dto: StoreCategoryDto): Promise<Category> {
    const response = await CategoryApi.create(dto)

    return response.data.data
  }

  async update(id: number, dto: UpdateCategoryDto): Promise<Category> {
    const response = await CategoryApi.update(id, dto)

    return response.data.data
  }

  async delete(id: number): Promise<void> {
    await CategoryApi.delete(id)
  }
}
