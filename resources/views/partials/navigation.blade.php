<nav class="navbar navbar-expand-md navbar-light bg-light fixed-top bg-white py-2">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <h4 style="font-size: 1.5rem;
    font-weight: 900;
    color: #2865d6;">Agenda Jardin anatolia</h4>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @if (Auth::guest())
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                @else
                @ability('administrator,owner', 'create-users')
                <li class="nav-item"><a href="{{ route('cursos.index')}}" class="nav-link">Cursos</a></li>
                <li class="nav-item"><a href="{{ route('usuarios.index') }}" class="nav-link">Usuarios</a></li>
                <li class="nav-item"><a href="{{ route('alumnos.index') }}" class="nav-link">Alumnos</a></li>
                <li class="nav-item"><a href="{{ route('albums.index') }}" class="nav-link">Galerias</a></li>
                
                @endrole
                @endif
            </ul>
            @if (!Auth::guest())
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown dropdown-menu-right">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="rounded-circle"  src="{!! url('/static/image/profile/'.Auth::user()->profile->image) !!}" width="32">

                        <span class="user">{{ Auth::user()->name }}</span>
                    </a>
                    @if(Auth::user()->hasRole('teacher|administrator|superadministrator'))
                     <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
                    <?php $route = 'parent';?>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
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
