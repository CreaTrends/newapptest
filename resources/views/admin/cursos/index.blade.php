@extends('layouts.adminDashboard')
@section('title', 'Cursos')
@section('page-subtitle','Maneja tus cursos')
@section('content')
<div class="d-block d-md-flex no-block align-items-center py-0 px-0 my-4">
    <div class="toolbar-card" role="toolbar">
        <div class="toolbar-card mr-auto" role="toolbar">
            
        </div>
    </div>
    <div class="ml-auto mr-2">
        <button type="submit" class="btn custom-btn is-lightblue" data-toggle="modal" data-target="#create">Agregar Curso</button>
    </div>
    <div >
        <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="is-options-menu">
            <i class="fas fa-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item" type="button">Ver</button>
            <button class="dropdown-item" type="button">Editar</button>
            <div class="dropdown-divider"></div>
            <form action="{{route('cursos.deleteall')}}" method="POST" enctype="multipart/form-data" id="deleteAll">
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
       Mostrando <strong>{{$cursos->count()}}</strong> Cursos
    </div>
    <div class="d-flex justify-content-between h-100">
        <div class="mr-4 align-self-center"> {{$cursos->firstItem()}} al {{$cursos->lastItem()}}  de {{$cursos->total()}} </div>
        <div class="ml-auto pb-0">{{$cursos->links('pagination::simple-bootstrap-4')}}</div>
    </div>
</div>



<!-- end block filter-->
<div class="card items ">
  <div class="Table">
    <div class="Table-row Table-header py-2 px-2">
      <div class="Table-row-item Table-row-small justify-content-center align-items-center">
        <label class="control control--checkbox">
          <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" name="all" />
          <div class="control__indicator"></div>
        </label>
      </div>
      <div class="Table-row-item u-Flex-grow4">Nombre</div>
      <div class="Table-row-item u-Flex-grow4">Profesor</div>
      <div class="Table-row-item u-Flex-grow3">Alumnos</div>
      <div class="Table-row-item u-Flex-grow2">Ultima Act.</div>
      <div class="Table-row-item"></div>
    </div>
    @if(!empty($cursos->toArray()))
    @foreach($cursos as $curso)
    <!-- row-item-{{$curso->id}} -->
    <div class="Table-row py-2 px-2" data-user="{{$curso->id}}" id="urso-{{$curso->id}}">
      <div class="Table-row-item Table-row-small align-self-center" data-header="Id">
        <label class="control control--checkbox">
          <input type="checkbox" name="selected[]" value="{{$curso->id}}"/>
          <div class="control__indicator"></div>
        </label>
      </div>
      <div class="Table-row-item u-Flex-grow4 align-self-center" data-header="Nombre">
      	<a href="#" title="" class="float-left">
          
          
          <img class="aalign-self-center mr-3 rounded-circle mw-25" src="https://www.gravatar.com/avatar/{{md5($curso->id)}}?s=48&d=identicon&r=PG" width="48">
        </a>
        <a href="{{route('cursos.show', $curso->id)}}" class="">
          <h4 class="item-title"> {{$curso->name}}</h4>
        </a>
      </div>
      <div class="Table-row-item u-Flex-grow4 align-self-center" data-header="Header3">
        <div>
          
          @if(!empty($curso->teacher->toArray()))
           @foreach($curso->teacher as $teacher)
          <a href="{{route('usuarios.edit', $teacher->id)}}" class="d-block">
            {{$teacher->name}}
            @if (!$loop->last)
            ,
            @endif
          </a>
          @endforeach
          @else
          <a href="#" class="d-block" id="" role="invite-parent" data-action="{{route('invite.send',$curso->id)}}" data-student="{{$curso->id}}" ><small>Agregar Profesor + </small></a>
          @endif
          
          
        </div>
      </div>
      <div class="Table-row-item u-Flex-grow3  align-self-center" data-header="Header4">
        <div>
          {{$curso->alumnos->count()}}
        </div>
      </div>
      <div class="Table-row-item u-Flex-grow2 align-self-center" data-header="Header5">
        {{\Carbon\Carbon::parse($curso->updated_at)->format('l i Y')}}
        
      </div>
      <div class="Table-row-item justify-content-center align-self-center align-items-center" data-header="Header6">
        <div class=" ml-auto">
          <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="is-options-menu">
            <i class="fas fa-ellipsis-h"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item" type="button" id="view" data-id="{{$curso->id}}" data-url="{{ route('cursos.show',$curso->id)}}">Ver</button>
            <a class="dropdown-item" href="{{route('cursos.show',$curso->id)}}">Editar</a>
            <div class="dropdown-divider"></div>
            <form action="{{route('cursos.destroy',$curso->id)}}" method="POST" id="bulk_delete" enctype="multipart/form-data">
              
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

