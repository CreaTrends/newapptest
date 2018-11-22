
<div class="col-lg-8 ">
    <ul class="list-unstyled" id="the_thread">
        @foreach($thread->messages as $message)
        <li class="media p-2 pt-3 border-bottom mb-0" id="thread_list_{{ $message->id }}">
            
            @if(empty($message->user->profile->image))
                    <img class="align-self-center mr-0 rounded-circle mw-25 mr-3"  src="https://ui-avatars.com/api/?background=5A55A3&color=fff&name={{$message->user->profile->first_name}}+{{$message->user->profile->last_name}}" width="48">
                    @else
                    
                    <img class="align-self-center mr-0 rounded-circle mw-25 mr-3"  src="{!! url('/static/image/profile/'.$message->user->profile->image) !!}" width="48">
                    @endif
            <div class="media-body">
                <h6 class="mt-0 mb-1">
                <strong>{{ $message->user->profile->first_name }} </strong> dijo :
                <div class="text-muted">
                    <small> {{ $message->created_at->diffForHumans() }}</small>
                </div>
                </h6>
                <p style="line-height: .85rem;">
                    <small style="font-weight: 600;">
                    {{ $message->body }}
                    </small>
                </p>
            </div>
        </li>
        @endforeach
    </ul>
    <div class="mt-4">
        <form action="{{ route('admin.inbox.update', $thread->id) }}" method="post" id="message-form">
            {{ method_field('PUT') }}
            {{ csrf_field() }}
            <input type="hidden" name="new_recipientsSelected" >
            <!-- Message Form Input -->
            <div class="form-group">
                <textarea name="message" class="form-control" rows="3" id="new-message">{{ old('message') }}</textarea>
            </div>
            
            <!-- Submit Form Input -->
            <div class="form-group">
                <button type="submit" id="submit-message" class="btn btn-primary custom-btn is-lightblue disabled" disabled>Enviar Mensaje</button>
            </div>
        </form>
    </div>
</div>
<div class="col-lg-4 ">
    <label for="slug" class="custom-label">Participantes</label>
   
    <ul class="list-group list-group-flush" id="user_list">
    @foreach($participants as $user)
        <li class="list-group-item d-flex justify-content-between justify-content-center align-items-stretch px-1 py-2" id="recipient-{{$user->id}}">
            <label class="form-check-label d-flex w-100" for="recipients-{{$user->id}}">
                <input type="checkbox" class="form-check-input d-none" id="recipients-{{$user->id}}" name="recipients[]" value="{{$user->id}}">
                <div class="avatar w-25 mr-3" id="uid-{{$user->id}}">
                    
                    
                    @if(empty($user->profile->image))
                    <img class="align-self-center mr-0 rounded-circle mw-25"  src="https://ui-avatars.com/api/?background=5A55A3&color=fff&name={{$user->profile->first_name}}+{{$user->profile->last_name}}" width="48">
                    @else
                    
                    <img class="align-self-center mr-0 rounded-circle mw-25"  src="{!! url('/static/image/profile/'.$user->profile->image) !!}" width="48">
                    @endif
                    @if($thread->hasParticipant($user->id) > 0)
                    <span class="badge badge-danger is-readed" alt="Circular leida ">
                        <i class="fas fa-check"></i>
                    </span>
                    @endif
                </div>
                <div class=" name w-75">
                    <p class="empty-text"><strong>{{$user->profile->first_name}} {{$user->profile->last_name}}</strong></p>
                    
                </div>
                <div class="w-25">
                    <a href="#" id="removeParticipant" data-affect=""{{$user->id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="is-options-menu">
                        <i class="fas fa-ellipsis-h"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="removeParticipant">
                        <div class="dropdown-divider"></div>
                        <form action="{{route('admin.messages.removeparticpant',$user->id)}}" method="POST" id="removeParticipant">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <input type="hidden" name="recipientuser[]" value="{{$user->id}}">
                            <input type="hidden" name="thread_id[]" value="{{$thread->id}}">


                            <button type="submit" class="dropdown-item">Sacar de conversacion</button>
                        </form>
                    </div>
                </div>
                
            </label>
        </li>

    @endforeach
    </ul>
    
    <!-- target people -->
        <!-- <div class="btn-group w-100 mt-3 text-right justify-content-between align-items-center" role="group" aria-label="Basic example">
            
        <form method="POST" id="addParticipant-form">
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <input type="hidden" name="thread_id[]" value="{{$thread->id}}">
            <button type="button" name="add-partipant" id="addParticipant" class="btn btn-primary custom-btn is-small is-lightgreen">Agregar Apoderados <i class="fas fa-plus"></i></button>
            <button type="submit" name="submit-partipant" id="addParticipant" class="btn btn-primary custom-btn is-small is-lightgreen">listo <i class="fas fa-plus"></i></button>
        </form>
            
        </div> -->
    <!-- end target epople -->
</div>
<div class="col-lg-12 mt-5">
    
</div>
