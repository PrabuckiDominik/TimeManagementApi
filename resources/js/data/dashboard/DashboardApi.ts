import { httpClient } from "@/data/http/httpClient"

export const DashboardApi = {
  async get() {
    return await httpClient.get("/api/dashboard")
  },
}
