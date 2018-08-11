@extends('layouts.adminDashboard')
@section('content')
<div class="row">
    <div class="col-md-12 my-3">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link " href="{{route('index')}}">Noticias / Comunicaciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{route('apoderado.childs')}}">Hijos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Reportes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Perfil</a>
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table  table-bordered my-4">
            <thead class="thead-light">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Reporte</th>
                    <th scope="col">Curso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($childs as $child)
                <tr>
                    <th scope="row">
                        <img class="align-self-center mr-3 rounded-circle mw-25" src="{!! url('/static/image/profile/'.$child->image) !!}" alt="Generic placeholder image" style="width: 64px;">
                    </th>
                    <td>{{$child->firstname}} {{$child->lastname}} </td>
                    <td><a href="#" data-toggle="modal" data-target="#exampleModal">Ver Reporte Diario</a></td>
                    <td>Medio Menor</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reporte Diario de tu Hijo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-outline-secondary my-4 card-feed-student">
                    
                    <div class="card-body">
                        
                        <div class="media mb-3 ">
                            <i class="icofont icofont-notepad activity-icon is-note mr-3"></i>
                            <div class="media-body">
                                <h6 class="mt-0"><strong>Notas / Resumen día</strong></h6>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus</p>
                            </div>
                        </div>
                        <hr>
                        <div class="media mb-3 ">
                            <i class="icofont icofont-emo-laughing activity-icon is-feeling mr-3"></i>
                            <div class="media-body">
                                <h6 class="mt-0"><strong>Estado de Animo</strong></h6>
                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.</p>
                            </div>
                        </div>
                        <hr>
                        <div class="media mb-3 ">
                            <i class="icofont icofont-abc activity-icon is-learning mr-3"></i>
                            <div class="media-body">
                                <h6 class="mt-0"><strong>Participacion en actividades</strong></h6>
                                <p>Juanito participo en las actividades </p>
                            </div>
                        </div>
                        <hr>
                        <div class="media mb-3">
                            <i class="icofont icofont-fast-food activity-icon is-food mr-3"></i>
                            <div class="media-body">
                                <h6 class="mt-0"><strong>Comida</strong></h6>
                                <p>Juanito Comio hoy verduras y pescado </p>
                            </div>
                        </div>
                        <hr>
                        <div class="media mb-3">
                            <i class="icofont icofont-bandage activity-icon is-accident mr-3"></i>
                            <div class="media-body">
                                <h6 class="mt-0"><strong>Accidentes</strong></h6>
                                <p>Juanito se calló </p>
                            </div>
                        </div>
                        <hr>
                        <div class="media mb-3">
                            <i class="icofont icofont-baby-cloth activity-icon is-moods mr-3"></i>
                            <div class="media-body">
                                <h6 class="mt-0"><strong>Mudas</strong></h6>
                                <p>9:45 Pm / Cambio de pañales</p>
                                <p>11:45 Pm / Cambio de pañales</p>
                            </div>
                        </div>
                        <hr>
                        
                        <small class="text-muted">Ultimo reporte al  16/07/2018</small>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection