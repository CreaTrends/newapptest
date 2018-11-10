

<div class="d-flex justify-content-end bd-highlight message-box mb-4" id="thread_list_{{ $message->id }}">
    <div class="chat-body w-auto order-xs-2" >
        <div class="chat-content p-3">
            <p class="chat-text text-right">{{ $message->body }}</p>
        </div>
    </div>
    <div class="chat-avatar ml-2 order-xs-1">
        @if(empty($message->user->profile->image))
        <img class="align-self-center mr-0 rounded-circle mw-25"  src="https://ui-avatars.com/api/?background=5A55A3&color=fff&name={{$message->user->profile->first_name}}+{{$message->user->profile->last_name}}" width="48">
        @else
        
        <img class="align-self-center mr-0 rounded-circle mw-25"  src="{!! url('/static/image/profile/'.$message->user->profile->image) !!}" width="48">
        @endif
    </div>
</div>