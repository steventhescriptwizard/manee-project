@component('mail::message')
# Hi {{ $user->name ?? 'Valued Customer' }},

{{ $content }}

@component('mail::button', ['url' => route('home')])
Visit Our Store
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
