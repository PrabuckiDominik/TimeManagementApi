import type { DashboardStats } from "@/domain/dashboard/models/DashboardStats"

export interface DashboardRepository {
  getStats(): Promise<DashboardStats>
}
