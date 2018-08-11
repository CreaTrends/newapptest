@extends('layouts.parentPanel')
@section('profile-header')
<style >
    .profile-header {
   background-image: url(https://s3.amazonaws.com/creativetim_bucket/products/17/cover_4_blur.jpg?1431435543); 

    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    padding-top:80px !important;
    padding-bottom:20px;
    vertical-align: bottom;
    position:relative;
    
    border-radius: 0px !important;
}
.profile-header:before{
    content: "";
    top:0;
    left: 0;
    position: absolute;
    width:100%;
    height: 100%;
  background: #f43893;
  opacity: .4;  
}
.profile-header h4 , .profile-header a , .profile-header i {
    color:#fff !important;
}
.profile-header-content {
  display: table;

}
.profile-pic {
  float: none;
  display: table-cell;
}
.profile-pic img {
    width:120px;
}
.profile-about {
  float: none;
  display: table-cell;
  vertical-align: bottom;
  margin-bottom:20px;
}
.profile-image{
    border: 5px #fff solid;
    box-shadow: 1em 1em 2em rgba(0,0,0,.2);
}
@media (min-width: 768px) {
.profile-pic {
    width:120px;
}   
}
@media (min-width: 992px) {
.profile-pic img {
    width:200px;
}
}
</style>

<div class="jumbotron profile-header mb-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 text-center">
                <img src="{!! url('/static/image/profile/'.$alumno_profile->image) !!}" class="profile-image rounded-circle mb-3" width="120">
                <h4><strong>{{$alumno_profile->firstname}} {{$alumno_profile->lastname}}</strong></h4>
                
                
                @foreach($alumno_profile->curso as $alumno)
                
                <span class="badge badge-pill badge-primary is-lightgreen">{{$alumno->name}}</span>
                @endforeach
                
                
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 my-3">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('apoderado.childs')}}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.childs')}}">Hijos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.messages')}}">Mensajes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Perfil</a>
            </li>
        </ul>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-7">
        <a href="{{route('apoderado.feed')}}" class="btn custom-btn btn-link">Volver </a>
        @foreach($notebooks as $date=>$items)
        
        <div class="d-flex justify-content-between align-items-stretch  bg-light">
            <div class="p-2">
                <strong>{{$date}}</strong>
            </div>
            <div class="p-2">
                <select class="form-control form-control-sm">
                    <option>Seleccionar otra Fecha</option>
                    <option>2018-04-05</option>
                </select>

            </div>
        </div>
        
        @foreach($items as $item)
        <?php
        $date_format = \Carbon\Carbon::parse($item->notebook_date)->diffForHumans();
        ?>
        {{$item->id}}
        <!-- estado de animo feed -->
        @if(!empty($item->moods))
        <div class="card my-2 card-feed-student">
            <div class="card-body">
                <div class="media">
                    <i class="icofont icofont-emo-laughing activity-icon is-purple mr-1"></i>
                    <div class="media-body">
                        <h6 class="mt-0 d-flex justify-content-between">
                        <strong>Dia General</strong>
                        <small>{{$date_format}}</small>
                        </h6>
                        <p>
                            <?php $r=str_replace('"', '', $item->moods); ?>
                            Estado de Animo : {{ __('apoderado.moods.'.$r) }}
                        </p>
                        @if(!empty($item->comment))
                        <p>{{$item->comment}}</p>
                        @endif
                        
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- comida del dia feed -->
        @if(!empty($item->foods))
        <div class="card my-2 card-feed-student">
            <div class="card-body">
                <div class="media">
                    <i class="icofont icofont-fast-food activity-icon darkgreen mr-1"></i>
                    <div class="media-body">
                        <h6 class="mt-0 d-flex justify-content-between">
                        <strong>Comida</strong>
                        <small>{{$date_format}}</small>
                        </h6>
                        <p>
                            @foreach($item->foods as $j)
                            {{ __('apoderado.food.'.$j->type) }}
                            {{ __('apoderado.food_amount.'.$j->amount) }}
                            |
                            @endforeach
                            <p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <!-- mudas del dia feed -->
                @if(!empty($item->depositions))
                <div class="card my-2 card-feed-student">
                    <div class="card-body">
                        <div class="media">
                            <i class="icofont icofont-baby-cloth activity-icon is-moods mr-1"></i>
                            <div class="media-body">
                                <h6 class="mt-0 d-flex justify-content-between">
                                <strong>Cambios / Mudas</strong>
                                <small>{{$date_format}}</small>
                                </h6>
                                <p>
                                    @foreach($item->depositions as $j)
                                    {{$j->time}} : {{ __('apoderado.poops.'.$j->type) }} |
                                    @endforeach
                                    <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- siestas  del dia feed -->
                        @if(!empty($item->naps))
                        <div class="card my-2 card-feed-student">
                            <div class="card-body">
                                <div class="media">
                                    <i class="icofont icofont-bed activity-icon is-red mr-1"></i>
                                    <div class="media-body">
                                        <h6 class="mt-0 d-flex justify-content-between">
                                        <strong>Siestas / Descansos</strong>
                                        <small>{{$date_format}}</small>
                                        </h6>
                                        <p>
                                            
                                            @foreach($item->naps as $j)
                                            De :  {{$j->start}} a {{$j->end}}
                                            @endforeach
                                            <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!-- actividades grupales feed -->
                                @if(!empty($item->activities))
                                <div class="card my-2 card-feed-student">
                                    <div class="card-body">
                                        <div class="media">
                                            <i class="icofont icofont-abc activity-icon is-learning mr-1"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 d-flex justify-content-between">
                                                <strong>Actividades Grupales</strong>
                                                <small>{{$date_format}}</small>
                                                </h6>
                                                
                                                @foreach($item->activities as $activitie_of)
                                                @if(!empty($activitie_of))
                                                <p>{{$activitie_of->description}}</p>
                                                @endif
                                                @endforeach
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!-- Galerias imagenes grupales feed -->
                                @if(!empty($item->attachs))
                                @foreach($item->attachs as $images)
                                
                                <div class="card my-2 card-feed-student border-bottom">
                                    <div class="card-body pb-0">
                                        <div class="media">
                                            <i class="icofont icofont-camera mr-1 activity-icon is-default"></i>
                                            <div class="media-body">
                                                <h6 class="mt-0 d-flex justify-content-between">
                                                <strong>Galeria</strong>
                                                <small>{{$date_format}}</small>
                                                </h6>
                                                <p class="font-weight-bold">
                                                    @foreach($item->alumno as $alumno)
                                                    
                                                    {{ __('apoderado.tagged',['name' => $alumno->firstname]) }}
                                                    @endforeach
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($images->file as $image)
                                    <img class="card-img-bottom p-1 mt-2 " src="{{url('static/image/notebook/'.$image)}}" >
                                    @endforeach
                                </div>
                                
                                @endforeach
                                @endif
                                @endforeach
                                @endforeach
                                
                                
                            </div>
                            
                        </div>
                    </div>
@endsection