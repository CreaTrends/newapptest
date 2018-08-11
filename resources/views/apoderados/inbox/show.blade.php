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
<div class="row justify-content-center">
    <div class="col-md-7">
        <a href="{{route('apoderado.messages')}}" class="my-2 btn custom-btn btn-link">Volver </a>
        <ul class="list-unstyled">
            @foreach($thread->messages as $message)
                <li class="media p-2 pt-3 border-bottom mb-0" id="thread_list_{{ $message->id }}">
                    <img class="mr-3" src="https://ui-avatars.com/api/?background=49bfbf&color=fff&name={{$message->user->name}}" alt="Generic placeholder image" width="48">
                    <div class="media-body">
                        <h6 class="mt-0 mb-1">
                        <strong>{{ $message->user->name }}</strong> dijo :
                        <div class="text-muted">
                            <small> {{ $message->created_at->diffForHumans() }}</small>
                        </div>
                        </h6>
                        <p style="line-height: .85rem;">
                            <small style="font-weight: 600;">
                            {{ $message->body }}
                            </small>
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
        <div>
            <form action="{{ route('messages.update', $thread->id) }}" method="post">
    {{ method_field('put') }}
    {{ csrf_field() }}
        
    <!-- Message Form Input -->
    <div class="form-group">
        <textarea name="message" class="form-control" rows="3">{{ old('message') }}</textarea>
    </div>

    <!-- Submit Form Input -->
    <div class="form-group">
        <button type="submit" class="btn btn-primary custom-btn is-lightblue">Enviar Mensaje</button>
    </div>
</form>
        </div>
    </div>
</div>
@endsection