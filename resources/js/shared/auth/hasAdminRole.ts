import {authStorage} from '@/shared/auth/authStorage'

export const hasAdminRole = (): boolean => {
  const roles = authStorage.getUser()?.roles ?? []

  return roles.includes('administrator')
    || roles.includes('superAdministrator')
}
