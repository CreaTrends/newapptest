@extends('layouts.adminDashboard')
@section('content')
@include('partials.messageflash')




<div class="row justify-content-center">

    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <div class="d-flex justify-content-between align-items-stretch mb-4 py-4">
    <div class="">
        <button type="button" class="btn btn-primary custom-btn is-default" data-toggle="modal" data-target="#create-message">Crear Mensaje</a>
        
    </div>

</div>
        <h5 class="d-flex justify-content-between border-bottom border-gray pb-2 my-3 fw-900">
            <strong>Tus Circulares</strong>
            <small>Total : {{$threads->count()}}</small>
        </h5>
        @foreach($threads as $thread)
        <!-- note id {{$thread->id}}-->
        
        <div class="bg-white d-flex justify-content-start align-items-stretch flex-md-row mb-1 border-bottom widget-feed"
            data-id="{{$thread->id}} " data-order="{{$loop->iteration}}">
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
                <a style="color: #5770e4; text-decoration: none; color: inherit !important ;" class="text-red" href="javascript:void();" data-toggle="dropdown" data-target="#view-message-modal">
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
                        <button class="dropdown-item view_message" type="button" data-id="{{$thread->id}}" data-url="{{ route('admin.message.showmodal', $thread->id) }}" id="thread-{{$thread->id}}">Ver</button>
                    </div>

            </div>
        </div>
        @endforeach
        {{ $threads->links('vendor.pagination.bootstrap-4') }}
    </div>


</div>
<hr>
<!-- Mesagge -->
<div id="view-message-modal" class="modal fade view-message-modal" tabindex="-1" role="dialog" data-action="view-message">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    
                        <div id="message-wrapper" class="row message-wrapper">
                            
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- create message -->
<div class="modal fade" tabindex="-1" role="dialog" id="create-message">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crear Nuevo Mensaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('messages.store') }}" method="post">
                {{ method_field('POST') }}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row ">
                            
                            <div class="col-lg-8 w-lg-25">
                                <div class="form-group">
                                    <label for="slug" class="custom-label">Asunto</label>
                                    <input type="text" class="form-control" name="subject" placeholder="Subject"
                                    value="{{ old('subject') }}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Message</label>
                                    <textarea name="message" class="form-control" rows="5">{{ old('message') }}</textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 w-lg-75">
                                <label for="slug" class="custom-label">Selecciona Usuarios</label>
                                <div class="form-group">
                                <select class="form-control" id="filter_users" name="filter_users">
                                  <option>Filtrar por curso</option>
                                  @foreach($cursos as $curso)
                                  <option value="{{$curso->id}}">{{$curso->name}}</option>
                                  @endforeach
                                </select>
                              </div>
                                <ul class="list-group list-group-flush d-none is-list-create" id="user_list">
                                    @each('admin.message.listusers',$user_list,'user')
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Guardar">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).on('change', '#filter_users', function(){

    console.log('cambiamos usuarios');
    $('#user_list').html('').fadeIn();
    $list = $(this);
    $id = $list.val();
    console.log($id);
    console.log('id desde select');
    axios({
                method: "post",
                url: '{{route('admin.messages.filter')}}',
                data: {
                    id: $id,
                },
            }).then(function (response) {
                
        console.log(response.data);

        $('#create-message').find('.is-list-create').fadeIn(400, function(){
    $(this).html(response.data); // this will be animated when load gets completed.
});
    })
    .catch(error => {
    console.log(error.response.data.errors)

    $('.alert-danger').addClass('d-block');
    });

});


    $(document).on('change', 'input[name="recipients[]"]', function(){
        $(this).parent().find('.avatar').toggleClass('active');
     });
$(document).ready(function() {
$(document).on('submit', '#removeParticipant', function(event){
event.preventDefault();
$_form = $(this);
$_id = $_form.find('input[name="recipientuser[]"]').val();
$_thread_id = $_form.find('input[name="thread_id[]"]').val();
console.log($(this).attr('action'));
    axios({
                method: "post",
                url: $(this).attr('action'),
                data: {
                    user_id: $_id,
                    thread_id: $_thread_id,
                },
            }).then(function (response) {
        console.log(response.data);
       
        $(document).find('#recipient-'+$_id).fadeOut().remove();
        $(document).find('[id=rep][value='+$_id+']').remove();

        //$(document).find(':input[value="123"]').remove();
         
          

    })
    .catch(error => {
    console.log(error)

    
    });
});
$(document).on('click', '.view_message', function(){

$_modal = $('.view-message-modal');

$_wrapper = $('#message-wrapper');
$_wrapper.html('').fadeIn();

$_modal.find('.modal-title').text('');


$_modal.modal('show');
console.log($(this).data('id'));
    axios({
                method: "get",
                url: $(this).data('url'),
                data: {
                    id: 17,
                },
            }).then(function (response) {
        console.log(response.data);
        $_modal.find('.modal-title').text(response.data.message).fadeIn();
        $_wrapper.html(response.data.html).fadeIn();
        $('#the_thread').slimscroll({
        height: '300px',
        width:'66.66666667%;',
        color: 'rgba(0,0,0,.8)',
        size: '8px',
        alwaysVisible: true,
        borderRadius: '0',
        railBorderRadius: '0',
        distance: '0px',
        start: 'bottom',
    });
        $('#user_list').addClass('d-block');
        $('#user_list').slimscroll({
        height: '300px',
    });

    })
    .catch(error => {
    console.log(error.response.data.errors)

    $('.alert-danger').addClass('d-block');
    });

});

  $('#user_list').addClass('d-block');
  $('#user_list').slimscroll({
        height: '300px',
        color: 'rgba(0,0,0,.8)',
        size: '5px',
        alwaysVisible: true,
        borderRadius: '0',
        railBorderRadius: '0',
        distance: '0px',
        start: 'top',
    });
  });
    $('#list_user').tokenize2({
    dataSource: function(term, object) {
        var url = "{{ url('/api/parentslist') }}";
        
        axios.get(url, {
            params: {
              keyword: term,
                start: 0,
                api_token: '{{Auth::user()->api_token}}'
            }
          })
          .then(function (response) {
            var $items = [];
                $items =response.data;
                object.trigger('tokenize:dropdown:fill', [$items]);
          })
          .catch(function (error) {
            console.log(error);
          })
          .then(function () {
            // always executed
          }); 
    },
    delimiter: [',', '-']
});
</script>
@endsection

