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
        
        <ul class="list-unstyled">
            @foreach($notes as $note)
            <li class="media p-2 pt-3 border-bottom mb-0" id="notes_list_{{ $note->id }}">
                <img class="mr-3" 
                src="https://ui-avatars.com/api/?background=49bfbf&color=fff&name={{$note->sender_name}}+{{$note->sender_lastname}}" alt="Generic placeholder image" width="48">
            
            <div class="media-body">
                <h6 class="mt-0 mb-1">
                <a style="color: #5770e4" class="text-red" href="{{ route('apoderado.notes.show', $note->id) }}">
                    <strong>{{$note->subject}}</strong>
                </a>
                <small>
                @if($note->sticky)
                    <span class="badge badge-secondary">Importante</span>
                @endif
                </small>
                </h6>
                <small><strong>De:</strong> {{ $note->sender_name }}</small>
                <p style="line-height: .85rem;">
                    <small style="font-weight: 600;">
                    {!!str_limit(strip_tags($note->body),30)!!}
                    </small>
                </p>
            </div>
            </li>
            @endforeach
            </ul>
            {{ $notes->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>

@endsection