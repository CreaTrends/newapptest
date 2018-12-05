<?php $prefix = Request::route()->getPrefix(); ?>
<?php 
$get_action = snake_case(class_basename($notification->type));
$the_url = $get_action == 'new_notebook' ? 'apoderado.notes.show':'notes';
$nid = '?nid='.$notification->id;



if(Auth::user()->hasRole('parent')){
$route = ($get_action == 'new_notebook' ? 'child.feed': $get_action == 'new_album_notification' ? 'apoderado.album' : 'apoderado.notes.show') ;
}else {
$route = 'notes.index';
}
?>



<div class="d-flex flex-row mb-0 pt-2 pb-2 notification-item border-bottom {{$notification->read_at ? '':'is-active'}}" id="notification-item" data-notification="{{$notification->id}}" >
  <a href="{{url($notification->data['action'].'?nid='.$notification->id)}}" class="d-flex justify-content-between p-2 ">

    
      @if(empty($notification->data['notify-icon']))
      <div class="is-default text-center  mr-1 activity-icon  mr-2 align-items-center">
        <i class="icofont icon"></i>
      </div>
      @else
      <div class="{{$notification->data['notify-bg']}} text-center  mr-1 activity-icon  mr-2 align-items-center">
        <i class="{{$notification->data['notify-icon']}}"></i>
      </div>
      @endif
    
    <div class="pl-3 pr-2">
      <p class="font-weight-medium mb-1">
        <strong>{{\App\User::find($notification->data['user_id'])->profile->first_name}}</strong>
        @if(snake_case(class_basename($notification->type)) == 'new_notebook')
        Te envió un reporte diario ! <strong>{{ $notification->data['message'] }}</strong>
        @elseif(snake_case(class_basename($notification->type)) == 'new_album_notification')
        Ingreso una nueva galeria ! <strong>{{ $notification->data['message'] }}</strong>
        @else
        Te envió una nueva circular! <strong>{{ $notification->data['message'] }}
        </strong>
        @endif
      </p>
      <p class="text-muted mb-0 text-small">{{ $notification->created_at->diffForHumans() }}</p>
    </div>
  </a>
  <div class="pl-3 pr-2 align-self-center">
    <a
      class="close remove_field align-self-center"
      
      data-alert-id="{{$notification->id}}"
      data-user="{{auth()->user()->id}}"
      data-action="notification-hide"
      data-url='{{route('tools.deletenotification')}}'
      role="button"
      style="font-size:1.3rem;">
      <span aria-hidden="true">&times;</span>
    </a>
  </div>
</div>
