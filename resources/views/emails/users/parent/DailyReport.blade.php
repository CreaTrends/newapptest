@component('mail::message')
# Hola 
# Bienvenido a jardin anatolia
{{$data->data}}


Tus Datos de acceso <br>
<b>Usuario</b> :  <br>
<b>password </b>: <br>



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