@extends('layouts.adminDashboard')
@section('title', 'Circulares')
@section('page-subtitle','Enviar circular')
@section('content')
<section class="submenu-page navbar-light bg-white " id="submenu-profile">
    <div class="row">
        <div class="col-md-12 my-3">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link " href="{{route('index')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cursos.index')}}">Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('notebook.create',$curso->id)}}">Libreta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('notes',$curso->id)}}">Circulares</a>
                </li>
            </ul>
        </div>
    </div>
</section>
<section class="content" id="content-edit">
    <div class="container">
        <div class="row ">
            
            <div class="col-md-12 py-3  align-items-end justify-content-end border-bottom">
                <a href="" class="btn custom-btn is-lightgreen" data-toggle="modal" data-target="#exampleModalCenter">Crear Circular</a>
            </div>
            <div class="col-4 pt-3">
                <div class="d-flex justify-content-end mb-3">
                    Total :({{$notes->firstItem()}} a  {{$notes->lastItem()}}) de {{$notes->total()}}
                </div>
                
                <div class="list-group list-group-flush" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    @foreach($notes as $note)
                    
                    @if($loop->first)
                    <a class="list-group-item list-group-item-action flex-column align-items-start active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-{{$note->id}}" role="tab" aria-controls="v-pills-{{$note->id}}" aria-selected="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1"><strong>{{$note->subject}}</strong>
                            @if($note->sticky)
                            <span class="badge badge-secondary">Importante</span>
                            @endif
                            </h6>
                            <small class="text-muted">{{$note->created_at->diffForHumans()}}</small>
                        </div>
                        <small class="text-muted">{!!str_limit(strip_tags($note->body),30)!!}</small>
                    </a>
                    @else
                    <a class="list-group-item list-group-item-action flex-column align-items-start" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-{{$note->id}}" role="tab" aria-controls="v-pills-{{$note->id}}" aria-selected="true">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1"><strong>{{$note->subject}}</strong>
                            @if($note->sticky)
                            <span class="badge badge-secondary">Importante</span>
                            @endif
                            </h6>
                            <small class="text-muted">{{$note->created_at->diffForHumans()}}</small>
                        </div>
                        <small class="text-muted">{!!str_limit(strip_tags($note->body),30)!!}</small>
                    </a>
                    @endif
                    @endforeach
                    <div class="py-3">{{ $notes->links('vendor.pagination.bootstrap-4') }}</div>
                </div>
            </div>
            <div class="col-8 pt-3 border-left ">
                <div class="tab-content " id="v-pills-tabContent">
                    @foreach($notes as $note)
                    @if($loop->first)
                    <div class="tab-pane fade show active" id="v-pills-{{$note->id}}" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="d-flex justify-content-between border-gray pb-2 mb-1 border-bottom">
                            <h4 class=" ">
                        <strong>{{$note->subject}}</strong>
                        <span class="badge badge-secondary">Importante</span>
                        
                        </h4>
                        <form action="{{route('notes.destroy',$note->id)}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn custom-btn is-red is-small"> <i class="icofont icofont-trash"></i></button>
                        </form>
                    </div>
                        

                        <div class=" d-flex justify-content-between lh-condensed border-bottom">
                            
                            <div class="media py-2 px-1 ">
                                @if($note->user->profile->image)
                                <img class="mr-3 rounded-circle" src="{!! url('/static/image/profile/'.$note->user->profile->image) !!}" alt="Generic placeholder image" width="48px">
                                @else
                                <img class="mr-3 rounded-circle" src="{!! url('/static/image/profile/default.jpg') !!}" alt="Generic placeholder image" width="48px">
                                @endif
                                <div class="media-body">
                                    <h5 class="my-0"><strong>
                                    {{$note->user->profile->first_name}}
                                    {{$note->user->profile->lastname_name}}
                                    </strong></h5>
                                    <small class="text-muted">
                                    @foreach($note->user->roles as $role)
                                    {{$role->name}}
                                    @endforeach
                                    </small>
                                </div>
                            </div>
                            <span class="text-muted">{{$note->created_at->diffForHumans()}}</span>
                        </div>
                        <p class="p-2">{!! $note->body !!}</p>
                        @if($note->attached)
                        <h4 class="border-bottom py-3">Archivo Adjunto <i class="icofont icofont-attachment"></i></h4>
                        <a href="{{route('tools.download',$note->id)}}">{{$note->attached}}</a>
                        @endif
                    </div>
                    @else
                    <div class="tab-pane fade" id="v-pills-{{$note->id}}" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <div class="d-flex justify-content-between border-gray pb-2 mb-1 border-bottom">
                            <h4 class=" ">
                        <strong>{{$note->subject}}</strong>
                        <span class="badge badge-secondary">Importante</span>
                        
                        </h4>
                        <form action="{{route('notes.destroy',$note->id)}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn custom-btn is-red is-small"> <i class="icofont icofont-trash"></i></button>
                        </form>
                        </div>
                        <div class=" d-flex justify-content-between lh-condensed border-bottom">
                            
                            <div class="media py-2 px-1 ">
                                <img class="mr-3 rounded-circle" src="{!! url('/static/image/profile/default.jpg') !!}" alt="Generic placeholder image" width="48px">
                                <div class="media-body">
                                    <h5 class="my-0"><strong>
                                    {{$note->user->profile->first_name}}
                                    {{$note->user->profile->lastname_name}}
                                    </strong></h5>
                                    <small class="text-muted">
                                    @foreach($note->user->roles as $role)
                                    {{$role->name}}
                                    @endforeach
                                    </small>
                                </div>
                            </div>
                            <span class="text-muted">{{$note->created_at->diffForHumans()}}</span>
                        </div>
                        <p class="p-2">{{$note->body}}</p>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Enviar nueva circular a : {{$curso->name}}</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('notes.store')}}" id="createInfoForm" enctype="multipart/form-data" class="form" method="POST">
                <div class="modal-body">
                    {{ method_field('POST') }}
                    {{csrf_field()}}
                    
                    <input type="hidden" name="curso_id" value="{{$curso->id}}">
                    
                    <div class="form-group">
                        <label for="input-subject">Asunto</label>
                        <input type="text" class="form-control" id="input-subject" name="subject">
                    </div>
                    <div class="form-group">
                        <label for="input-message">Mensaje</label>
                        <textarea class="form-control h-auto" id="input-message" rows="10" name="message"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Archivo Adjunto</label>
                        <div class="custom-file">
                            <input type="file" name="file_note" class="custom-file-input" id="customFileLang" lang="es">
                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                        </div>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" name="sticky" value="1" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Destacar ?</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary custom-btn is-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary custom-btn is-green">Enviar Circular</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    @if (session('info'))
            toastr.info("{{ session('info') }}");
   @endif
</script>
@endsection