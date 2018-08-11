@extends('layouts.adminDashboard')
@section('title', isset($user->name) ? $user->name : '')
@section('page-subtitle','Bienvenido a tu panel de control')
@section('content')
<section class="submenu-page navbar-light bg-white mb-5" id="submenu-profile">
    <div class="row">
    <div class="col-md-12 my-3">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('index')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('teacher.cursos')}}">Tus Cursos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('cursos.notes',1)}}">Comunicacion Diaria</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('admin.messages')}}">Mensajes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('cursos.notes',1)}}">Circulares</a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="{{route('apoderado.childs')}}">Hijos</a>
            </li>
        </ul>

    </div>
</div>
</section>
    @foreach($cursos as $curso)
        @foreach($curso->teacher_course as $curso)
            <h1>{{$curso->name}} ( {{$curso->alumnos_list->count()}} )</h1>
            @foreach($curso->alumnos_list as $alumnos)
            <h4>{{$alumnos->firstname}}</h4>
            @endforeach
        @endforeach
    @endforeach
@endsection