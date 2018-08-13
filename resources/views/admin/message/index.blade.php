@extends('layouts.adminDashboard')
@section('content')
@include('partials.messageflash')

<section class="submenu-page navbar-light bg-white mb-3" id="submenu-profile">
    <div class="row">
        <div class="col-md-12 my-3">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('index')}}">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cursos.index')}}">Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  active" href="{{route('admin.messages')}}">Mensajes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('cursos.index')}}">Circulares</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('apoderado.childs')}}">Hijos</a>
                </li>
            </ul>
        </div>
    </div>
</section>
<div class="d-flex justify-content-between align-items-stretch mb-4 py-4">
    <div class="">
        <button type="button" class="btn btn-primary custom-btn is-default" data-toggle="modal" data-target="#create-message">Crear Mensaje</a>
        
    </div>

</div>
{{ $threads->links('vendor.pagination.bootstrap-4') }}
<hr>
<div class="row justify-content-center">
    <div class="col-md-12">
        
        <ul class="list-unstyled">
        @foreach($threads as $thread)
        <li class="media p-2 pt-3 border-bottom mb-0" id="thread_list_{{ $thread->id }}">
            <img class="mr-3" src="https://ui-avatars.com/api/?background=49bfbf&color=fff&name={{$thread->creator()->name}}+{{$thread->creator()->lastname}}" alt="Generic placeholder image" width="48">
            <div class="media-body">
                <h6 class="mt-0 mb-1">
                <a style="color: #5770e4" class="text-red" href="{{ route('message.show', $thread->id) }}">
                    <strong>{{ $thread->subject }}</strong>
                </a>
                <?php
                $isNew = $thread->userUnreadMessagesCount(Auth::id());

                ?>
                @if($isNew > 0)
                <span class="badge badge-danger">
                    (Nuevo)
                </span>
                @endif
                </h6>
                <small><strong>De:</strong> {{ $thread->creator()->name }}</small>
                <p style="line-height: .85rem;">
                    <small style="font-weight: 600;">
                    {{ $thread->latestMessage->body }}
                    </small>
                </p>
            </div>
        </li>
        @endforeach
        </ul>
    </div>
</div>
{{ $threads->links('vendor.pagination.bootstrap-4') }}
<hr>
<!-- Mesagge -->
<div class="modal fade" tabindex="-1" role="dialog" id="create-message">
    <div class="modal-dialog" role="document">
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
                
                <div class="form-group">
                    <label for="firstname" class="custom-label">Para : </label>
                    <select id="list_user" class="list_user" multiple name="recipients[]">
                            </select>
                </div>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Guardar">
            </div></form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
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