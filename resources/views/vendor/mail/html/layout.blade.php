<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
</head>
<body style="margin:0; padding:0; background:#f9fafb; font-family:Arial, sans-serif; color:#111827;">
<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f9fafb; padding:32px 16px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:600px;">
                <tr>
                    <td style="padding:24px 0; text-align:center;">
                        <div style="font-size:26px; font-weight:700; color:#111827;">
                            {{ config('app.name') }}
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="background:#ffffff; border:1px solid #e5e7eb; border-radius:24px; padding:32px; box-shadow:0 1px 3px rgba(0,0,0,.08);">
                        {{ $slot }}

                        @isset($subcopy)
                            <div style="margin-top:32px; padding-top:24px; border-top:1px solid #e5e7eb; font-size:13px; color:#4b5563;">
                                {{ $subcopy }}
                            </div>
                        @endisset
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px 0; text-align:center; font-size:13px; color:#4b5563;">
                        © {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
