@extends('layouts.parentPanel')
@section('content')


<div class="row justify-content-center">
    <div class="col-md-8">

        <h6 class="border-bottom border-gray pb-2 my-3 fw-900">Hijos</h6>
        
            @foreach($apoderado->students as $child)
            <!-- child item -->
            <div class="bg-white d-flex justify-content-start align-items-stretch flex-md-row mb-3 shadow-sm widget-feed  border-top border-light  rounded" id="child-{{$child->id}}">
                <div class="mr-2 widget-feed-left">
                    <div class="p-2  text-center widget-info h-100 d-flex justify-content-center flex-column">
                        @if(empty($child->image))
                    <img class="align-self-center mr-0 rounded-circle mw-25"  src="https://ui-avatars.com/api/?background=5A55A3&color=fff&name={{$child->firstname}}+{{$child->lastname}}" width="48">
                    @else
                    
                    <img class="align-self-center mr-0 rounded-circle mw-25"  src="{!! url('/static/image/profile/'.$child->image) !!}" width="48">
                    @endif
                    </div>
                </div>
                <div class="py-2 px-2 widget-feed-right align-self-center">
                    <p class="mb-1 text-primary"><a href="{{route('apoderado.child',$child->id)}}">
                        {{$child->firstname}}
                        {{$child->lastname}}
                    </a></p>
                </div>
            </div>
            @endforeach
        
        
    </div>

</div>
<div class="row justify-content-center d-none">
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <h5 class="border-bottom border-gray pb-2 my-3 fw-900">Recent updates</h5>
        
        <div class="bg-white d-flex justify-content-start align-items-stretch flex-md-row mb-3 shadow-sm widget-feed rounded">
            <div class="mr-2 widget-feed-left">
                <div class="p-2 gradient-lightblue text-center widget-info h-100 d-flex justify-content-center flex-column">
                    <h3 class="mb-0"><i class="fas fa-calendar-alt"></i></h3>
                </div>
            </div>
            <div class="py-2 px-2 widget-feed-right">
                <p class="mb-1 text-primary"><a href="#">Reunion Entrega trabajos de arte</a></p>
            </div>
        </div>
        <div class="bg-white d-flex justify-content-start align-items-stretch flex-md-row mb-3  widget-feed shadow-sm">
            <div class="mr-2 widget-feed-left">
                <div class="p-2 gradient-orange text-center widget-info h-100 d-flex justify-content-center flex-column">
                    <h3 class="mb-0">25</h3>
                    <h6>Sep.</h6>
                </div>
            </div>
            <div class="py-2 px-2 widget-feed-right">
                <p class="mb-1 text-primary"><a href="#">Reunion Entrega trabajos de arte</a></p>
                <span class="badge badge-primary my-0 py-1 px-3 gradient-green fw-300">Requiere confirmacion</span>
                
            </div>
        </div>
        <div class="bg-white d-flex justify-content-start align-items-stretch flex-md-row mb-3 shadow-sm widget-feed rounded">
            <div class="mr-2 widget-feed-left">
                <div class="p-2 gradient-green text-center widget-info h-100 d-flex justify-content-center flex-column">
                    <h3 class="mb-0">25</h3>
                    <h6>Sep.</h6>
                </div>
            </div>
            <div class="py-2 px-2 widget-feed-right">
                <p class="mb-1 text-primary"><a href="#">Reunion Entrega trabajos de arte</a></p>
                <p class="mb-0">Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            </div>
        </div>
        <div class="bg-white d-flex justify-content-start align-items-stretch flex-md-row mb-3 border border-gray widget-feed rounded">
            <div class="mr-2 widget-feed-left">
                <div class="p-2 gradient-darkred text-center widget-info h-100 d-flex justify-content-center flex-column">
                    <h3 class="mb-0">15</h3>
                    <h6>Sep.</h6>
                </div>
            </div>
            <div class="py-2 px-2 widget-feed-right">
                <p class="mb-1 text-primary"><a href="#">Reunion Entrega trabajos de arte</a></p>
                
            </div>
        </div>
        
    </div>
</div>


@endsection
@section('scripts')
<script>

@if(Auth::user()->unreadMessagesCount() > 0)
toastr.success('Tiene '+{{Auth::user()->unreadMessagesCount()}}+' sin leer ', 'Nuevos Mensajes',
{
"closeButton": false,
"debug": false,
"newestOnTop": true,
"progressBar": true,
"positionClass": "toast-bottom-right",
"preventDuplicates": false,
"onclick": null,
"showDuration": "300",
"hideDuration": "1000",
"timeOut": "5000",
"extendedTimeOut": "1000",
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut"
});
@endif
</script>
<script>
  $('.is-dropdown-container').slimscroll({
        height: '180px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });
</script> 
@endsection
