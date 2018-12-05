@extends('layouts.parentPanel')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        

        <h5 class="d-flex justify-content-between border-bottom border-gray pb-2 my-3 fw-900">
            <strong>Enviar Mensaje</strong>
        </h5>
        <div class="messages d-none" id="message-new">

            
        </div>
        <div class="mt-4">
            <form action="{{ route('apoderado.messages.store') }}" method="post" id="message-form">
                {{ method_field('post') }}
                {{ csrf_field() }}
                
                <!-- Message Form Input -->
                
                <div class="chat_recipients">
                    @foreach($recipients as $destinator)
                    <input type="hidden" name="teacher_recipients[]" value="{{$destinator->id}}">
                    <div class="badge badge-success text-white fw-300 px-2 py-1">
                        {{$destinator->profile->first_name}}
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label class="control-label">Asunto</label>
                    <input type="text" class="form-control" name="subject" placeholder="Asunto"
                       value="{{ old('subject') }}">
                </div>
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

            $url = '{{url('apoderado/message/')}}/'+response.message.thread_id;
            
            window.history.pushState({page: "another"}, "another page", $url);

            $('.messages').addClass('d-block');
            $('.messages').attr('id','message-'+response.message.thread_id).append(response.html)
            $('.alert-primary').remove();
            $('input[name="subject"]').remove();
            $('input[name="teacher_recipients"]').remove();
            $('.chat_recipients').remove();
            $(this).attr('put');
            $url = '{{url('apoderado/message/')}}/'+response.message.thread_id;
            $('#message-form').attr('action', $url);
            $('input[name="_method"]').val('PUT');

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