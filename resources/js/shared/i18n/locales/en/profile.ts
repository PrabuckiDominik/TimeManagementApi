export default {
  title: 'Profile Settings',
  subtitle: 'Manage your account and preferences',

  fields: {
    name: 'Username',
    email: 'Email',
  },

  actions: {
    edit: 'Edit Profile',
    save: 'Save Changes',
    cancel: 'Cancel',
    logout: 'Sign Out',
    logging_out: 'Signing out...',
  },

  language: {
    title: 'Language',
    label: 'Change Language',
  },

  security: {
    title: 'Security',
    change_password: 'Change Password',
    change_password_description: 'Update your password',
  },

  password: {
    current: 'Current password',
    new: 'New password',
    confirmation: 'Confirm new password',
    updating: 'Updating password...',
    success: 'Password has been changed.',
    failed: 'Failed to change password.',
    throttled: 'Too many attempts. Try again later.',

    validation: {
      current_required: 'Current password is required.',
      new_min: 'New password must be at least 8 characters.',
      confirmed: 'Password confirmation does not match.',
    },
  },
}
