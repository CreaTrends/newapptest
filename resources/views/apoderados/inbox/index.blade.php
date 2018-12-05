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

<div class="row justify-content-center">

    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 ">
        <a class="btn btn-primary custom-btn is-default my-3" href=" {{route('apoderados.message.create')}} ">Crear Mensaje
            
        </a>
        <h5 class="d-flex justify-content-between border-bottom border-gray pb-2  fw-900">
            <strong>Mensajes</strong>
            <small>Total : {{$threads->count()}}</small>
        </h5>
        @foreach($threads as $thread)
        <!-- note id {{$thread->id}}-->
        
        <div class="bg-white d-flex justify-content-start align-items-stretch flex-md-row mb-1 border-bottom widget-feed"
            data-id="{{$thread->id}} " data-order="{{$loop->iteration}}" id="thread-id-{{$thread->id}}">
            <div class="mr-2 widget-feed-left">
                <div class="p-2 text-center widget-info h-100 d-flex justify-content-center flex-column ">
                    <h3 class="mb-0" style="position: relative;" alt="Circular leida " title="Circular leida">
                    @if(empty($thread->creator()->profile->image))
                    <img class="align-self-center mr-0 rounded-circle mw-25"  src="https://ui-avatars.com/api/?background=5A55A3&color=fff&name={{$thread->creator()->profile->first_name}}+{{$thread->creator()->profile->last_name}}" width="48">
                    @else
                    
                    <img class="align-self-center mr-0 rounded-circle mw-25"  src="{!! url('/static/image/profile/'.$thread->creator()->profile->image) !!}" width="48">
                    @endif
                    <span class="badge badge-danger  {{$thread->userUnreadMessagesCount(Auth::id()) > 0 ? 'd-none':'is-readed'}}" alt="Circular leida ">
                        <i class="fas fa-check"></i>
                    </span>
                    </h3>
                </div>
            </div>
            <div class="p-3 widget-feed-right w-100 mr-auto">
                <a href="{{route('apoderados.inbox.show',$thread->id)}}" style="color: #5770e4; text-decoration: none; color: inherit !important ;" class="text-red view_message"  data-id="{{$thread->id}}" data-url="{{ route('admin.message.showmodal', $thread->id) }}" id="thread-{{$thread->id}}">
                    <h6 class="mt-0 d-flex justify-content-between  fw-600">
                    <strong>
                    {{$thread->subject}}
                    </strong>
                    <small>{{$thread->updated_at->diffforhumans()}}</small>
                    </h6>
                    <p class="mx-2 d-none">
                        <small>
                        enviado por : {{$thread->creator()->profile->first_name}} {{$thread->creator()->profile->last_name}}
                        </small>
                    </p>
                    <p class="fw-300 my-2" style="color: #000; font-size: 13px !important;">
                        {{ str_limit($thread->latestMessage->body, $limit = 80, $end = '...') }}
                    </p>

                    <p class="mb-0">
                        <small>
                        Participantes : {{ $thread->participantsString(Auth::id()) }}
                    </small></p>
                </a>
            </div>
            <div class="p-3  mr-auto">
                <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="is-options-menu">
                    <i class="fas fa-ellipsis-h"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <button class="dropdown-item view_message" type="button" data-id="{{$thread->id}}"
                    data-url="{{ route('admin.message.showmodal', $thread->id) }}" id="thread-{{$thread->id}}">Ver</button>
                    <form action="{{route('apoderado.messages.removeparticpant',Auth::user()->id)}}" method="POST" id="delete-this-message">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="recipientuser[]" value="{{Auth::user()->id}}">
                        <input type="hidden" name="thread_id[]" value="{{$thread->id}}">
                        <button type="submit" class="dropdown-item">Salir de conversacion</button>
                    </form>
                </div>
            </div>
            
        </div>
        @endforeach
        
    </div>
</div>

@endsection
@section('scripts')
<script>
$(document).on('submit', '#delete-this-message', function(event) {
    event.preventDefault();
    $_form = $(this);
    $_id = $_form.find('input[name="recipientuser[]"]').val();
    $_thread_id = $_form.find('input[name="thread_id[]"]').val();
    axios({
            method: "delete",
            url: $(this).attr('action'),
            data: {
                user_id: $_id,
                thread_id: $_thread_id,
            },
        }).then(function(response) {
            $(document).find('#recipient-' + $_id).fadeOut().remove();
            $(document).find('[id=rep][value=' + $_id + ']').remove();
            $('#thread-id-'+$_thread_id).stop().fadeOut(100,function(){
                $(this).remove();
            });
            
        })
        .catch(error => {
            console.log(error)
        });
});



</script>
@endsection