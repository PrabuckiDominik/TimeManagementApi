@component('mail::message')
    # {{ __('auth.verify_email_title') }}

    {{ __('auth.verify_email_intro') }}

    @component('mail::button', ['url' => $url])
        {{ __('auth.verify_email_button') }}
    @endcomponent

    {{ __('auth.verify_email_outro') }}

    {{ config('app.name') }}
@endcomponent
