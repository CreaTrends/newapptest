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
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <h5 class="d-flex justify-content-between border-bottom border-gray pb-2 my-3 fw-900">
            <strong>Tus Circulares</strong>
            <small>Total : {{$notes->count()}}</small>
        </h5>
        @foreach($notes as $note)
        <!-- note id -->
        <div class="bg-white d-flex justify-content-start align-items-stretch flex-md-row mb-3 shadow-sm widget-feed rounded" data-id=" {{$note->id}} " data-order="{{$loop->iteration}}">
            <div class="mr-2 widget-feed-left">
                <div class="p-2 text-center widget-info h-100 d-flex justify-content-center flex-column ">
                    <h3 class="mb-0" style="position: relative;" alt="Circular leida " title="Circular leida">
                    <img src="{!! url('/static/image/profile/'.$note->user->profile->image) !!}" class="align-self-center mr-0 rounded-circle mw-25" width="48">
                    <span class="badge badge-danger  {{$note->readed ? 'is-readed':'d-none'}}" alt="Circular leida ">
                        <i class="fas fa-check"></i>
                    </span>
                    </h3>
                </div>
            </div>
            <div class="p-3 widget-feed-right w-100 mr-auto">
                <a style="color: #5770e4; text-decoration: none; color: inherit !important ;" class="text-red" href="{{ route('apoderado.notes.show', $note->id) }}">
                    <h6 class="mt-0 d-flex justify-content-between  fw-600">
                    <strong>
                    {{$note->subject}}
                    @if($note->sticky)
                    <i class="fas fa-star mr-2" style="color: #fca32a"></i>
                    @endif
                    </strong>
                    <small>{{$note->created_at->diffforhumans()}}</small>
                    </h6>
                    <p class="mb-0">
                        <small>
                        enviado por : {{$note->user->profile->first_name}} {{$note->user->profile->last_name}}
                        </small>
                    </p>
                </a>

            </div>
            <div class="p-3  mr-auto">
                <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="is-options-menu">
                    <i class="fas fa-ellipsis-h"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <button class="dropdown-item btn-action" type="button" data-url="{{ route('apoderado.notes.display',$note->id)}}" id="btnAction1">Ver</button>
                    <div class="dropdown-divider"></div>
                    <form action="{{route('notes.deleteuser',$note->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button class="dropdown-item">Eliminar</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal -->
<!-- view / edit note -->

<div id="mf-edit-modal" class="modal fade is-modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>

$('.btn-action').click(function(){
    var id = $(this).data("url");
    var url = $(this).data("url");
    console.log(url);
    $.ajax({
        type: "GET",
        url: url,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
        success: function(response) {
            
            // get the ajax response data
            var $_modal_target = $('#mf-edit-modal');
           console.log(response);
            // update modal content
            $_modal_target.find('.modal-body').html(response.message);
            $_modal_target.find('.modal-title').text(response.title);
            // show modal
            $_modal_target.modal('show');
            
        },
        error:function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
});
</script>
@endsection