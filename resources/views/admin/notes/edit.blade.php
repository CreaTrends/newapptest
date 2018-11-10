

<form action="{{route('notes.update',$note->id)}}" id="edit-note" enctype="multipart/form-data" class="form" method="POST">
    
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        Por favor Rellena los campos necesarios
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-md-8">
                
                <div class="form-group">
                    <label for="input-subject">Asunto</label>
                    <input type="text" class="form-control" id="input-subject" name="subject" value="{{$note->subject}}">
                </div>
                <div class="form-group">
                    <label for="input-message">Mensaje</label>
                    <textarea class="form-control h-auto is-ckeditor" id="input-message" rows="10" name="message">
                    {!! $note->body !!}
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Archivo Adjunto</label>
                    <div class="custom-file">
                        <input multiple  type="file" name="file_note[]" class="custom-file-input get-input" id="fffsadfasf" lang="es">
                        <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                    </div>
                    <span class="d-none total_files mt-2"></span>
                </div>
                <div class="form-group form-check">
                    <input type="hidden" name="sticky" value="0">
                    {!! Form::checkbox('sticky', 1, ($note->sticky ==1?true:null), ['class' => 'form-check-input']) !!}
                    <label class="form-check-label" for="exampleCheck1">Destacar ?</label>
                </div>
            </div>
            <div class="col-md-4">
                <label for="slug" class="custom-label">Selecciona Usuarios</label>
                <ul class="list-group list-group-flush curso-list d-none" id="tre">
                    <!-- all cursos -->
                    @role('superadministrator')
                    <li class="list-group-item d-flex justify-content-start align-items-center px-1 py-2">
                        <label class="form-check-label d-flex w-100" for="recipients-0">
                            <input type="checkbox" class="form-check-input d-none"
                            id="recipients-0" name="recipients" value="0">
                            <div class="avatar" id="uid-0">
                                <img class="align-self-center mr-0 rounded-circle mw-25" src="https://www.gravatar.com/avatar/{{md5(time())}}?s=48&d=identicon&r=PG" width="48">
                            </div>
                            <div class="ml-3 name">
                                <h6 class="mb-0"><strong>Todo los cursos</strong></h6>
                                <small class="d-block text-muted" style="line-height: 13px;font-size: 11px;">
                                
                                </small>
                            </div>
                        </label>
                    </li>
                    @endrole
                    <!-- start cursos list -->
                    @foreach($cursos as $curso)
                    <li class="list-group-item d-flex justify-content-start align-items-center px-1 py-2">
                        <label class="form-check-label d-flex w-100" for="recipients-{{$curso->id}}">
                            <input type="checkbox" class="form-check-input d-none" id="recipients-{{$curso->id}}" name="recipients[]" value="{{$curso->id}}">
                            <div class="avatar" id="uid-{{$curso->id}}">
                                <img class="align-self-center mr-0 rounded-circle mw-25" src="https://www.gravatar.com/avatar/{{md5($curso->id)}}?s=48&d=identicon&r=PG" width="48">
                            </div>
                            <div class="ml-3 name">
                                <h6 class="mb-0"><strong>{{$curso->name}}</strong></h6>
                                <small class="d-block text-muted" style="line-height: 13px;font-size: 11px;">
                                
                                </small>
                            </div>
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</form>

