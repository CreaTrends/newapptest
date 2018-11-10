<li class="list-group-item d-flex justify-content-start align-items-center px-1 py-2">
    <label class="form-check-label d-flex w-100" for="recipients-{{$user->id}}">
        <input type="checkbox" class="form-check-input d-none" id="recipients-{{$user->id}}" name="recipients[]" value="{{$user->id}}">
        <div class="avatar" id="uid-{{$user->id}}">
            @if(empty($user->image))
                    <img class="align-self-center mr-0 rounded-circle mw-25"  src="https://ui-avatars.com/api/?background=5A55A3&color=fff&name={{$user->first_name}}+{{$user->last_name}}" width="48">
                    @else
                    
                    <img class="align-self-center mr-0 rounded-circle mw-25"  src="{!! url('/static/image/profile/'.$user->image) !!}" width="48">
                    @endif
        </div>
        <div class="ml-3 name">
            <h6 class="mb-0"><strong>{{$user->firstname}} {{$user->lastname}}</strong></h6>
            <small class="d-block text-muted" style="line-height: 13px;font-size: 11px;">
            @foreach($user->parent as $apoderado)
            {{ $apoderado->profile->first_name }}
            {{ $apoderado->profile->last_name }}
            @if (!$loop->last)
            ,
            @endif
            @endforeach
            </small>
        </div>
    </label>
</li>