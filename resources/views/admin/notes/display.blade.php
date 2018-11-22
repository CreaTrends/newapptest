
{!! $note->body !!}


@hasRoleAndOwns('superadministrator,techer,administartor', $note)
<!--readed by -->
<h6 class="d-flex justify-content-between border-bottom border-gray pb-2 my-3 fw-900">
<strong>Leido por</strong>
</h6>

<div class="d-flex justify-content-start flex-wrap align-items-start">
@foreach($note->readed as $readed)


<h3 class="mb-0 mr-1" style="position: relative;" alt="{{$readed->profile->first_name}} {{$readed->profile->last_name}}" title="{{$readed->profile->first_name}} {{$readed->profile->last_name}}">
@if(empty($readed->profile->image))
<img class="align-self-center mr-0 rounded-circle mw-25"  src="https://ui-avatars.com/api/?background=5A55A3&color=fff&name={{$readed->profile->first_name}}+{{$readed->profile->last_name}}" width="36" alt="{{$readed->profile->first_name}} {{$readed->profile->last_name}}">
@else

<img class="align-self-center mr-0 rounded-circle mw-25"  src="{!! url('/static/image/profile/'.$readed->profile->image) !!}" width="36" alt="{{$readed->profile->first_name}} {{$readed->profile->last_name}}">
@endif
<span class="badge badge-danger is-readed" >
    <i class="fas fa-check"></i>
</span>
</h3>

@endforeach
</div>
@endrole
@if(!empty($note->attached)) 
<h6 class="d-flex justify-content-between border-bottom border-gray pb-2 my-3 fw-900">
<strong>Archivos Adjuntos</strong>
</h6>


<div class="attachments-sections mt-3 ">
    <ul class="d-flex flex-wrap justify-content-start align-items-stretch mt-3 p-0">
        @foreach($note->attached as $images)
        <?php
        
        $rrr = array(
            'docx' => 'fa-file-word',
            'pdf'=>'fa-file-pdf',
            'png'=>'fa-file-image',
            'jpg'=>'fa-file-image',
            'gif'=>'fa-file-image',
        );
        ?>
        
        <li class="d-block col-lg-4 mb-3 mr-3">
            <div class="thumb"><i class="fa {{$rrr[$images['type']]}}"></i></div>
            <div class="details">
                <p class="file-name">{{$images['name']}}</p>
                <div class="buttons">
                    <?php $prefix = Request::route()->getPrefix(); ?>
                    <a href="{{url('/static/uploads/notes/' . $images['encrypt'])}}" class="view" target="_new">Ver</a>
                    <a href="{{url($prefix.'/tools/download',['id'=>$note->id,'file'=>$images['encrypt']])}}" class="download">Descargar</a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endif


