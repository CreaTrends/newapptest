
<nav class="navbar navbar-expand-md navbar-light bg-light mb-0 bg-white border-bottom shadow-sm user-nav py-3">
  <div class="container">
    <a class="navbar-brand" href="#"><img class="img-fluid" src="http://gogo-react.crealeaf.com/assets/img/logo-black.svg" width="100" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#parentNavbar" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="parentNavbar">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
                <a class="nav-link " href="{{route('apoderado.feed')}}">Inicio</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.messages')}}">Mensajes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.notes')}}">Circulares</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.albums')}}">Galerias</a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{route('apoderado.profile',auth()->user()->id)}}">Perfil</a>
            </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item mr-2 mt-1">
          <a href="{{route('apoderado.messages')}}" class="nav-link is-notify is-active"  id="dropnotifications" role="button">
            <?php
            $count = Auth::user()->unreadMessagesCount();
            $cssClass = $count == 0 ? 'd-none' : 'is-active';
            ?>
            <i class="fas fa-comment-alt {{$count == 0 ? '' : 'is-active'}}"></i>
            <span class="badge badge-danger is-badge-notify is-active {{ $cssClass }}">
              {{Auth::user()->unreadMessagesCount()}}
            </span>
          </a>
        </li>
        <!-- dropdown notification -->

        <li class="nav-item mr-3 mt-1 dropdown">
          <a href="{{ url('/admin')}}" class="nav-link is-notify is-active"  id="dropnotifications" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell is-active"></i>
            <span class="badge badge-danger is-badge-notify {{Auth::user()->unreadNotifications->count() > 0 ? true:'d-none'}} ">
              {{Auth::user()->unreadNotifications->count()}}
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right notificationDropdown p-0" aria-labelledby="dropnotifications" id="notificationDropdown">
            <h6 class="border-bottom border-bottom py-3 px-3 pb-0 mb-0"><strong>Notification</strong></h6>
            <div class="is-dropdown-container">
            @foreach(Auth::user()->notifications as $notification)
            <a href=" {{route('apoderado.notes.show',['id'=>$notification->data['action'],'nid'=>$notification->id])}} " class="d-block notification-link p-2 border-bottom  {{$notification->read_at ? '':'is-active'}}">
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
        <!-- dropdown profile -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if(empty(Auth::user()->profile->image))
            <img class="rounded-circle mr-2"  src="{!! url('/static/image/profile/default.jpg') !!}" width="32">
            @else 
          
            <img class="rounded-circle mr-2"  src="{!! url('/static/image/profile/'.Auth::user()->profile->image) !!}" width="32">
            @endif
            {{ Auth::user()->name }}
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown07">
            <a class="dropdown-item" href="{{route('usuarios.edit',Auth::user()->id)}}">Perfil</a>
            <a href="{{ route('logout') }}" class="dropdown-item"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST"
              style="display: none;">
              {{ csrf_field() }}
            </form>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

