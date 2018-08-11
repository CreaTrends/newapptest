@extends('layouts.adminDashboard')
@section('title', '')
@section('page-subtitle','')
@section('content')
<section class="submenu-page navbar-light bg-white mb-5" id="submenu-profile">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar navbar-light bg-white ">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('login') }}">Informacion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Comunicaciones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Comunicaciones</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</section>
<section class="content" id="content-edit">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-5" id="card-profile">
                    <div class="card-header">
                        <h4 class="d-flex justify-content-between align-items-center">
                        Perfil
                            <div class="btn-group toolbar">
                            <a href="#" data-form="profile-form" class="toggle-edit pull-right btn custom-btn btn-link">edit</a>
                            <a href="#" class="toggle-save pull-right btn custom-btn btn-link d-none" data-form="profile-form">save</a>
                            <a href="#" data-form="profile-form" class="toggle-cancel  pull-right btn custom-btn btn-link d-none">cancel</a>
                        </div>
                        </h4>
                        
                        
                    </div>
                    <div class="card-body" id="student-profile">
                        <form enctype="multipart/form-data" action="{{route('alumnos.update',$alumnos->id)}}" method="POST" id="profile-form">
                            {{method_field('PUT')}}
                            {{csrf_field()}}
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                
                                <input name="fileupload" id="imageUpload" type="file" />
                                <label for="imageUpload" class="d-none"></label>
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({!! url('/static/image/profile/'.$alumnos->image) !!})">
                                </div>
                            </div>
                        </div>
                        
                        <h6 class="card-title"><strong>Nombre</strong></h6>
                        <p class="card-text" data-type="text" data-name="firstname">{{$alumnos->firstname}}</p>
                        <h6 class="card-title"><strong>Apellido</strong></h6>
                        <p class="card-text" data-type="text" data-name="lastname">{{$alumnos->lastname}}</p>
                        <h6 class="card-title"><strong>Dirección</strong></h6>
                        <p class="card-text" data-type="text" data-name="address">{{$alumnos->address}}</p>
                        <h6 class="card-title"><strong>Ciudad</strong></h6>
                        <p class="card-text" data-type="text" data-name="city">{{$alumnos->city}}</p>
                        </form>
                        
                    </div>
                </div>
                <div class="card mb-3" id="card-course">
                    <div class="card-header">
                        <h4 class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Apoderados</span>
                        </h4>
                    </div>
                    <div class="card-body">
                        @foreach ($alumnos->parent as $apoderado)
                        <span class="badge badge-success badge-in-table p-3">
                            {{$apoderado->name}}
                            <i class="icofont icofont-close"></i>
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-md 4">
                <div class="card mb-5 " id="card-info">
                    <div class="card-header">
                        <h4 class="d-flex justify-content-between align-items-center">
                        Info
                        <div class="btn-group toolbar">
                            <a href="#" data-form="info-form" class="toggle-edit pull-right btn custom-btn btn-link">edit</a>
                            <a href="#" data-form="info-form" class="toggle-save pull-right btn custom-btn btn-link d-none">save</a>
                            <a href="#" data-form="info-form" class="toggle-cancel  pull-right btn custom-btn btn-link d-none">cancel</a>
                        </div>
                        </h4>
                        
                        
                    </div>
                    <div class="card-body" id="student-info">
                        <form enctype="multipart/form-data" action="{{route('alumnos.updateinfo',$alumnos->id)}}" method="POST" id="info-form">
                            {{method_field('PUT')}}
                            {{csrf_field()}}
                        <h6 class="card-title"><strong>Estado</strong></h6>
                        <p class="card-text" data-type="select-status" data-name="status">
                            {{ $alumnos->status ==1 ? 'activo' : 'inactivo' }}
                        </p>
                        <h6 class="card-title"><strong>Medicamentos</strong></h6>
                        <p class="card-text" data-type="select" data-name="medication">{{ isset($alumnos->medications) ? $alumnos->medications : 'Sin Datos' }}</p>
                        <h6 class="card-title"><strong>Alergias</strong></h6>
                        <p class="card-text" data-type="select" data-name="allergies">
                            {{ isset($alumnos->allergies) ? $alumnos->allergies : 'Sin Datos' }}
                        </p>
                        <h6 class="card-title"><strong>Fecha Nacimiento</strong></h6>
                        <p class="card-text" data-type="text-date"  data-name="birthday">
                            {{ isset($alumnos->birthday) ? $alumnos->birthday : '' }}
                            
                        </p>
                        <h6 class="card-title"><strong>Sexo</strong></h6>
                        <p class="card-text" data-type="select-gender" data-name="gender">
                            {{$alumnos->gender}}
                        </p>
                        </form>
                    </div>
                </div>
                <div class="card " id="card-info">
                    <div class="card-header">
                        <h4 class="d-flex justify-content-between align-items-center">
                        Cursos / Niveles
                        <div class="btn-group toolbar">
                            <a href="#" data-form="courses-form" class="toggle-edit pull-right btn custom-btn btn-link">edit</a>
                            <a href="#" data-form="courses-form" class="toggle-save pull-right btn custom-btn btn-link d-none">save</a>
                            <a href="#" data-form="courses-form" class="toggle-cancel  pull-right btn custom-btn btn-link d-none">cancel</a>
                        </div>
                        </h4>
                    </div>
                    <div class="card-body" id="student-courses">
                        <form enctype="multipart/form-data" action="{{route('alumnos.updatecurso',$alumnos->id)}}" method="POST" id="courses-form">
                            {{method_field('PUT')}}
                            {{csrf_field()}}
                        <h6 class="card-title"><strong>Cursos/ Nivels</strong></h6>
                        <p class="card-text" data-type="select-course" data-name="courses">
                            @foreach($alumnos->curso as $curso )
                            <span id="{{$curso->id}}">
                             {{trim($curso->name)}}
                             </span>
                             @if(!$loop->last), @endif
                            @endforeach
                        </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('scripts')
