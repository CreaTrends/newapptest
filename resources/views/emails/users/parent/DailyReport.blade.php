@component('mail::message')

# Hola Apoderad@

{{$data}}


@component('mail::button', ['url' => route('apoderado.feed')])
Ver Actividades
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent