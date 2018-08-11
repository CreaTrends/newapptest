@extends('layouts.adminDashboard')
@section('title', 'Ver Galeria')
@section('page-subtitle','Maneja tus galerias de imagenes')
@section('content')
<div class="d-flex justify-content-between align-items-stretch mb-4 py-4">
    <div class="">
        <a href="{{route('albums.index')}}" class="btn custom-btn is-link"><< Volver </a>
    </div>
</div>
<!-- Page Content -->
    <div class="container">

      <h1 class="my-4 text-center text-lg-left">{{$albums->album_name}}</h1>

      <div class="row text-center text-lg-left">
        @foreach($albums->photo as $photo)
        <div class="col-lg-3 col-md-4 col-xs-6">
          
            <a  data-fancybox="images" href="{{ url($photo->photo_path.$photo->photo_name) }}">
            <img class="img-fluid img-thumbnail" 
            src="{{ url($photo->photo_path.'thumb_'.$photo->photo_name) }}" alt="">
          </a>
        </div>
        @endforeach
      </div>

    </div>
    <!-- /.container -->
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