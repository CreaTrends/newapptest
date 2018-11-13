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


<a href="{{route($route,['id'=>$notification->data['action'],'nid'=>$notification->id])}}" class="d-block notification-link p-2 border-bottom  {{$notification->read_at ? '':'is-active'}}">
  <div class="d-flex flex-row mb-0 pt-2 pb-2 notification-item" id="notification-item" data-notification="{{$notification->id}}" >
    <img src="{!! url('/static/image/profile/'.App\User::find($notification->data['user_id'])->profile->image) !!}" alt="Notification Image"  class="img-fluid border-0 rounded-circle">
    <div class="pl-3 pr-2">
      <p class="font-weight-medium mb-1">
        <strong>{{App\User::find($notification->data['user_id'])->name}}</strong>
        @if(snake_case(class_basename($notification->type)) == 'new_notebook')
        Te envió reporte de actividades ! <strong>{{ $notification->data['message'] }}</strong>
        @else
        Te envió una nueva circular! <strong>{{ $notification->data['message'] }}
        </strong>
        @endif
      </p>
      <p class="text-muted mb-0 text-small">{{ $notification->created_at->diffForHumans() }}</p>
    </div>
  </div>
</a>
