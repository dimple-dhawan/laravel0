@component('mail::message')
# New Contact Message

{{ $subject }}

@component('mail::panel')
    {{ $message }}
@endcomponent

@component('mail::button', ['url' => route('contact') ])
Reply to the Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
