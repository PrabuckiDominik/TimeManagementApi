export default {
  title: 'Moje zadania',
  total_tasks: '{count} zadań',

  status: {
    all: 'Wszystkie statusy',
    todo: 'Do zrobienia',
    in_progress: 'W trakcie',
    done: 'Ukończone',
  },

  validation: {
    name_required: 'Tytuł zadania jest wymagany.',
    description_max: 'Opis nie może mieć więcej niż 255 znaków.',
    name_max: 'Tytuł zadania nie może mieć więcej niż 255 znaków.',
  },

  filters: {
    search_placeholder: 'Szukaj zadań...',
  },

  sections: {
    todo: 'Do zrobienia',
    in_progress: 'W trakcie',
    done: 'Ukończone',
  },

  empty: 'Brak zadań',

  actions: {
    edit: 'Edytuj',
    delete: 'Usuń',
  },

  modal: {
    title: 'Nowe zadanie',
    edit_title: 'Edytuj zadanie',
    create: 'Utwórz zadanie',
    update: 'Zaktualizuj zadanie',
    cancel: 'Anuluj',

    fields: {
      name: 'Tytuł zadania',
      description: 'Opis',
      priority: 'Priorytet',
      status: 'Status',
      deadline: 'Termin',
      category: 'Kategoria',
      tags: 'Tagi',
    },

    placeholders: {
      name: 'Wprowadź tytuł zadania',
      description: 'Dodaj opis zadania',
      no_category: 'Brak kategorii',
    },
  },

  priority: {
    low: 'Niski',
    medium: 'Średni',
    high: 'Wysoki',
  },

  due: 'Termin',
  completed: 'Ukończono',
}
