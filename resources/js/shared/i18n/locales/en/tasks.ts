export default {
  title: 'My Tasks',
  total_tasks: '{count} tasks',

  status: {
    all: 'All statuses',
    todo: 'To Do',
    in_progress: 'In Progress',
    done: 'Done',
  },

  validation: {
    name_required: 'Task title is required.',
    description_max: 'Description cannot exceed 255 characters.',
    name_max: 'Task title cannot exceed 255 characters.',
  },

  filters: {
    search_placeholder: 'Search tasks...',
  },

  sections: {
    todo: 'To Do',
    in_progress: 'In Progress',
    done: 'Done',
  },

  empty: 'No tasks found',

  actions: {
    edit: 'Edit',
    delete: 'Delete',
  },

  modal: {
    title: 'New Task',
    edit_title: 'Edit Task',
    create: 'Create Task',
    update: 'Update Task',
    cancel: 'Cancel',

    fields: {
      name: 'Task title',
      description: 'Description',
      priority: 'Priority',
      status: 'Status',
      deadline: 'Deadline',
      category: 'Category',
      tags: 'Tags',
    },

    placeholders: {
      name: 'Enter task title',
      description: 'Add task description',
      no_category: 'No category',
    },
  },

  priority: {
    low: 'Low',
    medium: 'Medium',
    high: 'High',
  },

  due: 'Due',
  completed: 'Completed',

  tags: {
    title: 'Tags',
    subtitle: 'Manage tags assigned to tasks',
    create: 'Add tag',
    save: 'Save',
    save_short: 'OK',
    cancel: 'Cancel',
    cancel_short: 'Cancel',
    edit: 'Edit',
    delete: 'Delete',
    empty: 'You do not have any tags yet.',
    name_placeholder: 'Tag name',
  },
}
