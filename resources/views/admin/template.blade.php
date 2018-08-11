@extends('layouts.adminDashboard')
@section('title', 'Bienvenido '.$user->profile->first_name.' '.$user->profile->last_name)
@section('page-subtitle','Tu panel de control')
@section('content')
<section class="submenu-page navbar-light bg-white mb-5" id="submenu-profile">
    <div class="row">
        <div class="col-md-12 my-3">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('index')}}">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('cursos.index')}}">Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('notes.index')}}">Libreta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.messages')}}">Mensajes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="">Circulares</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('apoderado.childs')}}">Mi Perfil</a>
                </li>
            </ul>
        </div>
    </div>
</section>
<div class="row justify-content-center">
    <div class="col-md-12">

        asdfasfsadfasfd
        </div>
    </div>
<span class="badge badge-success">aasda</span>
<div class="h-100 dashboard" id="admin-dashboard">
    <a href="#" class="btn btn-primary custom-btn is-default">Option</a>
    <a href="#" class="btn btn-primary custom-btn is-lightblue">Option</a>
    <a href="#" class="btn btn-primary custom-btn is-green">Option</a>
    <a href="#" class="btn btn-primary custom-btn is-lightgreen">Option</a>
    <a href="#" class="btn btn-primary custom-btn is-darkgreen">Option</a>
    <a href="#" class="btn btn-primary custom-btn is-orange">Option</a>
    <a href="#" class="btn btn-primary custom-btn is-purple">Option</a>
    <a href="#" class="btn btn-primary custom-btn is-darkred">Option</a>
    <a href="#" class="btn btn-primary custom-btn is-pink">Option</a>
    <a href="#" class="btn btn-primary custom-btn is-red">Option</a>
    <a href="#" class="btn btn-primary custom-btn is-yellow">Option</a>
    <a href="#" class="btn custom-btn is-turquoise">Option</a>
    <a href="#" class="btn custom-btn is-outline-default">Option</a>
    <a href="#" class="btn custom-btn is-rounded-default">Guardar Cambios</a>
    <a href="#" class="btn custom-btn is-rounded-pink">Agregar</a>
    <hr>
    <div class="btn-group">
        <button type="button" class="btn btn-danger custom-btn is-dropdown-options">Action</button>
        <button type="button" class="btn btn-danger custom-btn is-dropdown-options dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <a class="dropdown-item" href="#">Something else here</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Separated link</a>
        </div>
    </div>
    <h3>Dashboard</h3>
    <hr>
    <style type="text/css" media="screen">
    
    </style>
    <div class='row'>
        <div class="col-lg-12">
            
            <div class="d-flex flex-row justify-content-between flex-wrap  align-items-end" style="text-align:center;">
                <div class="buton-icon-container p-2">
                    <a  href="#" role="button" class="link-item">
                        <div class="icon-header is-default p-4 mb-3">
                            <i class="icofont icofont-group-students"></i>
                        </div>
                        <p style="text-align:  center; ">
                           <strong> Alumnos</strong>
                        </p>
                    </a>
                </div>
                <div class="buton-icon-container p-2">
                    <a  href="#" role="button" class="link-item">
                        <div class="icon-header is-green p-4 mb-3">
                            <i class="icofont icofont-group-students"></i>
                        </div>
                        <p style="text-align:  center; ">
                            Alumnos
                        </p>
                    </a>
                </div>
                <div class="buton-icon-container p-2">
                    <a  href="#" role="button" class="link-item">
                        <div class="icon-header is-yellow p-4 mb-3">
                            <i class="icofont icofont-group-students"></i>
                        </div>
                        <p style="text-align:  center; ">
                            Padres Apoderados
                        </p>
                    </a>
                </div>
                <div class="buton-icon-container p-2">
                    <a  href="#" role="button" class="link-item">
                        <div class="icon-header p-4 mb-3 is-turquoise">
                            <i class="icofont icofont-ui-messaging"></i>
                        </div>
                        <p style="text-align:  center; ">
                            <a  href="#" role="button">Comunicaciones</a>
                        </p>
                    </a>
                </div>
                <div class="buton-icon-container p-2">
                    <a  href="#" role="button" class="link-item">
                        <div class="icon-header p-4 mb-3 is-red">
                            <i class="icofont icofont-notepad"></i>
                        </div>
                        <p style="text-align:  center; ">
                            <a  href="#" role="button">Actividades</a>
                        </p>
                    </a>
                </div>
                <div class="buton-icon-container p-2 ">
                    <a  href="#" role="button" class="link-item">
                        <div class="icon-header mb-3 is-lightblue">
                            <i class="icofont icofont-ui-camera"></i>
                        </div>
                        <p style="text-align:  center; ">
                            <a  href="#" role="button">Galerias</a>
                        </p>
                    </a>
                </div>
                <div class="buton-icon-container p-2">
                    <a  href="#" role="button" class="link-item">
                        <div class="icon-header mb-3 is-darkgreen">
                            <i class="icofont icofont-ui-calendar"></i>
                        </div>
                        <p style="text-align:  center; ">
                            <a  href="#" role="button">Calendario</a>
                        </p>
                    </a>
                </div>
                <div class="buton-icon-container p-2">
                    <a  href="#" role="button" class="link-item">
                        <div class="icon-header mb-3 is-orange">
                            <i class="icofont icofont-people"></i>
                        </div>
                        <p style="text-align:  center; ">
                            <a  href="#" role="button">Staff / Profesores </a>
                        </p>
                    </a>
                </div>
                <div class="buton-icon-container p-2">
                    <a  href="#" role="button" class="link-item">
                        <div class="icon-header mb-3 is-purple">
                            <i class="icofont icofont-gear"></i>
                        </div>
                        <p style="text-align:  center; ">
                            <a  href="#" role="button">Configuracion</a>
                        </p>
                    </a>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="card card-custom bg-white border-white border-0 mb-5 ">
                <div class=" card-custom-img bg-color-9"></div>
                <div class="d-flex  card-custom-avatar align-self-center">
                    <i class="icofont icofont-abc"></i>
                </div>
                <div class="card-body" style="overflow-y: auto">
                    <h4 class="card-title">Cursos / Niveles</h4>
                    <p class="card-text">Card has minimum height set but will expand if more space is needed for card body content. You can use Bootstrap <a href="https://getbootstrap.com/docs/4.0/components/card/#card-decks" target="_blank">card-decks</a> to align multiple cards nicely in a row.</p>
                </div>
                <div class="card-footer" style="background: inherit; border-color: inherit;">
                    <a href="#" class="btn btn-primary">Option</a>
                    <a href="#" class="btn btn-outline-primary">Other option</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-custom bg-white border-white border-0 mb-5">
                <div class="card-custom-img bg-color-8"></div>
                <div class="d-flex card-custom-avatar align-self-center">
                    <i class="icofont icofont-map-search"></i>
                </div>
                <div class="card-body" style="overflow-y: auto">
                    <h4 class="card-title">Cursos</h4>
                    <p class="card-text">Card has minimum height set but will expand if more space is needed for card body content. You can use Bootstrap <a href="https://getbootstrap.com/docs/4.0/components/card/#card-decks" target="_blank">card-decks</a> to align multiple cards nicely in a row.</p>
                </div>
                <div class="card-footer" style="background: inherit; border-color: inherit;">
                    <a href="#" class="btn btn-primary">Option</a>
                    <a href="#" class="btn btn-outline-primary">Other option</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-custom bg-white border-white border-0 mb-5">
                <div class="card-custom-img bg-color-7"></div>
                <div class="d-flex card-custom-avatar align-self-center">
                    <i class="icofont icofont-map-search"></i>
                </div>
                <div class="card-body" style="overflow-y: auto">
                    <h4 class="card-title">Cursos</h4>
                    <p class="card-text">Card has minimum height set but will expand if more space is needed for card body content. You can use Bootstrap <a href="https://getbootstrap.com/docs/4.0/components/card/#card-decks" target="_blank">card-decks</a> to align multiple cards nicely in a row.</p>
                </div>
                <div class="card-footer" style="background: inherit; border-color: inherit;">
                    <a href="#" class="btn btn-primary">Option</a>
                    <a href="#" class="btn btn-outline-primary">Other option</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-custom bg-white border-white border-0 mb-5">
                <div class="card-custom-img bg-color-6"></div>
                <div class="d-flex card-custom-avatar align-self-center">
                    <i class="icofont icofont-map-search"></i>
                </div>
                <div class="card-body" style="overflow-y: auto">
                    <h4 class="card-title">Cursos</h4>
                    <p class="card-text">Card has minimum height set but will expand if more space is needed for card body content. You can use Bootstrap <a href="https://getbootstrap.com/docs/4.0/components/card/#card-decks" target="_blank">card-decks</a> to align multiple cards nicely in a row.</p>
                </div>
                <div class="card-footer" style="background: inherit; border-color: inherit;">
                    <a href="#" class="btn btn-primary">Option</a>
                    <a href="#" class="btn btn-outline-primary">Other option</a>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-custom bg-white border-white border-0 mb-5">
                <div class="card-custom-img bg-color-5"></div>
                <div class="d-flex card-custom-avatar align-self-center">
                    <i class="icofont icofont-map-search"></i>
                </div>
                <div class="card-body" style="overflow-y: auto">
                    <h4 class="card-title">Cursos</h4>
                    <p class="card-text">Card has minimum height set but will expand if more space is needed for card body content. You can use Bootstrap <a href="https://getbootstrap.com/docs/4.0/components/card/#card-decks" target="_blank">card-decks</a> to align multiple cards nicely in a row.</p>
                </div>
                <div class="card-footer" style="background: inherit; border-color: inherit;">
                    <a href="#" class="btn btn-primary">Option</a>
                    <a href="#" class="btn btn-outline-primary">Other option</a>
                </div>
            </div>
            
        </div>
        <div class="col-sm-6">
            <div class="card card-custom bg-white border-white border-0 mb-5">
                <div class="card-custom-img bg-color-4"></div>
                <div class="d-flex card-custom-avatar align-self-center">
                    <i class="icofont icofont-map-search"></i>
                </div>
                <div class="card-body" style="overflow-y: auto">
                    <h4 class="card-title">Cursos</h4>
                    <p class="card-text">Card has minimum height set but will expand if more space is needed for card body content. You can use Bootstrap <a href="https://getbootstrap.com/docs/4.0/components/card/#card-decks" target="_blank">card-decks</a> to align multiple cards nicely in a row.</p>
                </div>
                <div class="card-footer" style="background: inherit; border-color: inherit;">
                    <a href="#" class="btn btn-primary">Option</a>
                    <a href="#" class="btn btn-outline-primary">Other option</a>
                </div>
            </div>
            
        </div>
        <div class="col-sm-6">
            <div class="card card-custom bg-white border-white border-0 mb-5">
                <div class="card-custom-img bg-color-3"></div>
                <div class="d-flex card-custom-avatar align-self-center">
                    <i class="icofont icofont-map-search"></i>
                </div>
                <div class="card-body" style="overflow-y: auto">
                    <h4 class="card-title">Cursos</h4>
                    <p class="card-text">Card has minimum height set but will expand if more space is needed for card body content. You can use Bootstrap <a href="https://getbootstrap.com/docs/4.0/components/card/#card-decks" target="_blank">card-decks</a> to align multiple cards nicely in a row.</p>
                </div>
                <div class="card-footer" style="background: inherit; border-color: inherit;">
                    <a href="#" class="btn btn-primary">Option</a>
                    <a href="#" class="btn btn-outline-primary">Other option</a>
                </div>
            </div>
            
        </div>
        <div class="col-sm-6">
            <div class="card card-custom bg-white border-white border-0 mb-5">
                <div class="card-custom-img bg-color-1"></div>
                <div class="d-flex card-custom-avatar align-self-center">
                    <i class="icofont icofont-map-search"></i>
                </div>
                <div class="card-body" style="overflow-y: auto">
                    <h4 class="card-title">Cursos</h4>
                    <p class="card-text">Card has minimum height set but will expand if more space is needed for card body content. You can use Bootstrap <a href="https://getbootstrap.com/docs/4.0/components/card/#card-decks" target="_blank">card-decks</a> to align multiple cards nicely in a row.</p>
                </div>
                <div class="card-footer" style="background: inherit; border-color: inherit;">
                    <a href="#" class="btn btn-primary">Option</a>
                    <a href="#" class="btn btn-outline-primary">Other option</a>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection