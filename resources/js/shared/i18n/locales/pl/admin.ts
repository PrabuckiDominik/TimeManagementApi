export default {
  pagination: {
    previous: 'Poprzednia',
    next: 'Następna',
  },

  users: {
    title: 'Użytkownicy',
    total: '{count} użytkowników',
    empty: 'Nie znaleziono użytkowników',
    edit_title: 'Edytuj użytkownika',
    confirm_delete:
      'Czy na pewno chcesz usunąć tego użytkownika?',

    fields: {
      name: 'Imię',
      email: 'E-mail',
      roles: 'Role',
      actions: 'Akcje',
    },

    actions: {
      edit: 'Edytuj',
      delete: 'Usuń',
      save: 'Zapisz',
      cancel: 'Anuluj',
    },
  },

  activity: {
    title: 'Aktywność systemu',
    total: '{count} wpisów',
    empty: 'Brak wpisów aktywności',

    fields: {
      date: 'Data',
      event: 'Zdarzenie',
      description: 'Opis',
      causer: 'Wykonawca',
      subject: 'Obiekt',
    },
  },
}
