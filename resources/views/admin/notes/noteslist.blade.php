<!-- Row note -->
<tr id="list_note-{{$note->id}}">
   <td>
        <div class="d-block d-sm-block d-md-flex d-lg-flex d-xl-flex  justify-content-start align-items-center">
            <input type="checkbox" name="checkItem[]" id="checkItem" class="mr-3" value="{{$note->id}}">
            <div class="w-25" style="white-space: nowrap;">
                @if($note->sticky)
                <i class="fas fa-star mr-2" style="color: #fca32a"></i>
                @endif
                <strong>{{$note->author->first_name}} {{$note->author->last_name}}</strong>
            </div>
            <div class="w-auto flex-grow-1">
                <div class="d-flex justify-content-between align-items-center">
                    <a class="flex-column align-items-start" href="{{ route('notes.show', $note->id) }}">
                        <strong class="mb-1" >{{ $note->subject }}</strong>
                    </a>
                    <small class="text-muted d-flex justify-content-between align-items-center">
                    @if($note->attached)
                    <i class="fas fa-paperclip mr-3"></i>
                    @endif
                    <?php
                    $date = Carbon\Carbon::createFromTimeStamp(strtotime($note->created_at));
                    $date_only = $date->formatLocalized('%d %B %Y');
                    ?>
                    {{Carbon\Carbon::parse($note->created_at)->formatLocalized('%d %b %Y')}}
                </span>
            </div>
            <p class="mb-1 d-none d-md-block">{!!str_limit(strip_tags($note->body),100)!!}</p>
            
        </div>
    </td>
    <td>
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
    </td>
</tr>