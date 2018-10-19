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
                    <div class="dropdown-menu ">
                        <a class="dropdown-item" href="#">Action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
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
