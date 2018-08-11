<div class="media">
    <img src="//www.gravatar.com/avatar/{{ md5($message->user->email) }}?s=64" alt="{{ $message->user->name }}"class="mr-3">
    <div class="media-body">
        <h5 class="media-heading">{{ $message->user->name }}</h5>
        <p>{{ $message->body }}</p>
        <div class="text-muted">
            <small>Posted {{ $message->created_at->diffForHumans() }}</small>
        </div>
    </div>
</div>