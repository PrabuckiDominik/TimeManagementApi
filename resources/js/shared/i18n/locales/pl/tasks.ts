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
    search_label: 'Szukaj zadań',
    status_label: 'Filtruj po statusie',
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
    open_menu: 'Otwórz menu zadania',
    mark_as_done: 'Oznacz jako ukończone',
    mark_as_todo: 'Oznacz jako do zrobienia',
  },

  modal: {
    title: 'Nowe zadanie',
    edit_title: 'Edytuj zadanie',
    create: 'Utwórz zadanie',
    update: 'Zaktualizuj zadanie',
    cancel: 'Anuluj',
    close: 'Zamknij',

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

  tags: {
    title: 'Tagi',
    subtitle: 'Zarządzaj tagami przypisywanymi do zadań',
    create: 'Dodaj tag',
    save: 'Zapisz',
    save_short: 'OK',
    cancel: 'Anuluj',
    cancel_short: 'Anuluj',
    edit: 'Edytuj',
    delete: 'Usuń',
    empty: 'Nie masz jeszcze żadnych tagów.',
    name_placeholder: 'Nazwa tagu',
    name_label: 'Nazwa tagu',
    confirm_delete: 'Czy na pewno chcesz usunąć ten tag?',
  },
  confirm_delete: 'Czy na pewno chcesz usunąć to zadanie?',
}
