@extends('layouts.parentPanel')
@section('profile-header')
<div class="jumbotron profile-header is-darkgreen mb-0 rounded-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 text-center">
                <img src="" class="profile-image rounded-circle mb-3" width="120">
                <h4><strong>Hola {{$apoderado->name}}</strong></h4>
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
                <a class="nav-link active" href="{{route('apoderado.feed')}}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.albums')}}">galerias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.messages')}}">Mensajes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.profile',auth()->user()->id)}}">Perfil</a>
            </li>
        </ul>

    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-items-stretch  bg-light">
            <div class="p-2">
                <strong>d</strong>
            </div>
            <div class="p-2">
                <select class="form-control form-control-sm">
                    <option>Seleccionar otra Fecha</option>
                    <option>2018-04-05</option>
                </select>
            </div>
        </div>
        <ul class="list-group mt-3">
            @foreach($apoderado->students as $child)
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    <img src="{!! url('/static/image/profile/'.$child->image) !!}" class="align-self-center mr-3 rounded-circle mw-25" width="48">
                    <a href="{{route('apoderado.child',$child->id)}}">
                        {{$child->firstname}}
                        {{$child->lastname}}
                    </a>
                </div>
                <div>
                    <span class="badge badge-primary">1</span>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
@section('scripts')
<script>

@if(Auth::user()->unreadMessagesCount() > 0)
toastr.success('Tiene '+{{Auth::user()->unreadMessagesCount()}}+' sin leer ', 'Nuevos Mensajes',
{
"closeButton": false,
"debug": false,
"newestOnTop": true,
"progressBar": true,
"positionClass": "toast-bottom-right",
"preventDuplicates": false,
"onclick": null,
"showDuration": "300",
"hideDuration": "1000",
"timeOut": "5000",
"extendedTimeOut": "1000",
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut"
});
@endif
</script>
@endsection

