@component('mail::message')

# Hola Apoderad@


@foreach($data as $items)
@foreach($items->alumno as $alumno)
Conoce Las activides del dia de <br>
{{$alumno->firstname}}
@endforeach

@endforeach
# Enterate de las actividades de tu hij@ aquí

@component('mail::button', ['url' => route('apoderado.feed')])
Ver Actividades
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent