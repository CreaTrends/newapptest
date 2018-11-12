<li class="media px-2 pt-3 border-bottom mb-0 is-message-bubble" id="thread_list_{{ $message->id }}">
    
    @if(empty($message->user->profile->image))
    <img class="align-self-center mr-0 rounded-circle mw-25 mr-3"  src="https://ui-avatars.com/api/?background=5A55A3&color=fff&name={{$message->user->profile->first_name}}+{{$message->user->profile->last_name}}" width="48">
    @else
    
    <img class="align-self-center mr-0 rounded-circle mw-25 mr-3"  src="{!! url('/static/image/profile/'.$message->user->profile->image) !!}" width="48">
    @endif
    <div class="media-body">
        <h6 class="mt-0 mb-1">
        <strong>{{ $message->user->profile->first_name }} </strong> dijo :
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