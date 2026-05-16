<?php

declare(strict_types=1);

return [
    "required" => "Pole :attribute jest wymagane.",
    "email" => "Pole :attribute musi być poprawnym adresem email.",
    "confirmed" => "Potwierdzenie pola :attribute nie zgadza się.",
    "current_password" => "Podane hasło jest nieprawidłowe.",
    "unique" => "Pole :attribute jest już zajęte.",
    "string" => "Pole :attribute musi być tekstem.",

    "min" => [
        "string" => "Pole :attribute musi mieć co najmniej :min znaków.",
    ],

    "max" => [
        "string" => "Pole :attribute nie może mieć więcej niż :max znaków.",
    ],

    "attributes" => [
        "email" => "email",
        "password" => "hasło",
        "password_confirmation" => "potwierdzenie hasła",

        "current_password" => "obecne hasło",
        "new_password" => "nowe hasło",
        "new_password_confirmation" => "potwierdzenie nowego hasła",

        "name" => "nazwa",
        "title" => "nazwa",
        "color" => "kolor",
        "description" => "opis",
    ],
];
