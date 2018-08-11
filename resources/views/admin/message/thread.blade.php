<?php $class = $thread->isUnread(Auth::id()) ? 'alert-info' : ''; ?>

<div class="media alert {{ $class }}" id="thread_list_{{ $thread->id }}">
    <h4 class="media-heading">
        <a href="{{ route('message.show', $thread->id) }}">{{ $thread->subject }}</a>
        ({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)</h4>
    <p>
        {{ $thread->latestMessage->body }}
    </p>
    <p>
        <small><strong>Creator:</strong> {{ $thread->creator()->name }}</small>
    </p>
    <p>
        <small><strong>Participants:</strong> {{ $thread->participantsString(Auth::id()) }}</small>
    </p>
</div>


<div class="media alert {{ $class }}" id="thread_list_{{ $thread->id }}">
  
  <div class="media-body">
    <h5 class="mt-0"><a href="{{ route('message.show', $thread->id) }}">{{ $thread->subject }}</a>
({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)
    </h5>
    {{ $thread->latestMessage->body }}
    <small><strong>Creator:</strong> {{ $thread->creator()->name }}</small>
    <small><strong>Participants:</strong> {{ $thread->participantsString(Auth::id()) }}</small>
  </div>
</div>