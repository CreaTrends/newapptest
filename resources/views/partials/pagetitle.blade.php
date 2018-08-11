@role('teacher')
<div class="jumbotron mb-0 is-purple">
    @endrole
@role('superadministrator')
<div class="jumbotron mb-0 is-orange">
    @endrole
    @role('parent')
<div class="jumbotron mb-0 is-lightgreen">
    @endrole
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-8">
                <h1 class="display-5"><strong>@yield('title', 'Welcome') 
                    <!-- {{ isset($alumnos->firstname) ? $alumnos->firstname : '' }}
                    {{ isset($alumnos->lastname) ? $alumnos->lastname : '' }}
                    {{ isset($cursos->name) ? $cursos->name : '' }}
                    {{ isset($user->name) ? $user->name : '' }} -->
                </strong></h1>
                <p>@yield('page-subtitle', 'Welcome')</p>
                
            </div>
            <div class="col-md-4 ml-auto">
                @role('admin')
                <a class="btn btn-primary custom-btn is-purple" href="#" role="button">Importar Usuarios</a>
                <a class="btn btn-primary custom-btn is-default" href="#" role="button">Agregar Usuario</a>
                @endrole
            </div>
        </div>
    </div>
</div>
