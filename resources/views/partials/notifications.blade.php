<li class="nav-item mr-3 mt-1 dropdown">
          <a href="{{ url('/admin')}}" class="nav-link is-notify is-active"  id="dropnotifications" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell is-active"></i>
            <span class="badge badge-danger is-badge-notify">
              {{Auth::user()->notifications->count()}}
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right notificationDropdown p-0" aria-labelledby="dropnotifications" id="notificationDropdown">
            <h6 class="border-bottom border-bottom py-3 px-3 pb-0 mb-0"><strong>Notification</strong></h6>
            <div class="is-dropdown-container">

            @foreach(Auth::user()->unreadNotifications as $notification)
            <a href=" {{route('apoderado.notes.show',$notification->data['action'])}} " class="d-block notification-link p-2 border-bottom is-active ">
              <div class="d-flex flex-row mb-0 pt-2 pb-2 notification-item" id="notification-item" data-notification="{{$notification->id}}" data-order="{{$loop->iteration}}">
                  <img src="{!! url('/static/image/profile/'.App\User::find($notification->data['user_id'])->profile->image) !!}" alt="Notification Image"  class="img-fluid border-0 rounded-circle">
                  <div class="pl-3 pr-2">
                    
                    <p class="font-weight-medium mb-1"><strong>{{App\User::find($notification->data['user_id'])->name}}</strong> just sent a new circular! <strong>{{ $notification->data['message'] }}</strong></p>
                    <p class="text-muted mb-0 text-small">{{ $notification->created_at->diffForHumans() }}</p>
                  </div>
              </div>
            </a>
            @endforeach

            </div>
            <div class="dropdown-divider"></div>
              <a class="dropdown-item text-center" href="#">Marcar como leidas</a>
          </div>
        </li>