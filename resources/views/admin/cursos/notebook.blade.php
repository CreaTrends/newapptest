@extends('layouts.adminDashboard')
@section('title', 'Enviar Reporte diario a : ')
@section('page-subtitle','Libreta de comunicaciones')
@section('content')
<section class="submenu-page navbar-light bg-white mb-2" id="submenu-profile">
    <div class="row">
        <div class="col-md-12 my-3">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link " href="{{route('index')}}">General</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('cursos.index')}}">Cursos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('notebook.create',$cursos->id)}}">Libreta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('admin.messages')}}">Mensajes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('notes',$cursos->id)}}">Circulares</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="{{route('apoderado.childs')}}">Mi Perfil</a>
                </li>
            </ul>
        </div>
    </div>
</section>


<!-- comienza la tabla de usuarios -->
<form action="{{route('notebook.store')}}" enctype="multipart/form-data" class="form mb-5" method="POST">
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <input type="hidden" name="curso[id]" value="{{$cursos->id}}">
    <input type="hidden" name="curso[date]" value="{{Carbon\Carbon::now()}}">
    
    <table class="table table-bordered">
        <thead class="thead-light ">
            <tr>
                <th colspan="3">Alumnos</th>
            </tr>
        </thead>
        <tbody id="table-notebook-general">
            <tr class="d-flex">
                <th class="col-md-2 text-center">
                    <div class="w-100">
                        <i class="icofont icofont-abc activity-icon icon-table-small is-learning"></i>
                    </div>
                    <div class="w-100">
                        <small><strong>Actividades Generales</strong></small>
                    </div>
                </th>
                <td class="col-md-10">
                    <div class="form-group">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="activities"></textarea>
                    </div>
                </td>
            </tr>
            <tr class="d-flex">
                <th class="col-md-2 text-center">
                    <div class="w-100">
                        <i class="icofont icofont-camera activity-icon icon-table-small is-report"></i>
                    </div>
                    <div class="w-100">
                        <small><strong>Galeria</strong></small>
                    </div>
                </th>
                <td class="col-md-10">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFileLang" lang="es" multiple name="fileupload[]">
                        <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                    </div>
                </td>
            </tr>
        </tbody>
        @foreach($cursos->alumnos as $alumno)
        <?php $attribute_row = $loop->index; ?>
        <input type="hidden" name="alumnos[{{$attribute_row}}][alumno_name]" value="{{$alumno->firstname}}">
        <input type="hidden" name="alumnos[{{$attribute_row}}][alumno_id]" value="{{$alumno->id}}" >
        <tbody id="table-alumno-{{$attribute_row}}">
            <tr>
                <th class="is-lightgreen" colspan="3">
                    <div>
                        <img class="align-self-center mr-3 rounded-circle mw-25" src="{!! url('/static/image/profile/'.$alumno->image) !!}" alt="Generic placeholder image" style="width: 42px;">
                        {{$alumno->firstname}} {{$alumno->lastname}} {{$alumno->id}}
                    </div>
                </th>
            </tr>
            <tr class="d-flex">
                <th class="col-md-2 text-center">
                    <div class="w-100">
                        <i class="icofont icofont-emo-laughing activity-icon icon-table-small is-feeling"></i>
                    </div>
                    <div class="w-100">
                        <small><strong>Estado de animo</strong></small>
                    </div>
                </th>
                <th class="col-md-8">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="alumnos[{{$attribute_row}}][alumno_estado]" id="inlineRadio1" value="happy">
                            <label class="form-check-label" for="inlineRadio1">
                                <i class="icofont icofont-emo-laughing activity-icon icon-table-small is-feeling"></i>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="alumnos[{{$attribute_row}}][alumno_estado]" id="inlineRadio2" value="sad">
                            <label class="form-check-label" for="inlineRadio2">
                                <i class="icofont icofont-emo-astonished activity-icon icon-table-small is-feeling"></i>
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="alumnos[{{$attribute_row}}][alumno_estado]" id="inlineRadio2" value="normal">
                            <label class="form-check-label" for="inlineRadio2">
                                <i class="icofont icofont-emo-sad activity-icon icon-table-small is-feeling"></i>
                            </label>
                        </div>
                    </div>
                </td>
                <th class="col-md-2"><a href="#" id="add" data-link="{{$attribute_row}}">Add More Input Field</a></td>
            </tr>
            <tr class="d-flex">
                <th class="col-md-2 text-center">
                    <div class="w-100">
                        <i class="icofont icofont-fast-food activity-icon icon-table-small is-food"></i>
                    </div>
                    <div class="w-100">
                        <small><strong>Comida</strong></small>
                    </div>
                </th>
                <td class="col-md-8">
                    <div id="food-table-{{$attribute_row}}">
                        <div class="form-row" >
                            <div class="form-group col-md-4">
                                <select class="form-control input-sm" name="alumnos[{{$attribute_row}}][food][0][type]">
                                    <option value="">Seleccionar Alimentacion</option>
                                    <option value="breakfast">Almuerzo</option>
                                    <option value="midmorning">colación AM</option>
                                    <option value="lunch">almuerzo</option>
                                    <option value="evening">colación PM</option>
                                    <option value="dinner">cena</option>
                                    <option value="milk">Leche</option>
                                    <option value="salad">Ensalada</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <select class="form-control input-sm" name="alumnos[{{$attribute_row}}][food][0][amount]">
                                    <option value="">Seleccionar Alimentacion</option>
                                    <option value="none">Nada</option>
                                    <option value="some">Algo</option>
                                    <option value="half">La Mitad</option>
                                    <option value="most">Casi Todo</option>
                                    <option value="all">Todo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="col-md-2">
                    <a href="#" id="add" data-link="{{$attribute_row}}">Agregar Comida</a>
                </td>
            </tr>
            <tr class="d-flex">
                <th class="col-md-2 text-center">
                    <div class="w-100">
                        <i class="icofont icofont-bed activity-icon icon-table-small is-gallery"></i>
                    </div>
                    <div class="w-100">
                        <small><strong>Siestas</strong></small>
                    </div>
                </th>
                <td class="col-md-8">
                    <div id="nap-table-{{$loop->index}}">
                        <div class="form-row" >
                            <div class="form-group col-md-4">
                                <input type="text" id="nap_start-{{$alumno->id}}-{{$loop->index}}" name="alumnos[{{$attribute_row}}][nap][0][start]">
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" id="nap_end-{{$alumno->id}}-{{$loop->index}}" name="alumnos[{{$attribute_row}}][nap][0][end]">
                            </div>
                        </div>
                    </div>
                </td>
                <td class="col-md-2">
                    <a href="#" id="addNap" data-link="{{$attribute_row}}">Agregar Siesta</a>
                </td>
            </tr>
            <tr class="d-flex">
                <th class="col-md-2 text-center">
                    <div class="w-100">
                        <i class="icofont icofont-baby-cloth activity-icon is-moods  icon-table-small"></i>
                    </div>
                    <div class="w-100">
                        <small><strong>Mudas</strong></small>
                    </div>
                </th>
                <td class="col-md-8">
                    <div id="mood-table-{{$loop->index}}">
                        <div class="form-row" >
                            <div class="form-group col-md-4">
                                <input type="text" value="" id="mood_start-{{$alumno->id}}-{{$loop->index}}" name="alumnos[{{$attribute_row}}][mood][0][time]">
                            </div>
                            <div class="form-group col-md-4">
                                <select class="form-control input-sm" name="alumnos[{{$attribute_row}}][mood][0][type]">
                                    <option value="">Seleccionar</option>
                                    <option value="normal">Normal</option>
                                    <option value="hard">Duro</option>
                                    <option value="soft">Blanda</option>
                                    <option value="liquid">Liquido</option>
                                    <option value="urine">Orina</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="col-md-2"><a href="#" id="addMood" data-link="{{$attribute_row}}">Agregar Muda</a></td>
            </tr>
            <tr class="d-flex">
                <th class="col-md-2 text-center">
                    <div class="w-100">
                        <i class="icofont icofont-bandage activity-icon is-accident icon-table-small"></i>
                    </div>
                    <div class="w-100">
                        <small><strong>Accidentes</strong></small>
                    </div>
                </th>
                <td class="col-md-10">
                    <div class="form-row" id="accident-table-{{$attribute_row}}">
                        <div class="form-group col-md-4">
                            <select class="form-control input-sm" name="alumnos[{{$attribute_row}}][accident]">
                                <option >Seleccionar</option>
                                <option value="normal">Caida</option>
                                <option value="hard">Quebradura</option>
                                <option value="soft">Herida</option>
                                <option value="liquid">Desmayo</option>
                                <option value="urine">otro</option>
                            </select>
                        </div>
                    </div>
                </td>
            </tr>
            <tr class="d-flex">
                <th class="col-md-2 text-center">
                    <div class="w-100">
                        <i class="icofont icofont-notepad activity-icon is-note icon-table-small"></i>
                    </div>
                    <div class="w-100">
                        <small><strong>Observaciones</strong></small>
                    </div>
                </th>
                <td class="col-md-10">
                    <div class="form-group">
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="alumnos[{{$attribute_row}}][observation]"></textarea>
                    </div>
                </td>
            </tr>
        </tbody>
        @endforeach()
        
    </table>
    <button type="submit" class="btn btn-primary custom-btn is-green">Enviar Comunicacion</button>