<script>

$('.toolbar a').click(function(e){
    e.preventDefault();
    var $this = $(this).parent().find('a');
    $this.siblings('.toggle-edit').hide();
    $this.siblings('.toggle-cancel,.toggle-save').hide();
    $(".toolbar a").not($this).siblings('.toggle-edit').show();
    $(".toolbar a").not($this).siblings('.toggle-save, .toggle-cancel').hide();
    $(this).siblings('.toggle-save, .toggle-cancel').attr('style','display:block !important');
    var data = []
    data['form'] = $(this).data('form');
    data['holder'] = 'sss';
    
    
});
$('.toggle-edit').click(function(e) {
    e.preventDefault();
    var data = []
    data['form'] = $(this).data('form');
    enableForm(data);
    disableForm(data);
});
$('.toggle-save').click(function(e) {
    e.preventDefault();
    var form = $(this).data('form');
    $('#'+form).submit();
});

$('.toggle-cancel').click(function(e){
    e.preventDefault();
    var data = []
    data['form'] = $(this).data('form');
    $(this).hide().siblings('.toggle-save').hide();
    $(this).siblings('.toggle-edit').show();
    $('#'+data.form+' > p > .form-control').each(function(){
        $('.tokenize').remove();
        $('.gj-datepicker').remove();
        var content = $(this).val();//.replace(/\n/g,"<br>");
        console.log(content);
        $(this).html(content);
        $(this).contents().unwrap();
    });
});

