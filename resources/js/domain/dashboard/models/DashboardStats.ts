export interface DashboardStats {
  total_tasks: number
  completed: number
  in_progress: number
  to_do: number
  overdue: number

  priority_distribution: PriorityDistribution[]
  status_distribution: StatusDistribution[]
  category_distribution: CategoryDistribution[]

  weekly: PeriodStats
  monthly: PeriodStats

  completion_trend: CompletionTrend
  upcoming_deadlines: UpcomingDeadlines
}

export interface PriorityDistribution {
  priority: string
  count: number
}

export interface StatusDistribution {
  status: string
  count: number
}

export interface CategoryDistribution {
  category_id: number | null
  title: string | null
  color: string | null
  count: number
}

export interface PeriodStats {
  period_start: string
  period_end: string

  created_tasks: number
  completed: number
  due_tasks: number
  to_do: number
  in_progress: number
  overdue: number
}

export interface UpcomingDeadlines {
  period_start: string
  period_end: string

  tasks: UpcomingDeadlineTask[]
}

export interface UpcomingDeadlineTask {
  id: number
  name: string
  due_date: string
  is_overdue: boolean

  category: {
    id: number
    title: string
    color: string | null
  } | null
}

export interface CompletionTrend {
  period_start: string
  period_end: string

  days: CompletionTrendDay[]
}

export interface CompletionTrendDay {
  date: string
  count: number
}
