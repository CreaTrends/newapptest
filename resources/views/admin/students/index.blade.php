@extends('layouts.adminDashboard')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
<style>.title-block {
  padding-bottom: 15px;
  margin-bottom: 30px;
  border-bottom: 1px solid #d7dde4; }
  .title-block::after {
    display: block;
    clear: both;
    content: ""; }
  @media (max-width: 767px) {
    .title-block {
      margin-bottom: 20px; } }
    .title {
    font-size: 1.45rem;
    font-weight: 600;
    margin-bottom: 0;
}
.title-description {
    margin: 0;
    font-size: 0.9rem;
    font-weight: normal;
    color: #7e8e9f;
}</style>
<!-- <div class="title-block">
  <h1 class="title"> Cursos </h1>
  <p class="title-description">
    home > admin > alumnos
</p>
</div> -->

<div class="d-block d-md-flex no-block align-items-center py-0 px-0 my-4">
    <div class="toolbar-card" role="toolbar">
        <div class="toolbar-card mr-auto" role="toolbar">
            <form class="form-inline" action="{{route('usuarios.index')}}" method="GET" id="form-filter">
                <select id="select-filter" class="form-control mr-3" name="curso" onchange="location = this.value;">
                    
                    @foreach($filters['cursos'] as $curso)
                    <option value="{{$curso['href']}}" {{$curso['value'] == Request::get('curso') ? 'selected':'' }}>{{$curso['text']}}</option>
                    @endforeach
                </select>
                <select id="select-filter" class="form-control mr-3" name="status" onchange="location = this.value;">
                    
                    @foreach($filters['status'] as $status)
                    <option value="{{$status['href']}}" {{Request::has('status') ? ($status['value'] == Request::get('status') ? 'selected':''):'' }}>{{$status['text']}}</option>
                    @endforeach
                </select>
                <select id="select-filter" class="form-control mr-3" name="limit" onchange="location = this.value;">
                    
                    @foreach($filters['limits'] as $limit)
                    <option value="{{$limit['href']}}" {{$limit['value'] == Request::get('limit') ? 'selected':'' }}>{{$limit['text']}}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>
    <div class="ml-auto mr-2">
        <button type="button" class="btn custom-btn is-lightblue" data-toggle="modal" data-target="#modal-add-data" id="add">Agregar Alumno</button>
    </div>
    <div >
        <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="is-options-menu">
            <i class="fas fa-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item" type="button">Ver</button>
            <button class="dropdown-item" type="button">Editar</button>
            <div class="dropdown-divider"></div>
            <form action="{{route('alumnos.deleteall')}}" method="POST" enctype="multipart/form-data" id="deleteAll">
                {{ csrf_field() }}
                {{ method_field('POST') }}
                <input type="hidden" name="listSelected" id="listSelected" />
                <button class="dropdown-item" type="submit">Eliminar</button>
            </form>
        </div>
    </div>
</div>
<!-- Header paginator -->
<div class="d-flex justify-content-between py-3 px-3 my-3 header-paginator">
    <div class="h-100 align-self-center">
       Mostrando <strong>{{$alumnos->count()}}</strong> Alumnos
    </div>
    <div class="d-flex justify-content-between h-100">
        <div class="mr-4 align-self-center"> {{$alumnos->firstItem()}} al {{$alumnos->lastItem()}}  de {{$alumnos->total()}} </div>
        <div class="ml-auto pb-0">{{$alumnos->appends([
            'limit' => Request::get('limit'),
            'status' => Request::get('status'),
            'curso' => Request::get('curso')
            ])->links('pagination::simple-bootstrap-4')}}</div>
    </div>
</div>
<div class="card items mb-5 ">
  <div class="Table">
    <div class="Table-row Table-header py-2 px-2">
      <div class="Table-row-item Table-row-small justify-content-center align-items-center">
        <label class="control control--checkbox">
          <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" name="all" />
          <div class="control__indicator"></div>
        </label>
      </div>
      <div class="Table-row-item u-Flex-grow4">Nombre</div>
      <div class="Table-row-item u-Flex-grow4">Apóderados</div>
      <div class="Table-row-item u-Flex-grow3">Curso / Nivel</div>
      <div class="Table-row-item u-Flex-grow2">Estado</div>
      <div class="Table-row-item"></div>
    </div>
    @if(!empty($alumnos->toArray()))
    @foreach ($alumnos as $alumno)
    <!-- row-item-{{$alumno->id}} -->
    <div class="Table-row py-2 px-2" data-user="{{$alumno->id}}" id="alumno-{{$alumno->id}}">
      <div class="Table-row-item Table-row-small align-self-center" data-header="Id">
        <label class="control control--checkbox">
          <input type="checkbox" name="selected[]" value="{{$alumno->id}}"/>
          <div class="control__indicator"></div>
        </label>
      </div>
      <div class="Table-row-item u-Flex-grow4 align-self-center" data-header="Nombre">
        <a href="#" title="" class="float-left">
          
          @if(empty($alumno->image))
          <img class="align-self-center mr-3 rounded-circle mw-25"  src="https://ui-avatars.com/api/?background=5A55A3&color=fff&name=ss" width="48">
          @else
          
          <img class="aalign-self-center mr-3 rounded-circle mw-25"  src="{!! url('/static/image/profile/'.$alumno->image) !!}" width="48">
          @endif
        </a>
        <a href="{{route('alumnos.edit', $alumno->id)}}" class="">
          <h4 class="item-title"> {{$alumno->firstname}} {{$alumno->lastname}}</h4>
        </a>
      </div>
      <div class="Table-row-item u-Flex-grow4 align-self-center" data-header="Header3">
        <div>
          
          @if(!empty($alumno->parent->toArray()))
          @foreach($alumno->parent as $parent)
          <a href="{{route('usuarios.edit', $parent->id)}}" class="d-block">
            {{$parent->profile->first_name}}
            {{$parent->profile->last_name}}
            @if (!$loop->last)
            ,
            @endif
          </a>
          @endforeach
          @else
          <a href="#" class="d-block" id="" role="invite-parent" data-action="{{route('invite.send',$alumno->id)}}" data-student="{{$alumno->id}}" ><small>Agregar Apoderado + </small></a>
          @endif
          
          
        </div>
      </div>
      <div class="Table-row-item u-Flex-grow3  align-self-center" data-header="Header4">
        <div>
          @foreach($alumno->curso as $curso)
          <a href="{{route('cursos.edit', $curso->id)}}" class="d-block w-100">
            {{$curso->name}}
            @if (!$loop->last)
            ,
            @endif
          </a>
          
          @endforeach
        </div>
      </div>
      <div class="Table-row-item u-Flex-grow2 align-self-center" data-header="Header5">
        @if($alumno->status > 0)
        <span class="badge badge-success text-white fw-300 px-2 py-1">
          Activo
        </span>
        @else
        <span class="badge badge-danger text-white fw-300 px-2 py-1">
          Inactivo
        </span>
        @endif
      </div>
      <div class="Table-row-item justify-content-center align-self-center align-items-center" data-header="Header6">
        <div class=" ml-auto">
          <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="is-options-menu">
            <i class="fas fa-ellipsis-h"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item" type="button">Ver</button>
            <a class="dropdown-item" href="{{route('alumnos.edit',$alumno->id)}}">Editar</a>
            <div class="dropdown-divider"></div>
            <form action="{{route('alumnos.destroy',$alumno->id)}}" method="POST" id="bulk_delete" enctype="multipart/form-data">
              
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button class="dropdown-item" type="submit">Eliminar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    @endforeach
    @endif
  </div>
</div>

</div>
<!-- Modal -->
<div class="modal fade" id="modal-add-parent" tabindex="-1" role="dialog" aria-labelledby="modal-add-parent" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" id="" class="form-invite" >
            {{ csrf_field() }}
            {{ method_field('POST') }}
            <input type="hidden" value="4" name="role">
            <input type="hidden" name="alumno_id">
            <div class="form-group">
                <label for="keep">Nombre Apoderado</label>
                <input type="text" name="parent_name" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="keep">Apellido</label>
                <input type="text" name="parent_lastname" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="keep">E-mail</label>
                <input type="text" name="parent_email" class="form-control" value="">
            </div>
            <div class="form-group">
                <label for="keep">Teléfono</label>
                <input type="text" name="parent_phone" class="form-control" value="">
            </div>
            <div class="alert alert-warning" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Se genera un usuario y password y se le envia al apoderado</strong>
                
            </div>
        </form>
      </div>
      <div class="modal-footer justify-content-between">
        
        <button type="button" class="btn btn-primary custom-btn is-lightgreen">Invitar Apoderado</button>
        <a href="#" class="card-link" data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')
<script>
$(document).on('submit', '#deleteAll', function(event){
  event.preventDefault();
  var form = $(this);
  var $listSelected = form.find('#listSelected').val();
  var $action = form.attr('action');
  console.log($action);
  axios({
        method: "POST",
        url: $action,
        data: {
            id: $listSelected,
        },
        onUploadProgress: function(progressEvent) {
            var uploadPercentage = parseInt(Math.round((progressEvent.loaded * 100) / progressEvent.total));
            console.log(uploadPercentage);
        }

    }).then(function(response) {
        console.log(response.data);
        $.each(response.data.ids, function(index, item) {
            $('#alumno-'+item).fadeOut(function() {
                $(this).remove();
                $(this).find('input[name="selected[]"]').prop("checked", false);

            })
        });
        form[0].reset();

    })
    .catch(error => {
        console.log(error.response.data.errors)

        $('.alert-danger').addClass('d-block');
    });

});
$('a[role=invite-parent]').on('click',function(e){
    e.preventDefault();
    var form = $('.form-invite');
    $student_id = $(this).data('student');
    $modal_wrapper = $('#modal-add-parent');
    $modal_wrapper.find("input[name=alumno_id]").val($student_id);
    $url =$(this).data('action');
    form.attr('action',$url);
    form.removeClass('d-none');
    $modal_wrapper.modal('show');
    console.log($student_id);
    
});
$('#modal-add-parent').on('hidden.bs.modal', function (e) {
    var form = $('.form-invite');
    $(this).find("input[name=alumno_id]").val('');
    form.attr('action','');
    form.addClass('d-none');
    form.trigger('reset');
});

$('input[name="selected[]"]').change(function() {
    
    var myarray = [];
    $.each($('input[name="selected[]"]:checked'), function(){
        myarray.push($(this).val());
    });
    
    $('#listSelected').val(myarray);
    console.log(myarray);
});
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