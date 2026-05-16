export default {
  title: 'Ustawienia profilu',
  subtitle: 'Zarządzaj swoim kontem i preferencjami',

  fields: {
    name: 'Nazwa użytkownika',
    email: 'Email',
  },

  actions: {
    edit: 'Edytuj profil',
    save: 'Zapisz zmiany',
    cancel: 'Anuluj',
    logout: 'Wyloguj',
    logging_out: 'Wylogowywanie...',
  },

  language: {
    title: 'Język',
    label: 'Zmień język',
  },

  security: {
    title: 'Bezpieczeństwo',
    change_password: 'Zmień hasło',
    change_password_description: 'Zaktualizuj swoje hasło',
  },

  password: {
    current: 'Obecne hasło',
    new: 'Nowe hasło',
    confirmation: 'Potwierdź nowe hasło',
    updating: 'Zmienianie hasła...',
    success: 'Hasło zostało zmienione.',
    failed: 'Nie udało się zmienić hasła.',
    throttled: 'Zbyt wiele prób. Spróbuj ponownie później.',

    validation: {
      current_required: 'Obecne hasło jest wymagane.',
      new_min: 'Nowe hasło musi mieć co najmniej 8 znaków.',
      confirmed: 'Potwierdzenie hasła nie jest zgodne.',
    },
  },
}