</form>


@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {

var food_row = 0;
var nap_row = 0;
var mood_row = 0;
$(document).on('click', '.remove-food', function(e){
    e.preventDefault();
        var button_id = $(this).attr("id");
        $(this).parent('.form-row').remove();
        --food_row;        
});
$(document).on('click', '.remove-nap', function(e){
    e.preventDefault();
        var button_id = $(this).attr("id");
        $(this).parent('.form-row').remove();
        --nap_row;
});
$(document).on('click', '.remove-mood', function(e){
    e.preventDefault();
        var button_id = $(this).attr("id");
        $(this).parent('.form-row').remove();
        --mood_row;
});
@foreach($cursos->alumnos as $alumno)
var user_id = {{$alumno->id}}+'-'+{{$loop->index}};
$('#nap_start-'+user_id).timepicker({
    uiLibrary: 'bootstrap4',
});
$('#nap_end-'+user_id).timepicker({
    uiLibrary: 'bootstrap4',
});
@endforeach

@foreach($cursos->alumnos as $alumno)
var user_id = {{$alumno->id}}+'-'+{{$loop->index}};
$('#mood_start-'+user_id).timepicker({
    uiLibrary: 'bootstrap4',
});
@endforeach
$(document).on('click', '#addMood', function(e){
e.preventDefault();
mood_row++;
var link = $(this).data('link');
var n = $('#mood-table-'+link).find('.form-row').length;
console.log(n);
var html = '';
html += '<div class="form-row" id="row'+n+'">';
html += '<div class="form-group col-md-4">';
html += '<input type="text" id="mood_start-'+mood_row+'" name="alumnos['+link+'][mood]['+n+'][time]">'
html += '</div>';
html += '<div class="form-group col-md-4">';
html += '<select name="alumnos[' + link + '][mood]['+n+'][type]" class="form-control item_unit">';
html += '<option value="">Característica</option>';
html += '<option value="normal">Normal</option>';
html += '<option value="hard">Duro</option>';
html += '<option value="soft">Blanda</option>';
html += '<option value="liquid">Liquido</option>';
html += '<option value="urine">Orina</option>';
html +="</select>";
html += '</div>';
html +='<a href="#" id="row'+n+'" class="remove-mood">X Quitar</a>';
html += '</div>';
$('#mood-table-'+link).append(html);
$("#mood_start-"+mood_row).timepicker({
    uiLibrary: 'bootstrap4',
});

});
$(document).on('click', '#addNap', function(e){
e.preventDefault();
nap_row++;
var link = $(this).data('link');
var n = $('#nap-table-'+link).find('.form-row').length;
console.log(n);
var html = '';
html += '<div class="form-row" id="row'+n+'">';
html += '<div class="form-group col-md-4">';
html += '<input type="text" id="nap_start-'+nap_row+'" name="alumnos[' + link + '][nap]['+n+'][start]">';
html += '</div>';
html += '<div class="form-group col-md-4">';
html += '<input type="text" id="nap_end-'+nap_row+'" name="alumnos[' + link + '][nap]['+n+'][end]">';
html += '</div>';
html +='<a href="#" id="row'+n+'" class="remove-nap">X Quitar</a>';
html += '</div>';
$('#nap-table-'+link).append(html);
$("#nap_start-"+nap_row).timepicker({
    uiLibrary: 'bootstrap4',
});
$("#nap_end-"+nap_row).timepicker({
    uiLibrary: 'bootstrap4',
});
});
  $(document).on('click', '#add', function(e){
    e.preventDefault();
    food_row++;
    var link = $(this).data('link');
    var n = $('#food-table-'+link).find('.form-row').length;
    console.log(n);
  var html = '';
    html += '<div class="form-row" id="row'+n+'">';
        html += '<div class="form-group col-md-4">';
            html += '<select name="alumnos[' + link + '][food]['+n+'][type]" class="form-control item_unit">';
            html +='<option value="">Seleccionar Alimentacion</option>';
            html +='<option value="breakfast">Almuerzo</option>';
            html +='<option value="midmorning">colación AM</option>';
            html +='<option value="lunch">almuerzo</option>';
            html +='<option value="evening">colación PM</option>';
            html +='<option value="dinner">cena</option>';
            html +='<option value="milk">Leche</option>';
            html +='<option value="salad">Ensalada</option>';
            html +="</select>";
        html +="</div>";
        html += '<div class="form-group col-md-4">';
            html += '<select name="alumnos[' + link + '][food]['+n+'][amount]" class="form-control item_unit">';
            html += '<option value="">Cantidad</option>';
            html += '<option value="none">Nada</option>';
            html += '<option value="some">Algo</option>';
            html += '<option value="half">La Mitad</option>';
            html += '<option value="most">Casi Todo</option>';
            html += '<option value="all">Todo</option>';
            html +="</select>";
        html +="</div>";
        html +='<a href="#" id="row'+n+'" class="remove-food">X Quitar</a>';
    html +="</div>";
    $('#food-table-'+link).append(html);
    
 });
});
</script>
@endsection