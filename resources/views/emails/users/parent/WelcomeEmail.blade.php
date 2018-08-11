@component('mail::message')
# Hola {{ $user->name }} 
# Bienvenido a jardin anatolia



Tus Datos de acceso <br>
<b>Usuario</b> : {{ $user->email}} <br>
<b>password </b>: {{$user->password}}<br>



# Que Puedo hacer con mi cuenta ?
- Comunicaciones Diarias
- Actividades Diarias
- Comunicate con cada educadora
- Ver los avances de tu hij@

@component('mail::button', ['url' => route('login')])
Ingresar a tu cuenta
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
