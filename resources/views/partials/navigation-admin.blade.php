<nav class="navbar navbar-expand-md navbar-light bg-light mb-0 bg-white border-bottom shadow-sm user-nav py-3">
  <div class="container">
    <a class="navbar-brand" href="#"><img class="img-fluid" src="http://www.jardinanatolia.cl/wp-content/themes/ultrabootstrap/images/logo_footer.jpg" width="100" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#parentNavbar" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
    <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="parentNavbar">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
                <a class="nav-link " href="{{route('home')}}">Inicio</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="myschool" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Mi Jardín</a>
              <div class="dropdown-menu" aria-labelledby="myschool">
                <a class="dropdown-item" href="{{ route('cursos.index')}}">Cursos</a>
                <a class="dropdown-item" href="{{ route('usuarios.index') }}">Usuarios</a>
                <a class="dropdown-item" href="{{ route('alumnos.index') }}">Alumnos</a>
                <a class="dropdown-item" href="{{ route('usuarios.index') }}">Staff</a>
              </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('notes.index')}}">Circulares</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.messages')}}">Mensajes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('albums.index')}}">Galerias</a>
            </li>
      </ul>


      <ul class="navbar-nav ml-auto">
        <li class="nav-item mr-2 mt-1">
          <a href="{{route('admin.messages')}}" class="nav-link is-notify is-active"  id="dropnotifications" role="button">
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

        @include('partials.notifications')
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

