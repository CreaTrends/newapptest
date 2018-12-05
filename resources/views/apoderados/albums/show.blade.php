@extends('layouts.parentPanel')
@section('profile-header')
<div class="jumbotron profile-header is-darkgreen mb-0 rounded-0">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 text-center">
                <img src="" class="profile-image rounded-circle mb-3" width="120">
                <h4><strong>Hola {{Auth::user()->profile->first_name}}</strong></h4>
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
                <a class="nav-link " href="{{route('apoderado.feed')}}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{route('apoderado.albums')}}">galerias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('apoderado.messages')}}">Mensajes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.profile',auth()->user()->id)}}">Perfil</a>
            </li>
        </ul>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-md-7">
        <a href="{{route('apoderado.albums')}}" class="my-2 btn custom-btn btn-link">Volver </a>
        <div class="card my-2 card-feed-student border-bottom">
            <div class="card-body pb-0">
                <div class="media">
                    <i class="icofont icofont-camera mr-1 activity-icon is-default"></i>
                    <div class="media-body">
                        <h6 class="mt-0 d-flex justify-content-between">
                        <strong>Galeria : {{ $albums->album_name}}</strong>
                        <small>{{$albums->created_at->diffForHumans()}}</small>
                        </h6>
                        @if(!empty($albums->album_description))
                        <p class="font-weight-bold">
                            {{$albums->album_description}}
                        </p>
                        @endif
                    </div>
                </div>
                <div class="row">
                    @foreach($albums->photo as $image)
                    <div class="col-4 col-md-4 p-0">
                        <a data-fancybox="images" href="{{ url($image->photo_path.$image->photo_name) }}">
                            <img class="card-img-bottom p-1 mt-2 " src="{{url($image->photo_path.'thumb_'.$image->photo_name)}}" >
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
$('[data-fancybox="gallery"]').fancybox({
    selector : '[data-fancybox="images"]',
    buttons: [
        //"zoom",
        //"share",
        //"slideShow",
        //"fullScreen",
        //"download",
        //"thumbs",
        "close"
    ]
});
</script>

@endsection