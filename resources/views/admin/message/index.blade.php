@extends('layouts.adminDashboard')
@section('content')
@include('partials.messageflash')
<div class="d-flex justify-content-between border-bottom py-2">
    <h4>Mensajes</h4>
    <a href="{{route('messages.create')}}" class="btn btn-primary custom-btn is-default">Crear Mensaje</a>
</div>
<div class="row">
    <div class="col-md-4 my-3 py-3">
        <div class="list-group" >
            @foreach($threads as $thread)
            <?php $class = $thread->isUnread(Auth::id()) ? 'bg-light' : ''; ?>
            <a class="list-group-item list-group-item-action flex-column align-items-start {{ $class }}" id="v-pills-thread-tab" data-toggle="pill" href="#thread_list_{{ $thread->id }}" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1"><strong>{{ $thread->subject }}</strong></h6>
                    <small>{{ $thread->getLatestMessageAttribute()->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-1">
                    {!!str_limit(strip_tags($thread->latestMessage->body),30)!!}
                </p>
                <small>{{ $thread->participantsString(Auth::id()) }}</small>
                
            </a>
            @endforeach
        </div>
    </div>
    <div class="col-md-8 my-3 py-3">
        <div class="tab-content" id="v-pills-tabContent">
            @foreach($threads as $thread)
            <div class="tab-pane fade" id="thread_list_{{ $thread->id }}" role="tabpanel" aria-labelledby="v-pills-thread-tab">
                <ul class="list-unstyled border-bottom" id="thread_list_{{ $thread->id }}">
                    
                    @each('admin.message.messages', $thread->messages, 'message')
                    {{$thread->markAsRead(Auth::id())}}
                </ul>
                
                <form action="{{ route('messages.update', $thread->id) }}" method="post">
                    {{ method_field('put') }}
                    {{ csrf_field() }}
                    
                    <!-- Message Form Input -->
                    <div class="form-group">
                        <textarea name="message" class="form-control">{{ old('message') }}</textarea>
                    </div>
                    <!-- Submit Form Input -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary custom-btn is-green">Submit</button>
                    </div>
                </form>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop