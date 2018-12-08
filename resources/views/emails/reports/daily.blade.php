@component('mail::message')

# Hola {{$user->profile->full_name}}

Hemos generado un nuevo reporte diario.

@component('mail::panel') 

#


@foreach($user->students as $student)

{{$student->full_name}}

@endforeach
Puedes encontrar todo los detalles en nuestra aplicacion , haciendo clic en el boton inferior.
@endcomponent



Atte,<br>
Jardin Anatolia
@endcomponent