<div id="mf-view-modal" class="modal fade mf-view-modal" tabindex="-1" role="dialog" data-action="view-curso">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary custom-btn is-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

	<div class="modal fade" id="create">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4>Ingresar Nuevo Grupo / Curso</h4>
					<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
					</button>
					
				</div>
				<form action="{{route('cursos.store')}}"  enctype="multipart/form-data" class="form" method="POST">
				    {{ method_field('POST') }}
				    {{csrf_field()}}
					<div class="modal-body">
						<div class="form-group">
							<label for="name">Nombre Curso</label>
							<input type="text" name="name" class="form-control">
						</div>
						<div class="form-group">
							<label for="name">Asignar Educador</label>
							<ul class="list-group" id="teacherslist">
							@foreach ($users as $user)
							<li class="list-group-item d-flex justify-content-between align-items-center">
								{{$user->name}}
								<span>
									<input type="checkbox" name="teachers[]" value="{{$user->id}}">
								</span>
							</li>
							@endforeach
						</ul>
						</div>
						
						<span v-for="error in errors" class="text-danger">@{{ error }}</span>
					</div>
					<div class="modal-footer">
						<input type="submit" class="btn btn-primary" value="Guardar">
					</div>
				</form>
			</div>
		</div>
	</div>


@endsection
@section('scripts')
<script>
    $('input[name="all"]').change(function() {
    $('input[name="selected[]"]').not(this).prop('checked', this.checked);
    var myarray = [];
    $.each($('input[name="selected[]"]:checked'), function(){
    myarray.push($(this).val());
    });
    $('#listSelected').val(myarray);
    console.log(myarray);
});
$('input[name="selected[]"]').change(function() {
    
    var myarray = [];
    $.each($('input[name="selected[]"]:checked'), function(){
        myarray.push($(this).val());
    });
    
    $('#listSelected').val(myarray);
    console.log(myarray);
});

$(document).on('click', '#view', function(){
    var $this = $(this);
    
    $data = {
        "id" : $this.data('id'),
        "action": $this.data('url'),
        "modal_id": $('.mf-view-modal')
    }
    action.get($data);

});
var action = {

    get : function(data){
        
        data.modal_id.modal('show');
        axios.get(data.action).then(response =>{
                 console.log(response.data);
                
            });
    },
    put : function($data){
        console.log('accion get '+$data)
    },
    axios : function(data){
        var x;
         axios.get(data.action).then(response =>{
                 var ut =  response.data;
                return ut;
            });
        

    }
}
new Vue ({
	el:"#app",
	created: function(){
		this.getCursos();
	},
	data:{
		cursos:[],
		testdata : [],
		fillCurso: {'id': '', 'name': '', 'slug': ''},
		errors: '',
		teacherSelected: [{!! old('users') ? old('users') : '' !!}],
		newcurso: {
			'name':''
		},
	},
	methods:{
		getCursos : function(){
			var urlCursos ='';
			axios.get('./getdata?user_id='+{{Auth::id()}}).then(response =>{
				this.cursos = response.data;
				console.log(response);
			});
		},
		createCurso:function(){
			$('#edit').modal('show');
		},
		editKeep: function(curso) {
			let slug = Slug(curso.slug);
			this.fillCurso.id   = curso.id;
			this.fillCurso.name = curso.name;
			this.fillCurso.slug = this.slug;
			$('#edit').modal('show');
		},
		deleteCurso:function(id){
			toastr.success('Eliminado correctamente'); //mensaje
		},
		updateCurso: function(id) {
			var url = 'cursos/' + id;
			axios.put(url, this.fillCurso).then(response => {
				this.getCursos();
				this.fillCurso = {'id': '', 'name': '', 'slug': ''};
				this.errors = [];
					
				$('#edit').modal('hide');
				toastr.success('Curso actualizado con éxito');
			}).catch(error => {
				var error = "Debes ingresar un curso ";
				this.errors = {'error': error  };
			});
		},
		slugy : function(){
			var slug = Slug(this.fillCurso.name);
			return slug
		},

		
	},
	mounted() {
    $(this.$refs.vuemodal).on("hidden.bs.modal", this.onHidden)
  },
	computed:{
		slug : function(){
			this.fillCurso.slug = this.slugy();
			return this.slugy();
		},
	}
});
</script>
<script>
    @if (session('info'))
            toastr.info("{{ session('info') }}");
   @endif
</script>
@endsection