<?php $prefix = Request::route()->getPrefix(); ?>
<?php 
$get_action = snake_case(class_basename($notification->type));
$the_url = $get_action == 'new_notebook' ? 'apoderado.notes.show':'notes';
$nid = '?nid='.$notification->id;



if(Auth::user()->hasRole('parent')){
$route = ($get_action == 'new_notebook' ? 'child.feed':'apoderado.notes.show') ;
}else {
$route = 'notes.index';
}
?>



<div class="d-flex flex-row mb-0 pt-2 pb-2 notification-item border-bottom {{$notification->read_at ? '':'is-active'}}" id="notification-item" data-notification="{{$notification->id}}" >
  <a href="{{route($route,['id'=>$notification->data['action'],'nid'=>$notification->id])}}" class="d-block notification-link p-2 b  ">
    @if(empty(\App\User::find($notification->data['user_id'])->profile->image))
    <img class="img-fluid border-0 rounded-circle float-left mr-3"  src="{!! url('/static/image/profile/default.jpg') !!}">
    @else
    <img class="img-fluid border-0 rounded-circle float-left mr-3"  src="{!! url('/static/image/profile/'.\App\User::find($notification->data['user_id'])->profile->image) !!}">
    @endif
    <div class="pl-3 pr-2">
      <p class="font-weight-medium mb-1">
        <strong>{{\App\User::find($notification->data['user_id'])->profile->first_name}}</strong>
        @if(snake_case(class_basename($notification->type)) == 'new_notebook')
        Te envió reporte de actividades ! <strong>{{ $notification->data['message'] }}</strong>
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
