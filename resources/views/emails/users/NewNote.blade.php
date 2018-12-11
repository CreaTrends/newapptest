@component('mail::message')
# Hola {{ $user->profile->full_name }} 
hemos generado una nueva circular informativa de nuestro jardín, te invitamos a leer e informarte de toda las novedades de tu hij@ 



@component('mail::button', ['url' => $url])
Leer Circular 
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent