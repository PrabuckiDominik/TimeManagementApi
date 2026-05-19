export interface ActivityLogUser {
  id: number
  name: string
  email: string
}

export interface ActivityLog {
  id: number
  log_name: string
  description: string
  event: string | null
  subject_type: string | null
  subject_id: number | null
  causer_type: string | null
  causer_id: number | null
  causer: ActivityLogUser | null
  properties: Record<string, unknown>
  created_at: string
}
