@extends('layouts.parentPanel')
@section('profile-header')
<style >
    .profile-header {
   background-image: url({{asset('assets/core/title-img.jpg')}}); 

    background-size: cover;
    padding-top:20px !important;
    padding-bottom:20px;
    vertical-align: bottom;
    position:relative;
        background-position: center 0px;
    
    border-radius: 0px !important;
}
.profile-header:before{
    content: "";
    top:0;
    left: 0;
    position: absolute;
    width:100%;
    height: 100%;
  background: #f5fbfb;
  opacity: .6;  
}
.profile-header h4 , .profile-header a , .profile-header i {
    color:#32355d !important;
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
    box-shadow: 0em 0em 0.8em rgba(0,0,0,.1);
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

<div class="jumbotron profile-header mb-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 text-center">
                <img src="{!! url('/static/image/profile/'.$alumno_profile->image) !!}" class="profile-image rounded-circle mb-3" width="80">
                <h4><strong>{{$alumno_profile->firstname}} {{$alumno_profile->lastname}}</strong></h4>                
                @foreach($alumno_profile->curso as $alumno)            
                <span class="badge badge-pill badge-primary is-lightgreen px-3 is-green fw-300">{{$alumno->name}}</span>
                @endforeach
            </div>
            
        </div>
    </div>
</div>
@endsection
@section('content')
<!-- <div class="row justify-content-center">
    
    <div class="col-md-8 text-center">
        <div class="  toolbar-access d-flex justify-content-center my-3">
            <div class="card card-body w-75 border-0 mr-1">
                    
                    <div class="">
                        <i class="fas fa-comment"></i>
                        <p class="card-title mb-0">Mensajes</p>
                    </div>
                </div>
                <div class="card card-body w-75 border-0  mr-1 pb-0 pt-2 px-2">
                    
                    <div class="">
                        <i class="fas fa-images ml-auto"></i>
                        <p class="card-title mb-0">Galerias</p>
                    </div>
                </div>
                <div class="card card-body w-75 border-0 ml-auto">
                    
                    <div class="">
                        <i class="fas fa-user-circle ml-auto"></i>
                        <p class="card-title mb-0">Perfil</p>
                    </div>
                </div>
        </div>
    </div>

</div> -->
<div class="row justify-content-center">
    <div class="col-md-7 col-lg-8 border-bottom border-gray mb-4">
        
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-between">
                @if(!empty($previousnotebook))
                <?php
                $prev_date_link = \Carbon\Carbon::parse($previousnotebook)->toFormattedDateString();
                $prev_date = \Carbon\Carbon::parse($previousnotebook)->format('Y-m-d');
                ?>
                <li class="page-item">
                    <a class="page-link" href="{{route('child.feed',['id'=>$alumno_profile->id,'date'=>$prev_date])}}" aria-label="Previous">
                        <i class="fas fa-angle-double-left"></i>
                    </a>
                </li>
                @else
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1" aria-label="Previous">
                    <i class="fas fa-angle-double-left"></i>
                  </a>
                </li>
                @endif
                <!-- current date -->
                <li class="page-item">
                  <a class="page-link is-green" href="{{route('child.feed',['id'=>$alumno_profile->id,'date'=>''])}}" tabindex="-1">
                   Hoy  {{\Carbon\Carbon::now()->format('l j  , Y ')}}</a>
                </li>
                <!-- end current date -->
                @if(!empty($nextnotebook))
                <?php
                \Carbon\Carbon::setLocale('es');
                $next_date_link = \Carbon\Carbon::parse($nextnotebook)->toFormattedDateString();
                $next_date = \Carbon\Carbon::parse($nextnotebook)->format('Y-m-d');
                ?>
                <li class="page-item">
                    <a class="page-link" href="{{route('child.feed',['id'=>$alumno_profile->id,'date'=>$next_date])}}">
                    <i class="fas fa-angle-double-right"></i>
                    </a>
                </li>
                @else
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1">
                    <i class="fas fa-angle-double-right"></i>
                  </a>
                </li>
                @endif
            </ul>
        </nav>

        <!-- Start feed section -->
        
        <!-- end feed section -->
        
    </div>
    


    @if(!empty($notebooks))
        <div class="col-md-7 col-lg-8" id="daily-feed">
            <!-- title -->
            
            @foreach($notebooks as $key => $feeds)
                <div class="d-flex justify-content-start mb-4">
                    <span class="badge badge-primary my-0 py-2 px-3 is-lightblue  fw-300 time_line-date" >
                        {{\Carbon\Carbon::parse($key)->toFormattedDateString()}}
                    </span>
                </div>
                @foreach($feeds as $feed)
                    <!-- data feed {{$loop->iteration}} -->
                    @if(!empty($feed->data))
                    
                        <div class="card card-body mb-0 border-top-0 border-left-0 border-right-0 rounded-0 border-bottom p-2 pt-4 widget-feed"> 
                            <div class="media widget-feed-right">
                                <div class="p-3 mr-3 {{$feed->css['bg-color']}} text-center widget-info h-100 d-flex justify-content-center flex-column" style="border-radius: 100%;width: 60px;height: 60px !important;">
                                    <h2 class="mb-0"><i class="{{$feed->css['icon']}}"></i></h2>
                                </div>
                                <div class="media-body ">
                                    <h6 class="mt-0 d-flex justify-content-between ">
                                    <strong>{{ __('feed.type.'.$feed->activity_type,['attribute' => $feed->name]) }}</strong>
                                    <small>{{$feed->date}}</small>
                                    </h6>
                                    <p>
                                    @if(is_array($feed->data))
                                        @foreach($feed->data as $value)
                                            @foreach($value as $a=>$b)
                                                @if($feed->activity_type == 'food')
                                                    {{ __('feed.'.$feed->activity_type.'.'.$b,[
                                                    'attribute' => $b
                                                    ]) }}
                                                @else
                                                    {{ __('feed.'.$feed->activity_type.'.'.$a,[
                                                    'attribute' => $b,
                                                    'name' => $feed->name
                                                    ]) }}
                                                @endif
                                            @endforeach
                                        <br>
                                        @endforeach
                                    @else
                                        @if($feed->activity_type == 'mood')
                                            
                                            {{ __('feed.'.$feed->activity_type.'.'.$feed->info) }}
                                        @else
                                            {{$feed->info}}
                                            @endif
                                    @endif
                                    </p>
                                    
                                </div>
                            </div>

                            @if(!empty($feed->attached))
                            <div class="row">
                             @foreach($feed->attached as $attached)
                             
                                 <div class="col-6 col-md-3">
                                    <a  data-fancybox="images" href="{{url('static/uploads/notebook/'.$attached)}}">
                                   <img class="img-fluid m-0 my-2" src="{{url('static/uploads/notebook/'.$attached)}}" alt="Card image cap">
                                   </a>   
                                 </div>
                             
                             @endforeach
                             </div>
                                    @endif  
                        </div>
                        

                    @endif
                
                @endforeach
            @endforeach
            

   @else
        <div class="col-lg-8 text-center mh-100 ">
            <div class="d-flex justify-content-center align-items-stretch text-center mb-4">
                <div class="icon-empty gradient-orange empty_state">
                    <i class="fas fa-inbox"></i>
                </div>
            </div>
            
            <h4><strong>No tienes reportes</strong></h4>
            <p>al parecer no tienes reportes del dia de hoy , puedes revisar dias anteriores de tu hij@ </p>
        </div>
@endif  
</div>
@endsection
@section('scripts')
<script>
   
$('[data-fancybox="images"]').fancybox({
    buttons : [
    
    'close'
  ]
});
    $(function() {
        $('#date_range').on('change',function (e) {
            var val = $(this).attr('name');
            var filter = 'date';
            var request = $(e.target).find("option:selected").val();
            var URL = filter+'='+request;
            var action = $(this).data( 'action' );
            if(filter == 'reset'){
                window.location = action;
            }else {
                window.location = action + '?'+URL;
            }
            
        });
    });
</script>


@endsection