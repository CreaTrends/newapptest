@extends('layouts.adminDashboard')
@section('title', 'Galerias')
@section('page-subtitle','Maneja tus galerias de imagenes')
@section('content')
<div class="d-flex justify-content-between align-items-stretch mb-4 py-4">
    <div class="">
        
        <button type="submit" class="btn custom-btn is-lightgreen" data-toggle="modal" data-target="#create">Agregar Galeria</button>
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
            <td class="col-sm-6 justify-content-center">
               <h6>Galerias</h6>
            </td>
        </tr>
        @foreach($albums as $album)
        <tr class="d-flex">
            <td  class="col-sm-6  d-flex justify-content-start">
                
                <div>
                    <h6 class="my-0"><strong><a href="{{route('albums.edit',$album->album_id)}}">
                        {{$album->album_name}}
                    </a></strong></h6>
                    <small class="text-muted">Cantidad de imagenes : {{$album->photo_count}}</small>
                    
                </div>
            </td>
            <td  class="col-sm-6  d-flex justify-content-start">
                
                <div class="mr-2">
                    <a href="{{route('albums.edit',$album->album_id)}}" class="btn custom-btn is-green is-small">Editar</a>
                </div>
                <div class="jj">
                    <form action="{{route('albums.destroy',$album->album_id)}}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn custom-btn is-red is-small"> <i class="icofont icofont-trash"></i></button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach()
    </tbody>
</table>
<div class="modal fade" id="create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Agregar Alumno</h4>
                <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
                </button>
                
            </div>
            <form class="form" action="{{route('albums.store')}}" method="POST" enctype="multipart/form-data">
                {{ method_field('POST') }}
                {{csrf_field()}}

                <div class="modal-body">
                    
                    <div class="form-group">
                        <label for=""></label>
                        <input type="text" name="album_name" class="form-control mb-2" placeholder="Nombre Galeria">
                        <textarea placeholder="Haz un comentario de las fotos" class="form-control" id="exampleFormControlTextarea1" rows="6" name="album_description" style="height: auto !important"></textarea>
                    </div>
                    <!-- tagged -->
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="input-course">Curso / Nivel</label>
                            <select class="form-control"  name="curso[]">
                                <option>Seleccionar Curso</option>
                                <option value="all">Todos</option>
                                @foreach($cursos as $curso)
                                <option value="{{$curso->id}}">{{$curso->name}}</option>
                                @endforeach
                            </select>
                            <small id="cursoHelp" class="form-text text-muted">Al Asignar un curso , sera visible solo para los apoderados del curso</small>
                        </div>
                    </div>
                    <div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1" name="comments" value="1">Permitir Comentarios</label>
                      </div>
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" multiple name="photos[]" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
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
$('.custom-select').tokenize2({
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
@endsection