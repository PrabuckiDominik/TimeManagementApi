import type { Category } from '@/domain/categories/models/Category'
import type { StoreCategoryDto } from '@/domain/categories/dto/StoreCategoryDto'
import type { UpdateCategoryDto } from '@/domain/categories/dto/UpdateCategoryDto'

export interface CategoryRepository {
  getAll: () => Promise<Category[]>
  create: (dto: StoreCategoryDto) => Promise<Category>
  update: (id: number, dto: UpdateCategoryDto) => Promise<Category>
  delete: (id: number) => Promise<void>
}
