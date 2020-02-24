@component('mail::message')
# Training Created

Your training has been created!


@component('mail::panel')
{{ $training->name }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent