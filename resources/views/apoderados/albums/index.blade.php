@extends('layouts.parentPanel')
@section('profile-header')
<div class="jumbotron profile-header is-darkgreen mb-0 rounded-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 text-center">
                <img src="" class="profile-image rounded-circle mb-3" width="120">
                <h4><strong>Hola {{Auth::user()->profile->first_name}}</strong></h4>
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
                <a class="nav-link active" href="{{route('apoderado.albums')}}">galerias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('apoderado.messages')}}">Mensajes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.profile',auth()->user()->id)}}">Perfil</a>
            </li>
        </ul>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-7">
        <ul class="list-group mt-3">
            @foreach($albums as $album)
            <li class="list-group-item d-flex justify-content-between">
                <div>
                    
                    <a href="{{route('apoderado.album',['id'=>$album->album_id,'token'=>$album->album_token])}}">
                        {{$album->album_name }}
                        
                    </a>
                </div>
                <div>
                    <span class="badge badge-primary">{{count($album->photo)}} Imagenes</span>
                </div>
            </li>
            @endforeach
        </ul>
        </div>
    </div>

@endsection
@section('scripts')
@endsection