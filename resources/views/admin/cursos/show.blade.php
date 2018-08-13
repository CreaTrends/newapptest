@extends('layouts.adminDashboard')
@section('title', 'Curso')
@section('page-subtitle','Maneja tus cursos')
@section('content')
<section class="submenu-page navbar-light bg-white mb-2" id="submenu-profile">
    <div class="row">
        <div class="col-md-12 my-3">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link " href="{{route('index')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('cursos.index')}}">Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('notebook.create',$cursos->id)}}">Libreta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('notes',$cursos->id)}}">Circulares</a>
                </li>
            </ul>
        </div>
    </div>
</section>
<div class="d-flex justify-content-end align-items-stretch mb-4">
    <div class="">
        <button type="submit" class="btn custom-btn is-default mr-2" data-toggle="modal" data-target="#edit-curso">Editar</button>
        <button type="button" class="btn custom-btn is-lightblue mr-2" data-toggle="modal" data-target="#add-child">
            Agregar Alumno <span class="caret"></span>
            </button>
        <button type="submit" class="btn custom-btn is-green" v-on:click.prevent="showImport()">Importar Alumnos</button>
        <a href="{{route('tools.export',$cursos->id)}}" class="btn custom-btn is-purple">Exportar Alumnos</a>
        
    </div>
</div>
<table class="table table table-bordered">
    <thead class="thead-light">
        <tr class="d-flex">
            <th colspan="2" class="col-sm-12">Alumnos</th>
        </tr>
    </thead>
    <tbody>
        <tr class="d-flex">
            <td class="col-sm-12 justify-content-start">
                
                <h6><strong>Profesor :</strong>
                @foreach($cursos->teacher as $teacher)
                
                {{ $teacher->name }}
                @if (!$loop->last)
                ,
                @endif
                @endforeach
                </h6>
                <h6><strong>Menu Semanal :</strong> del 16/07/2018 al  22/07/2018</h6>
                
            </td>
        </tr>
        @foreach($cursos->alumnos as $alumno)
        <tr class="d-flex">
            <td  class="col-sm-6  d-flex justify-content-start">
                <div>
                    <img class="align-self-center mr-3 rounded-circle mw-25" src="{!! url('/static/image/profile/'.$alumno->image) !!}" alt="Generic placeholder image" style="width: 64px;">
                </div>
                <div>
                    <h6 class="my-0"><strong><a href="{{route('alumnos.edit',$alumno->id)}}">{{$alumno->firstname}}</a></strong></h6>
                    <small class="text-muted">Apoderados :</small>
                    @foreach($alumno->parent as $apoderado)
                    <small class="text-muted">
                    <strong>
                    {{ $apoderado->profile->first_name }}
                    {{ $apoderado->profile->last_name }}
                    </strong>
                    </small>
                    @if (!$loop->last)
                    ,
                    @endif
                    @endforeach
                </div>
            </td>
            
            <td class="col-sm-3 justify-content-center d-none d-lg-block">
                
            </td>
            <td class="col-sm-3 justify-content-end d-flex">
                <div class="mr-2">
                <a href="{{route('alumnos.edit',$alumno->id)}}" class="btn custom-btn is-green is-small">Editar</a>
            </div>
            <div class="mr-0">
                <form action="{{route('alumnos.destroy',$alumno->id)}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn custom-btn is-red is-small"> <i class="icofont icofont-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@include('admin.tools.import')
<div class="modal fade" id="edit-curso">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Editar</h4>
                <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
                </button>
                
            </div>
            <form action="{{route('cursos.update',$cursos->id)}}"  enctype="multipart/form-data" class="form" method="POST">
                {{ method_field('PUT') }}
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nombre Curso</label>
                        <input type="text" name="name" class="form-control" value="{{$cursos->name}}">
                    </div>
                    <ul class="list-group">
                        @foreach($teachers as $teacher)
                        <li class="list-group-item">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{$teacher->id}}" name="teachers[]" id="teacher-{{$teacher->id}}" {{in_array($teacher->id,$assignedTeacher)?'checked':''}}>
                                <label class="form-check-label" for="teacher-{{$teacher->id}}">
                                    {{$teacher->profile->first_name}} {{$teacher->profile->last_name}}
                                </label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Actualizar">
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="add-child">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Agregar Alumno</h4>
                <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
                </button>
                
            </div>
            <form class="form" action="{{route('alumnos.store')}}" method="POST">
                    {{ method_field('POST') }}
                    {{csrf_field()}}
            <div class="modal-body">

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
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="input-course">Asignar Apoderado</label>
                            <select class="parents" multiple name="parents[]">
                            </select>
                        </div>
                    </div>
                    
                
            </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-block custom-btn is-default">Agregar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
var cursoapp = new Vue({
el:'#app',
data:{
modalTitle:'',
attachment:'',
files: {},
file: {},
formData: {},
loading:false,
errors:'',
curso_id :{!! $cursos->id !!},
selected :'',
fillCurso: {'id': '', 'name': '', 'slug': ''},
},
methods:{
showEdit:function(){
$('#edit').modal('show');
},
showImport:function(){
this.modalTitle = 'Importar Alumnos';
$("#import-file").modal('show');
},
getFileName() {
this.errors = [];
this.attachment = this.$refs.file.files[0];
},
export(){

},
importExcel(){
this.attachment = this.$refs.file.files[0];
this.loading=true;
this.formData = new FormData();
this.formData.append('file', this.attachment);
this.formData.append('curso_id', this.curso_id);
this.formData.append('send_email', this.selected);
var url = "{{ url('admin/tools/import/') }}";
axios.post(url,this.formData, {

headers: {
'Content-Type': 'multipart/form-data'
}
})
.then(response => {
this.loading = false;
this.errors = [];
console.log(response.data);
$("#import-file").modal('hide');
toastr.success('Curso actualizado con éxito');
}).catch((error) => {
if (error.response) {
this.attachment='';
this.loading = false;
this.errors = 'Corrija para poder crear con éxito';
}

});
},
onClose:function(event){
console.log('cerramos');
this.attachment='';
}
}
});
</script>
<script>
@if (session('info'))
toastr.success("{{ session('info') }}");
@endif
</script>
<script>
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
        $('.parents').tokenize2({
    dataSource: function(term, object) {
        var url = "{{ url('/api/parentslist') }}";
        
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
$(function() {
        $('.dropdown-menu').click(function(e) {
            e.stopPropagation();
        });

    });
</script>
@endsection