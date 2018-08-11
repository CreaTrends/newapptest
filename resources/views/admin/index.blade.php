@extends('layouts.adminDashboard')
@section('title', 'Bienvenido '.$user->profile->first_name.' '.$user->profile->last_name)
@section('page-subtitle','Tu panel de control')
@section('content')

<div class="row justify-content-center mb-5 py-5">
    <div class="col-md-10">
        <h3 class="mb-3 py-3 border-bottom">Tu Panel del Control</h3>
        <div class="card-deck mb-3 text-center">
            @if(!empty($data['cursos']))
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="my-0 font-weight-normal"><strong>Cursos Inscritos</strong></h5>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">
                    <strong>{{$data['cursos']}}</strong>
                    </h1>
                    
                    <button type="button" class="btn custom-btn is-lightgreen">Agregar Curso</button>
                </div>
            </div>
            @endif
            @if(!empty($data['alumnos']))
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="my-0 font-weight-normal"><strong>Alumnos Inscritos</strong></h5>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">
                    <strong>{{$data['alumnos']}}</strong>
                    </h1>
                    <button type="button" class="btn custom-btn is-lightgreen">Agregar Alumno</button>
                </div>
            </div>
            @endif
            @if(!empty($data['parents']))
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="my-0 font-weight-normal"><strong>Apoderados </strong></h5>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">
                    <strong>{{$data['parents']}}</strong>
                    </h1>
                    <button type="button" class="btn custom-btn is-lightgreen">Agregar Apoderado</button>
                </div>
                
            </div>
            @endif
            
            
        </div>
        <div class="card-deck mb-3 text-center">
            @if(!empty($data['teacher']))
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="my-0 font-weight-normal"><strong>Profesores Inscritos </strong></h5>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">
                    <strong>{{$data['teacher']}}</strong>
                    </h1>
                    <button type="button" class="btn custom-btn is-lightgreen">Agregar Profesor</button>
                </div>
                
            </div>
            @endif
            <!-- @if(!empty($data['notebooks']))
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="my-0 font-weight-normal"><strong>Comunicaciones Enviadas</strong></h5>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">
                    <strong>{{$data['notebooks']}}</strong>
                    </h1>
                    <button type="button" class="btn custom-btn is-lightgreen">Agregar Apoderado</button>
                </div>
                
            </div>
            @endif -->
            @if(!empty($data['birthdays']))
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="my-0 font-weight-normal"><strong>Cumpleaños del Mes</strong></h5>
                </div>
                <ul class="list-group list-group-flush">
                        @foreach($data['birthdays'] as $childs)
                        <li class="list-group-item">
                            {{$childs->firstname}} en 
                            <?php
                            $birthday = Carbon\Carbon::parse($childs->birthday);
                            $dd = Carbon\Carbon::now()->diffInDays($birthday->year(date('Y')), false);

                            ?>
                            
                            {{$dd}}
                            dias
                        </li>
                        @endforeach
                    </ul>
                
            </div>
            @endif
        </div>
    </div>
</div>

@endsection