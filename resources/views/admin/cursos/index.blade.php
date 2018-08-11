@extends('layouts.adminDashboard')
@section('title', 'Cursos')
@section('page-subtitle','Maneja tus cursos')
@section('content')
<section class="submenu-page navbar-light bg-white mb-3" id="submenu-profile">
	<div class="row">
		<div class="col-md-12 my-3">
			<ul class="nav nav-pills">
				<li class="nav-item">
					<a class="nav-link" href="{{route('index')}}">General</a>
				</li>
				<li class="nav-item">
					<a class="nav-link active" href="{{route('cursos.index')}}">Cursos</a>
				</li>
				<li class="nav-item">
					<a class="nav-link " href="{{route('admin.messages')}}">Mensajes</a>
				</li>
				<li class="nav-item">
					<a class="nav-link " href="{{route('cursos.index')}}">Circulares</a>
				</li>
				<li class="nav-item">
					<a class="nav-link " href="{{route('apoderado.childs')}}">Hijos</a>
				</li>
			</ul>
		</div>
	</div>
</section>
<div class="d-flex justify-content-between align-items-stretch mb-4 py-4">
	<div class="">
		<button type="submit" class="btn custom-btn is-orange" data-toggle="modal" data-target="#addAlumno">Agregar Alumno</button>
		<button type="submit" class="btn custom-btn is-lightgreen" data-toggle="modal" data-target="#create">Agregar Curso</button>
	</div>
</div>
<table class="table table table-bordered">
	<thead class="thead-light">
		<tr class="d-flex">
			<th colspan="2" class="col-sm-12">Alumnos</th>
		</tr>
	</thead>
	<tbody>
		@foreach($cursos as $curso)
		<tr class="d-flex">
			<td  class="col-sm-6  d-flex justify-content-start">
				
				<div>
					<h6 class="my-0"><strong>{{$curso->name}}</strong></h6>
					@if($curso->teacher)
					<small class="text-muted">Profesor :</small>
					
					<small class="text-muted">
					<strong>
					
					@foreach($curso->teacher as $teacher)
					{{$teacher->name}}
					@endforeach
					
					</strong>
					</small>
					@endif
				</div>
			</td>
			
			<td class="col-sm-3 justify-content-center">
				cantidad de alumnos : <h4>{{$curso->alumnos->count()}}</h4>
			</td>
			<td class="col-sm-3 justify-content-start d-flex ">
				<div class="mr-2">
					<a href="{{route('cursos.show',$curso->id)}}" class="btn custom-btn is-green is-small">Editar</a>
				</div>
				<div class="jj">
					<form action="{{route('cursos.destroy',$curso->id)}}" method="POST">
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
  }
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