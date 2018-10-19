@component('mail::message')

# Hola {{$data->parent}}

Hemos generado una nueva comunicacion diaria.

@component('mail::panel') 
#{{$data->alumno_name}} - {{$data->date}}

Puedes encontrar todo los detalles en nuestra aplicacion , haciendo clic en el boton inferior.
@endcomponent

@component('mail::button', ['url' => route('apoderado.feed')])
Ver Comunicacion diaria
@endcomponent

Atte,<br>
Jardin Anatolia
@endcomponent