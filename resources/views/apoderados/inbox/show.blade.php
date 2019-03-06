@extends('layouts.parentPanel')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        
        <h5 class="d-flex justify-content-between border-bottom border-gray pb-2 my-3 fw-900">
            <strong>{{$thread->subject}}</strong>
            ({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)
        </h5>
        <div class="messages d-none" id="message-{{$thread->id}}">

            @foreach($thread->messages as $message)

            @if($message->user_id == Auth::id())
            
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
            @else
            <div class="d-flex justify-content-start bd-highlight message-box mb-4" id="thread_list_{{ $message->id }}">
                <div class="chat-avatar mr-2">
                    {{$message->user}}

                    <img class="align-self-center mr-0 rounded-circle mw-25"  src="{!! url('/static/image/profile/defaul.jpg') !!}" width="48">
                </div>
                <div class="chat-body w-auto">
                    <div class="chat-content to-left p-3">
                        <p class="chat-text text-left">{{ $message->body }}</p>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <div class="mt-4">
            <form action="{{ route('apoderados.inbox.update', $thread->id) }}" method="post" id="message-form">
                {{ method_field('put') }}
                {{ csrf_field() }}
                
                <!-- Message Form Input -->
                <div class="form-group">
                    <textarea name="message" class="form-control" rows="3" id="new-message">{{ old('message') }}</textarea>
                </div>
                <!-- Submit Form Input -->
                <div class="form-group">
                    <button type="submit" id="submit-message" class="btn btn-primary custom-btn is-lightblue" disabled>Enviar Mensaje</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
                
<script>

$(document).ready(function() {
    var message_area = $('textarea[name="message"]');
$(document).on('keyup', message_area, function() {
    var message_trim = $('textarea[name="message"]').val();
    if (message_trim != '') {
        $('#submit-message').prop('disabled', false).removeClass('disabled');
    } else {
        $('#submit-message').prop('disabled', true).addClass('disabled');
    }
});
  $('.messages').addClass('d-block');
  $('.messages').slimscroll({
        height: '300px',
        color: 'rgba(0,0,0,.8)',
        size: '5px',
        alwaysVisible: true,
        borderRadius: '0',
        railBorderRadius: '0',
        distance: '0px',
        start: $('#thread_list_'+ {{$thread->getLatestMessageAttribute()->id}}),
    });
  });

$('form').submit(function(e) {
    e.preventDefault();
    var data = $(this).serialize();
    var url = $(this).attr('action');
    var method = $(this).attr('method');
    // clear textarea/ reset form
    $(this).trigger('reset');
    $.ajax({
        method: method,
        data: data,
        url: url,
        success: function(response) {
            var thread = $('#message-' + response.message.thread_id);

            $('body').find(thread).append(response.html);

            console.log(response);
            /*$('.messages').slimscroll({
                start: $('#thread_list_33'),
            });*/
            var scrollTo_int = $('.messages').prop('scrollHeight') + 'px';
            console.log(scrollTo_int)
            $('.messages').slimscroll({
                scrollTo: scrollTo_int,
            }).bind('slimscroll', function(e, pos) {
                console.log(pos);
            });

        },
        error: function(error) {
            console.log(error);
        }
    });
});
            </script>

@endsection