
<nav class="navbar navbar-expand-md navbar-light bg-light mb-0 bg-white border-bottom shadow-sm user-nav py-3">
  <div class="container">
    <a class="navbar-toggler navbar-toggler top-mobile-buttons" href="{{ route('apoderado.feed') }}" role="button">
    <i class="icofont icofont-simple-left"></i>
    </a>
    <a class="navbar-brand" href="#"><img class="img-fluid" src="{{ asset('/images/logo_footer.jpg') }}" width="100" alt=""></a>
    <button class="navbar-toggler top-mobile-buttons" type="button" data-toggle="collapse" data-target="#parentNavbar" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
    <i class="icofont icofont-navigation-menu"></i>
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
            <span class="badge badge-danger massage-notification is-badge-notify is-active {{ $cssClass }}">
              {{Auth::user()->unreadMessagesCount()}}
            </span>
          </a>
        </li>
        <!-- dropdown notification -->

        <li class="nav-item mr-3 mt-1 dropdown">
          <a href="{{ url('/parent')}}" class="nav-link is-notify is-active"  id="dropnotifications" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icofont icofont-alarm is-active"></i>
            <span class="badge badge-danger notification is-badge-notify {{Auth::user()->unreadNotifications->count() > 0 ? true:'d-none'}} ">
              {{Auth::user()->unreadNotifications->count()}}
            </span>
          </a>
          <div class="dropdown-menu dropdown-menu-right notificationDropdown p-0" aria-labelledby="dropnotifications" id="notificationDropdown">
            <h6 class="border-bottom border-bottom py-3 px-3 pb-0 mb-0"><strong>Notification</strong></h6>
            <div class="is-dropdown-container" id="drop-notification-list">

            @each('partials.notification-list', Auth::user()->notifications, 'notification', 'partials.no-notifications')
            

            </div>
              <a href="javascript:void(0);"class="dropdown-item text-center" id="markAllAsRead" role="button" data-url='{{route('tools.readallnotification')}}'><h6><strong>Marcar como leidas</strong></h6></a>
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
            <a class="dropdown-item" href="{{route('apoderado.profile',Auth::user()->id)}}">Perfil</a>
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

