@component('mail::message')
    # {{ __('passwords.reset_title') }}

    {{ __('passwords.reset_intro') }}

    @component('mail::button', ['url' => $url])
        {{ __('passwords.reset_button') }}
    @endcomponent

    {{ __('passwords.reset_outro') }}

    {{ config('app.name') }}
@endcomponent