function enableForm(data) {
    console.log(data);
    $('#'+ data.form +' > .card-text').each(function() {
    var content = $(this).html();
    var name = $(this).data('name');
    var type = $(this).data('type');
    $('label[for=imageUpload]').attr('style','display:block !important');
    var clase = 'form-control';
        if(type =='select-status'){
            arr = content.split(',');
            
            $.each(arr,function(a){
                console.log( $.trim(arr[a]) );
                if($.trim(arr[a]) == 'activo') {
                 htm += '<option  value="activo" selected="selected">Activo</option>';
                 htm += '<option  value="inactivo" >Inactivo</option>';  
                }else {
                    htm += '<option  value="activo">Activo</option>';
                 htm += '<option  value="inactivo" selected="selected">Inactivo</option>';  
                }
              
              
            });
            $(this).html('<select name="status" class="form-control input-status">'+htm+'</select>');

        }
        else if(type =='select'){
            arr = content.split(',');
            console.log(arr);
            var htm;
            $.each(arr,function(a){
              htm += '<option  value="'+arr[a]+'" selected="selected">'+arr[a]+'</option>';
            });
            $(this).html('<select name="'+name+'[]" multiple class="form-control input-tag-'+name+'">'+htm+'</select>');
            $('.input-tag-medication,.input-tag-allergies').tokenize2({
                tokensAllowCustom: true,
                sortable: true,
                delimiter: [',', '-'],
            });
            

            $('.input-tag-gender').tokenize2({
                tokensAllowCustom: true,
                sortable: true,
                delimiter: [',', '-'],
                tokensMaxItems: 1
            });
        }
        else if(type =='select-course'){
            
            arg = content.split(',');
            var cont;
            $.each(arg,function(a){
                $the_id =$(arg[a]).attr('id');
                cont +='<option  value="'+$the_id+'" selected>'+arg[a]+'</option>';

            });
            $(this).html('<select name="'+name+'[]" multiple class="form-control input-tag-'+name+'">'+cont+'</select>');
            $('.input-tag-courses').tokenize2({
                tokensAllowCustom: true,
                sortable: true,
                delimiter: [',', '-'],
                dataSource: function(term, object) {
                    var url = "{{ url('/api/test') }}";
                    console.log(url);
                    $.ajax(url, {
                        data: {
                            keyword: term,
                            start: 0,
                            api_token: '{{Auth::user()->api_token}}'
                        },
                        async: true,
                        dataType: 'json',
                        success: function(data) {
                            
                            var $items = [];
                            $.each(data, function(k, v) {
                                $items.push(v);
                            });
                            object.trigger('tokenize:dropdown:fill', [$items]);
                        }
                    });
                }
            });
            
        
        }else if(type =='text-date'){
            $(this).html('<input id="bday-date" class="form-control date-input" name="' + name + '" type="text" value="' + content.trim() + '">');
            $('#bday-date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd'
            });
        }
        else if(type =='select-gender'){
            arr = content.split(',');
            
            $.each(arr,function(a){
                console.log( $.trim(arr[a]) );
                if($.trim(arr[a]) == 'Female') {
                 htm += '<option  value="Female" selected="selected">Female</option>';
                 htm += '<option  value="Male" >Male</option>';  
                }else {
                 htm += '<option  value="Female" >Female</option>';
                 htm += '<option  value="Male" selected="selected">Male</option>'; 
                }
              
              
            });
            $(this).html('<select name="gender" class="form-control input-gender">'+htm+'</select>');

        }
        else {
            $(this).html('<input class="' + clase + '" name="' + name + '" type="' + type + '" value="' + content + '">');
        }
    });
}
function disableForm(data) {
    
    $('form:not(#'+data.form+') > p > .form-control').each(function(){
    var content = $(this).val();//.replace(/\n/g,"<br>");
    $('select[name=medication]').remove();
    $(this).html(content);
    $(this).contents().unwrap();

  });
}
function autcomplete_course(selector){
  $(selector).tokenize2({
    dataSource: function(term, object) {
        var url = "{{ url('/api/test') }}";
        console.log(url);
        $.ajax(url, {
            data: {
                keyword: term,
                start: 0,
                api_token: '{{Auth::user()->api_token}}'
            },
            async: true,
            headers: {
                "Authorization": "Bearer " + localStorage.getItem('token')
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                var $items = [];
                $.each(data, function(k, v) {
                    $items.push(v);
                });
                object.trigger('tokenize:dropdown:fill', [$items]);
            }
        });
    },
    delimiter: [',', '-']
});  
}

</script>
<script>
function readURL(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();
reader.onload = function(e) {
$('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
$('#imagePreview').hide();
$('#imagePreview').fadeIn(650);
}
reader.readAsDataURL(input.files[0]);
}
}
$("#imageUpload").change(function() {
readURL(this);
});
</script>

@endsection