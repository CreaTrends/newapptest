<!-- Row note -->
<div class="Table-row {{$note->sticky>0 ? 'sticky-row':''}}" id="note-row-{{$note->id}}">
    <div class="Table-row-item Table-row-small align-self-center" data-header="Id">
        <label class="control control--checkbox">
            <input type="checkbox" name="selected[]" value="{{$note->id}}"/>
            <div class="control__indicator"></div>
        </label>
    </div>
    <div class="Table-row-item u-Flex-grow3" data-header="Header2">
        
        <a href="" class="">
            <h4 class="item-title"> {{$note->user->profile->first_name}} {{$note->user->profile->last_name}}</h4>
        </a>
        
    </div>
    <div class="Table-row-item u-Flex-grow5" data-header="Header3">
        
        <div class="d-block">
            <a href="javascript:void(0);" class="view_note d-block" data-id="{{$note->id}}" data-url="{{ route('notes.display',$note->id)}}" id="note-{{$note->id}}">{{ $note->subject }}</a>
            <small class="text-muted d-flex justify-content-between align-items-center">
                {!!str_limit(strip_tags($note->body),100)!!}
            </small>
        </div>
    </div>
    <div class="Table-row-item u-Flex-grow2" data-header="Header3">
        {{Carbon\Carbon::parse($note->created_at)->formatLocalized('%d %b %Y')}}
    </div>
    <div class="Table-row-item u-Flex-grow1">
        @if($note->sticky)
        <i class="fas fa-star mr-2 align-self-center" style="color: #fca32a"></i>
        @endif
    </div>
    <div class="Table-row-item Table-row-small">
        <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="is-options-menu">
            <i class="fas fa-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item view_note" type="button" data-id="{{$note->id}}" data-url="{{ route('notes.display',$note->id)}}" id="note-{{$note->id}}">Ver</button>
            <button class="dropdown-item edit_note" type="button" data-id="{{$note->id}}" data-url="{{ route('notes.edit',$note->id)}}" id="note-{{$note->id}}" data-urledit="{{ route('notes.update',$note->id)}}">Editar</button>
            <div class="dropdown-divider"></div>
            <form action="{{route('notes.destroy',$note->id)}}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="dropdown-item">Eliminar</button>
            </form>
        </div>
    </div>
</div>
