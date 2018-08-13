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
                <a class="nav-link" href="{{route('apoderado.albums')}}">galerias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{route('apoderado.messages')}}">Mensajes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.profile',auth()->user()->id)}}">Perfil</a>
            </li>
        </ul>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-7">
       
        <ul class="list-unstyled">
        @foreach($threads as $thread)
        <li class="media p-2 pt-3 border-bottom mb-0" id="thread_list_{{ $thread->id }}">
            <img class="mr-3" src="https://ui-avatars.com/api/?background=49bfbf&color=fff&name={{$thread->creator()->name}}+{{$thread->creator()->lastname}}" alt="Generic placeholder image" width="48">
            <div class="media-body">
                <h6 class="mt-0 mb-1">
                <a style="color: #5770e4" class="text-red" href="{{ route('apoderados.inbox.show', $thread->id) }}">
                    <strong>{{ $thread->subject }}</strong>
                </a>
                <?php
                $isNew = $thread->userUnreadMessagesCount(Auth::id());

                ?>
                @if($isNew > 0)
                <span class="badge badge-danger">
                    (Nuevo)
                </span>
                @endif
                </h6>
                <small><strong>De:</strong> {{ $thread->creator()->name }}</small>
                <p style="line-height: .85rem;">
                    <small style="font-weight: 600;">
                    {{ $thread->latestMessage->body }}
                    </small>
                </p>
            </div>
        </li>
        @endforeach
        </ul>
    </div>
</div>



@endsection