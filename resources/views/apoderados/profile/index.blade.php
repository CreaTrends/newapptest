@extends('layouts.parentPanel')
@section('profile-header')
<div class="jumbotron profile-header is-darkgreen mb-0 rounded-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 text-center">
                <img src="" class="profile-image rounded-circle mb-3" width="120">
                <h4><strong>Hola {{$userprofile->name}}</strong></h4>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 my-3">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link " href="{{route('apoderado.feed')}}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.albums')}}">galerias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('apoderado.messages')}}">Mensajes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{route('apoderado.profile',auth()->user()->id)}}">Perfil</a>
            </li>
        </ul>
    </div>
</div>

<div class="row justify-content-center mb-5">
    <div class="col-md-7">
        <form action="{{route('apoderado.profile.update',$userprofile->id)}}"  enctype="multipart/form-data" class="form" method="POST" >
            {{method_field('PUT')}}
            {{csrf_field()}}
            
                <h5><strong>Datos Personales</strong></h5>
            <div class="form-group">
                <label for="">Nombre completo</label>
                <input type="text" name="firstname" class="form-control" value="{{$userprofile->profile->first_name}}">
            </div>
            <div class="form-group">
                <label for="">Apellido completo</label>
                <input type="text" name="lastname" class="form-control" value="{{$userprofile->profile->last_name}}">
            </div>
            <div class="form-group">
                <label for="">Fecha de nacimiento</label>
                <input type="text" id="birthday" name="birthday" class="form-control" value="{{$userprofile->profile->birthday}}">
            </div>
            
            <h5><strong>Datos de Contacto</strong></h5>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" name="email" class="form-control" value="{{$userprofile->profile->email}}">
            </div>
            <div class="form-group">
                <label for="">Dirección</label>
                <input type="text" name="address" class="form-control" value="{{$userprofile->profile->address}}">
            </div>
            <div class="form-group">
                <label for="">Teléfono</label>
                <input type="text" name="phone" class="form-control" value="{{$userprofile->profile->telephone}}">
            </div>
            <input type="submit" class="btn custom-btn is-lightgreen" value="Guardar">
            <a href="{{route('apoderado.feed')}}" class="btn custom-btn is-red">Cancelar</a>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $('#birthday').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd'
            });
</script>
<script>
    @if (session('info'))
            toastr.info("{{ session('info') }}");
   @endif
</script>
@endsection
