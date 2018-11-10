<style>
.navbar-nav .dropdown-menu {
    margin-top: 60px !important;
    width: 325px;
    right: 0;
    left: auto;
    position: absolute !important;
    top: 0;
    padding: 0;
}
.dropdown-menu .header {
    font-size: 13px;
    font-weight: bold;
    width: 100%;
    border-bottom: 1px solid #eee;
    text-align: center;
    padding: 4px 0 6px 0;
}
ul:not(.browser-default)>li {
    list-style-type: none;
}
.navbar .dropdown-menu ul.menu li {
    width: 100%;
}
.dropdown-menu ul.menu li a {
    padding: 11px 11px;
    text-decoration: none;
    -moz-transition: 0.5s;
    -o-transition: 0.5s;
    -webkit-transition: 0.5s;
    transition: 0.5s;
    float: left;
    width: 100%;
}
.dropdown-menu ul.menu .icon-circle {
    width: 36px;
    height: 36px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    -ms-border-radius: 50%;
    border-radius: 50%;
    color: #fff;
    text-align: center;
    display: inline-block;
    float: left;
}
.dropdown-menu {
  -webkit-border-radius: 0;
  -moz-border-radius: 0;
  -ms-border-radius: 0;
  border-radius: 0;
  margin-top: -35px !important;
  margin-left: -15px;
  -webkit-box-shadow: 0 5px 15px 2px rgba(64, 70, 74, 0.2) !important;
  box-shadow: 0 5px 15px 2px rgba(64, 70, 74, 0.2) !important;
  border-radius: 0px;
  border: none;
  padding: 0px; }
  .dropdown-menu .divider {
    margin: 5px 0; }
  .dropdown-menu .header {
    font-size: 13px;
    font-weight: bold;
    width: 100%;
    border-bottom: 1px solid #eee;
    text-align: center;
    padding: 4px 0 6px 0; }
  .dropdown-menu ul.menu {
    padding-left: 0; }
    .dropdown-menu ul.menu.tasks h4 {
      color: #333;
      font-size: 13px;
      margin: 0 0 8px 0; }
      .dropdown-menu ul.menu.tasks h4 small {
        float: right;
        margin-top: 6px; }
    .dropdown-menu ul.menu.tasks .progress {
      height: 7px;
      margin-bottom: 7px; }
    .dropdown-menu ul.menu .icon-circle {
      width: 36px;
      height: 36px;
      -webkit-border-radius: 50%;
      -moz-border-radius: 50%;
      -ms-border-radius: 50%;
      border-radius: 50%;
      color: #fff;
      text-align: center;
      display: inline-block;
      float: left; }
      .dropdown-menu ul.menu .icon-circle i {
        font-size: 18px;
        line-height: 36px !important; }
    .dropdown-menu ul.menu .msg-user {
      width: 44px;
      height: 44px;
      -webkit-border-radius: 50%;
      -moz-border-radius: 50%;
      -ms-border-radius: 50%;
      border-radius: 50%;
      color: #fff;
      text-align: center;
      display: inline-block;
      vertical-align: top;
      float: left; }
      .dropdown-menu ul.menu .msg-user img {
        float: left; }
    .dropdown-menu ul.menu li {
      border-bottom: 1px solid #eee; }
      .dropdown-menu ul.menu li:last-child {
        border-bottom: none; }
      .dropdown-menu ul.menu li a {
        padding: 11px 11px;
        text-decoration: none;
        -moz-transition: 0.5s;
        -o-transition: 0.5s;
        -webkit-transition: 0.5s;
        transition: 0.5s;
        float: left;
        width: 100%; }
        .dropdown-menu ul.menu li a:hover {
          background-color: #e9e9e9; }
    .dropdown-menu ul.menu .menu-info {
      display: inline-block;
      position: relative;
      top: 3px;
      left: 10px;
      float: left;
      width: calc(100% - 45px); }
      .dropdown-menu ul.menu .menu-info h4, .dropdown-menu ul.menu .menu-info .menu-title {
        margin: 0;
        font-size: 13px;
        color: #333;
        float: left;
        width: 100%;
        line-height: 1;
        font-weight: bold; }
      .dropdown-menu ul.menu .menu-info p, .dropdown-menu ul.menu .menu-info .menu-desc {
        margin: 0;
        font-size: 11px;
        color: #aaa;
        float: left;
        width: 100%;
        line-height: 20px; }
        .dropdown-menu ul.menu .menu-info p .material-icons, .dropdown-menu ul.menu .menu-info .menu-desc .material-icons {
          font-size: 13px;
          color: #aaa;
          position: relative;
          top: 3px;
          float: left;
          margin-right: 3px;
          height: 20px; }
  .dropdown-menu .footer a {
    text-align: center;
    border-top: 1px solid #eee;
    padding: 10px 0 5px 0;
    font-size: 13px;
    margin-bottom: -5px;
    color: #ff5e00;
    font-weight: 500; }
    .dropdown-menu .footer a:hover {
      background-color: transparent; }
  .dropdown-menu > li > a {
    padding: 7px 18px;
    color: #666;
    -moz-transition: all 0.5s;
    -o-transition: all 0.5s;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
    font-size: 14px;
    line-height: 25px;
    display: block; }
    .dropdown-menu > li > a:hover {
      background-color: rgba(0, 0, 0, 0.075); }
    .dropdown-menu > li > a i.material-icons {
      float: left;
      margin-right: 7px;
      margin-top: 2px;
      font-size: 20px; }

.dropdown-animated {
  -webkit-animation-duration: .3s !important;
  -moz-animation-duration: .3s !important;
  -o-animation-duration: .3s !important;
  animation-duration: .3s !important; }

.dropdown-menu.pull-right.show {
  position: absolute !important;
  left: auto !important;
  right: 0 !important;
  top: 50px !important;
  transform: none !important; }
</style>
<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top bg-white py-2 bg-white border-bottom shadow-sm user-nav">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
           
    <img class="img-fluid" src="http://www.jardinanatolia.cl/wp-content/themes/ultrabootstrap/images/logo_footer.jpg" width="100" alt="">
    
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-start" id="navbarSupportedContent">
            <ul class="navbar-nav">
                @if (Auth::guest())
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                @else
                @ability('administrator,owner', 'create-users')
                <li class="nav-item"><a href="{{ url('/admin')}}" class="nav-link">Inicio</a></li>
                <li class="nav-item"><a href="{{ route('cursos.index')}}" class="nav-link">Cursos</a></li>
                <li class="nav-item"><a href="{{ route('usuarios.index') }}" class="nav-link">Usuarios</a></li>
                <li class="nav-item"><a href="{{ route('alumnos.index') }}" class="nav-link">Alumnos</a></li>
                <li class="nav-item"><a href="{{ route('albums.index') }}" class="nav-link">Galerias</a></li>
                
                @endrole
                @endif
            </ul>
            @if (!Auth::guest())
            <?php
            $count = Auth::user()->newThreadsCount();
            $notifyActive = $count == 0 ? 'sr-only' : '';
            $notifyClass = $count == 0 ? '' : 'is-active';
            ?>
            <ul class="navbar-nav ml-auto ">
                <li class="nav-item mr-1 dropdown">
                    <a href="#" class="nav-link is-notify is-active" id="dropnotifyMail" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icofont icofont-envelope {{$notifyClass}} "></i>
                        <span class="badge badge-danger is-badge-notify {{$notifyActive}}">
                            {{Auth::user()->unreadMessagesCount()}}
                            
                        </span>
                    </a>
                    <ul class="dropdown-menu pullDown">
                            <li class="header">NOTIFICATIONS</li>
                            <li class="body">
                                <ul class="menu">
                                    <li>
                                        <a href="javascript:void(0);">
                                            <span class="icon-circle is-red">
                                                <i class="icofont icofont-envelope"></i>
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">12 new members joined</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 14 mins ago
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <span class="icon-circle bg-cyan">
                                                <i class="icofont icofont-envelope"></i>
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">4 sales made</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 22 mins ago
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <span class="icon-circle bg-red">
                                                <i class="icofont icofont-envelope"></i>
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">
                                                    <b>Nancy Doe</b> deleted account</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <span class="icon-circle bg-orange">
                                               <i class="icofont icofont-envelope"></i>
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">
                                                    <b>Nancy</b> changed name</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 2 hours ago
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <span class="icon-circle bg-blue-grey">
                                                <i class="icofont icofont-envelope"></i>
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">
                                                    <b>John</b> commented your post</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 4 hours ago
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <span class="icon-circle bg-light-green">
                                                <i class="icofont icofont-envelope"></i>
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">
                                                    <b>John</b> updated status</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> 3 hours ago
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);">
                                            <span class="icon-circle bg-purple">
                                                <i class="icofont icofont-envelope"></i>
                                            </span>
                                            <span class="menu-info">
                                                <span class="menu-title">Settings updated</span>
                                                <span class="menu-desc">
                                                    <i class="material-icons">access_time</i> Yesterday
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="javascript:void(0);">View All Notifications</a>
                            </li>
                        </ul>

                </li>
                <!-- notifications -->
                <li class="nav-item mr-3 dropdown">
                    <a href="{{ url('/admin')}}" class="nav-link is-notify is-active"  id="dropnotifications" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icofont icofont-notification is-active"></i>
                        <span class="badge badge-danger is-badge-notify">
                            {{Auth::user()->notifications->count()}}
                            
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropnotifications">
                        @foreach(Auth::user()->unreadNotifications as $notification)
                        <a class="dropdown-item" href="{{route('message.show',$notification->data['thread']['id'])}}">
                            {{$notification->data['user']['name']}} Te envio un mensaje
                        </a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item dropdown dropdown-menu-right">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle mr-2"  src="{!! url('/static/image/profile/'.Auth::user()->profile->image) !!}" width="32">

                        <span class="user">{{ Auth::user()->name }}</span>
                    </a>
                    @if(Auth::user()->hasRole('teacher|administrator|superadministrator'))
                     <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ url('/admin')}}">
                            Inicio
                        </a>
                        <a class="dropdown-item" href="{{route('usuarios.edit',Auth::user()->id)}}">
                            
                            Perfil
                        </a>
                        <a class="dropdown-item" href="{{route('usuarios.show',Auth::user()->id)}}">
                            
                            Cuenta
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.messages') }}">
                            <span class="badge badge-pill badge-danger" style="float:right">
                            {{Auth::user()->unreadMessagesCount()}}
                            </span>
                            Mensajes <span class="sr-only">(current)</span>
                        </span>
                        </a>
                        <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        
                    </div>
                    
                    @else
                    <li class="nav-item mr-3 dropdown">
                    <a href="{{ url('/admin')}}" class="nav-link is-notify is-active"  id="dropnotifications" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icofont icofont-notification is-active"></i>
                        <span class="badge badge-danger is-badge-notify">
                            {{count(App\User::find(4)->unreadnotifications())}}
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropnotifications">
                        @foreach(App\User::find(1)->unreadNotifications as $notification)
                        <a class="dropdown-item" href="{{route('message.show',$notification->data['thread']['id'])}}">
                            {{$notification->data['user']['name']}} Te envio un mensaje
                        </a>
                        @endforeach
                    </div>
                </li>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('apoderado.feed')}}">
                            Inicio
                        </a>
                        <a class="dropdown-item" href="{{route('apoderado.profile',Auth::user()->id)}}">
                            
                            Perfil
                        </a>
                        <a class="dropdown-item" href="{{route('apoderado.profile',Auth::user()->id)}}">
                            
                            Cuenta
                        </a>
                        <a class="dropdown-item" href="{{ route('apoderado.messages') }}">
                            <span class="badge badge-pill badge-danger" style="float:right">
                            {{Auth::user()->unreadMessagesCount()}}
                            </span>
                            Mensajes <span class="sr-only">(current)</span>
                        </span>
                        </a>
                        <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                            style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        
                    </div>
                    @endif
                    
                </li>
            </ul>
            @endif
        </div>
    </div>
</nav>

