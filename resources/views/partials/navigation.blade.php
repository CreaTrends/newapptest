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
            <ul class="navbar-nav">
                @if (Auth::guest())
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Login</a></li>
                <li class="nav-item"><a href="{{ route('register') }}" class="nav-link">Register</a></li>
                @else
                @ability('administrator,owner', 'create-users')
                <li class="nav-item"><a href="{{ route('cursos.index')}}" class="nav-link">Cursos</a></li>
                <li class="nav-item"><a href="{{ route('usuarios.index') }}" class="nav-link">Usuarios</a></li>
                <li class="nav-item"><a href="{{ route('alumnos.index') }}" class="nav-link">Alumnos</a></li>
                <li class="nav-item"><a href="{{ route('usuarios.index') }}" class="nav-link">Apoderados</a></li>
                <li class="nav-item"><a href="{{ route('usuarios.index') }}" class="nav-link">Staff</a></li>
                <li class="nav-item"><a href="{{ route('usuarios.index') }}" class="nav-link">Circulares</a></li>
                <li class="nav-item"><a href="{{ route('settings.index') }}" class="nav-link">Settings</a></li>
                @endrole
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
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
                @endif
            </ul>
        </div>
    </div>
</nav>