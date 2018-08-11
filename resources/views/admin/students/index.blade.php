@extends('layouts.adminDashboard')
@section('title', 'Alumnos')
@section('page-subtitle','Maneja a tus alumnos')
@section('content')
<div class="d-flex justify-content-between align-items-stretch mb-4 py-4">
    <div class="">
        <div class="toolbar-card" role="toolbar">
            <div class="toolbar-card mr-auto" role="toolbar">
                <form class="form-inline" action="{{route('usuarios.index')}}" method="GET" id="form-filter">
                    <select id="select-filter" class="form-control mr-3" name="filter">
                        <option name="reset" value="0">Filtrar por nombre</option>
                        <option disabled="disabled">------</option>
                        
                        <option disabled="disabled">------</option>
                        <option value="0" name="filter_status">Inactivo</option>
                        <option value="1" name="filter_status">Activo</option>
                    </select>
                    <select id="select-filter" class="form-control mr-3" name="filter">
                        <option name="reset" value="0">Filtrar por estado</option>
                        <option disabled="disabled">------</option>
                        
                        <option disabled="disabled">------</option>
                        <option value="0" name="filter_status">Inactivo</option>
                        <option value="1" name="filter_status">Activo</option>
                    </select>
                    <select id="select-filter" class="form-control mr-3" name="filter">
                        <option name="reset" value="0">Filtrar por curso</option>
                        <option disabled="disabled">------</option>
                        
                        <option disabled="disabled">------</option>
                        <option value="0" name="filter_status">Inactivo</option>
                        <option value="1" name="filter_status">Activo</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
    <div class="">
        <button type="submit" class="btn custom-btn is-lightgreen" v-on:click.prevent="importFile()">Importar</button>
        <button type="submit" class="btn custom-btn is-orange" >Exportar</button>
        <div class="btn-group">
            <button type="button" class="btn custom-btn is-lightblue dropdown-toggle" data-toggle="dropdown">
            Agregar Alumno <span class="caret"></span>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                
                <form class="form-submit-user" action="{{route('alumnos.store')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="input-name">Nombre</label>
                            <input type="text" class="form-control" id="input-name" name="firstname" placeholder="Nombre">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="input-lastname">Apellido</label>
                            <input type="text" class="form-control" id="input-lastname" name="lastname" placeholder="Apellido">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="input-course">Curso / Nivel</label>
                            <select class="courseSelected" multiple name="courses[]">
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-block custom-btn is-default">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container">
    
    <div class="row" id="students">
        
        
        <table class="table table-bordered is-narrow">
            <thead>
                <tr>
                    
                    <th scope="col">Nombre</th>
                    <th scope="col">Apoderado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($alumnos as $alumno)
                <tr id="alumno-row-{{$alumno->id}}">
                    <th scope="row">
                        <div class="media">
                            <img class="align-self-center mr-3 rounded-circle mw-25" src="{!! url('/static/image/profile/'.$alumno->image) !!}" alt="Generic placeholder image" style="width: 64px;">
                            <div class="media-body">
                                <h5 class="mt-0"><a class="button is-light" href="{{route('alumnos.edit', $alumno->id)}}">
                                    {{$alumno->firstname}} {{$alumno->lastname}}
                                </a></h5>
                            </div>
                        </div>
                        
                    </th>
                    <td><a href="#" class="link-item" id="{{$alumno->id}}" role="invite-parent" >Agregar Apoderado + </a></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-danger custom-btn is-dropdown-options">Editar</button>
                            <button type="button" class="btn btn-danger custom-btn is-dropdown-options dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                
                                <a class="dropdown-item" href="#">Editar</a>
                                <a class="dropdown-item" href="#">Ver Usuario</a>
                                <a class="dropdown-item" href="#" id="{{$alumno->id}}" role=dailyreport-parent>Enviar Notificación</a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item text-danger" data-id="{{$alumno->id}}" 
                                    onclick="actions.delete({{$alumno->id}})">Eliminar</a>
                            </div>
                        </div>
                    </td>
                </tr>
                <div class="invite-parent" id="invite-parent">
                    @include('admin.users.invite')
                </div>
                <div class="dailyreport-parent" id="dailyreport-parent">
                    
                    @include('admin.students.dailyreport')
                </div>
                @endforeach
            </tbody>
        </table>
        {{ $alumnos->links('vendor.pagination.bootstrap-4') }}
        
        
    </div>
</div>
</div>


@endsection
@section('scripts')
<script>
$('a[role=invite-parent]').on('click',function(e){
    e.preventDefault();
    $student_id = $(this).attr('id');
    $('#invite-parent-modal-'+$student_id).modal('show');
    

});
$('a[role=dailyreport-parent]').on('click',function(e){
    e.preventDefault();
    $student_id = $(this).attr('id');
   $('#dailyreport-parent-modal-'+$student_id).modal('show');

});
$('.form-invite').submit(function (e) {
        e.preventDefault();
         var data;

        data = $( this ).serialize();
        var id = $( this ).attr('id');
        var url = $( this ).data('action');
        
        axios.post(url, $(this).serialize())
        .then(function(response) {
          console.log(response.data);
        })
        .catch(function(error) {
          console.log(error);
        });
        $('#invite-parent-modal-'+id).modal('hide');
        $('.form-invite')[0].reset();
    });


var actions = {
    showinvite:function(id){
        $('#invite-parent-modal-'+id).modal('show');
    },
    hideinvite:function(id){
        $('#invite-parent-modal-'+id).modal('hide');
        $('#invite-parent-modal-'+id).on('hidden.bs.modal', function (e) {
          $('.form-invite')[0].reset();
        })
    },
    delete:function(id){
        
        var resultElement = document.getElementById('alumno-row-'+id);
       
        var rowId = id;
        var url = 'alumnos/' + rowId;
            axios.delete(url).then(response => { //eliminamos
                 //listamos
                  resultElement.remove();
                toastr.success('Eliminado correctamente'); //mensaje
            });
    }
}
$('.courseSelected').tokenize2({
    dataSource: function(term, object) {
        var url = "{{ url('/api/test') }}";
        
        axios.get(url, {
            params: {
              keyword: term,
                start: 0,
                api_token: '{{Auth::user()->api_token}}'
            }
          })
          .then(function (response) {
            var $items = [];
                $items =response.data;
                object.trigger('tokenize:dropdown:fill', [$items]);
          })
          .catch(function (error) {
            console.log(error);
          })
          .then(function () {
            // always executed
          }); 
    },
    delimiter: [',', '-']
});
</script>
<script>
$(function() {
        $('.dropdown-menu').click(function(e) {
            e.stopPropagation();
        });

    });
</script>
@endsection