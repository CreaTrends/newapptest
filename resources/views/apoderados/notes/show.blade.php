@extends('layouts.parentPanel')
@section('profile-header')
<div class="jumbotron profile-header is-darkgreen mb-0 rounded-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 text-center">
                <img src="" class="profile-image rounded-circle mb-3" width="120">
                <h4><strong>Hola </strong></h4>
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
                <a class="nav-link active" href="{{route('apoderado.notes')}}">Circulares</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.messages')}}">Mensajes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.profile',$parent->id)}}">Perfil</a>
            </li>
        </ul>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-7">
        <a href="{{route('apoderado.notes')}}" class="my-2 btn custom-btn btn-link">Volver </a>
        <ul class="list-unstyled mb-5">
            @foreach($notes as $note)
                <li class="media p-2 pt-3 border-bottom mb-0" id="note_detail_{{ $note->id }}">
                    <img class="mr-3" 
                    src="https://ui-avatars.com/api/?background=49bfbf&color=fff&name={{$note->user->name}}" alt="Generic placeholder image" width="48">
                    <div class="media-body">
                        <h6 class="mt-0 mb-1">
                            <strong>{{$note->subject}}</strong>
                        <div class="text-muted">
                            <small> de :{{$note->user->name}} | {{ $note->created_at->diffForHumans() }}</small>
                        </div>
                        </h6>
                        <p>
                           {!! $note->body !!}
                        </p>
                        @if($note->attached)
                        <h5 class="py-3">Archivo Adjunto <i class="icofont icofont-attachment"></i></h5>
                        <a href="{{route('tools.download',$note->id)}}">Descargar</a>
                        @endif
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection