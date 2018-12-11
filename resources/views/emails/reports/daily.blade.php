@component('mail::message')

# Hola {{$user->profile->full_name}}


@component('mail::panel')
Hemos generado una nueva libreta diaria , donde podras conocer toda las actividades de <strong>{{$child->full_name}}</strong>.
@endcomponent

@component('mail::button', ['url' => route('child.feed',$child->id)])
Ver libreta
@endcomponent



Atte,<br>
Jardin Anatolia
@endcomponent

