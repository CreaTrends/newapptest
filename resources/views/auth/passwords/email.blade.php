@extends('layouts.app')

@section('content')
<style>

.form-signin {
  width: 100%;
    padding: 3rem;
    margin: auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
  border: 1px solid #ced4da;
  border-width: 1px !important;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  border: 1px solid #ced4da;
  border-width: 1px !important;
}
.form-signin {
    font-family: 'GT Eesti Display', Helvetica,sans-serif !important;
    background-color: white;
    background-color: white;
    background-size: inherit;
    /* background-attachment: scroll; */
    background-position: center 113%;
    background-repeat: no-repeat;
}
.form-signin > .auth-title {
    color: #22606C !important;
    font-weight: 900;
    letter-spacing: 0rem;
    text-shadow: none;
    font-size: 1.7rem;
    box-shadow: none;
}
</style>
<form class="form-signin text-center align-items-center shadow-sm p-5 col-11 col-md-5 mx-auto" method="POST" method="POST" action="{{ route('password.email') }}">
    {{ csrf_field() }}
    <img class="mb-4" src="{{asset('/images/logo_footer.jpg')}}" alt="" width="150" >
    <h1 class="h3 mb-3 auth-title">Olvidaste tu Contraseña ? </h1>
    <span class="text-muted">Ingresa tu cuenta de correo electrónico , y reiniciaremos tu contraseña.  </span>
    <!-- alert -->
    
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <!-- end alert -->
    <div class="form-group">
        <label for="inputEmail" class="sr-only">E-mail</label>
        <input id="email" type="email" class="form-control my-3" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <span class="help-block">
                {{ $errors->first('email') }}
            </span>
        @endif
    </div>
    <div class="form-group d-flex justify-content-between mb-2">
        
        
    </div>
    <button type="submit" class="btn btn-primary btn-block custom-btn is-lightgreen">
        Enviar Nueva Contraseña
    </button>
    <p class="mt-5 mb-3 text-muted">© Járdin Anatolia / 2017-2018</p>
</form>



@endsection


