@extends('layouts.adminDashboard')
@section('title', 'Administracion de Usuarios')
@section('page-subtitle','Use this elements, if you want to show some hints or additional information')
@section('content')
<div class="d-flex justify-content-between align-items-stretch mb-4 py-4">
	<div class="">
		
		<button type="button" class="btn custom-btn is-lightgreen mr-2" data-toggle="modal" data-target="#create-user">
            Agregar Usuario 
            </button>
	</div>
	<div class="toolbar-card" role="toolbar">
		<form class="form-inline" action="{{route('usuarios.index')}}" method="GET" id="form-filter">
			
			<label for="select-filter" class="mr-1">Ordenar por : </label>
			<select id="select-filter" class="form-control toolbar-input mr-3" name="filter">
				<option name="reset" value="0">Filtrar Usuarios</option>
				<option disabled="disabled">------</option>
				@foreach ($roles as $role)
				<option name="filter_role" value="{{$role->name}}">{{$role->name}}</option>
				@endforeach
				<option disabled="disabled">------</option>
				<option value="0" name="filter_status">Inactivo</option>
				<option value="1" name="filter_status">Activo</option>
			</select>
			<button type="submit" class="btn custom-btn is-default is-small">filtrar</button>
		</form>
		
	</div>
</div>
<table class="table table table-bordered">
	<thead class="thead-light">
		<tr class="d-flex">
			<th colspan="2" class="col-sm-12">Usuarios</th>

		</tr>
		<tr class="d-flex">
			<th class="col-sm-3">Nombre</th>
			<th  class="col-sm-3">Email</th>
			<th class="col-sm-3">Estado</th>
			<th class="col-sm-3">Acciones</th>
		</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
		 <tr class="d-flex">
            <td  class="col-sm-3  d-flex justify-content-start">
                <div>
                    <h6 class="my-0">
                    	<strong>
                    		<a href="{{route('usuarios.edit',$user->id)}}">
                    			{{$user->profile->first_name}}
                    			{{$user->profile->last_name}}
                    		</a>
                    	</strong>
                    </h6>
                </div>
            </td>
            
            <td class="col-sm-3 justify-content-center">
                {{$user->profile->email}}
            </td>
            <td class="col-sm-3 justify-content-center">
               @if($user->profile->status == '1')
               <span class="badge badge-success badge-in-table">Activo</span>
               @else
               <span v-else class="badge badge-danger badge-in-table">Inactivo</span>
               @endif
               
            </td>
            <td class="col-sm-3 justify-content-center">
				<div class="btn-group">
					<button type="button" class="btn btn-danger custom-btn is-dropdown-options">Editar</button>
					<button type="button" class="btn btn-danger custom-btn is-dropdown-options dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="sr-only">Toggle Dropdown</span>
					</button>
					<div class="dropdown-menu dropdown-menu-right">
						
						<a class="dropdown-item" href="{{route('usuarios.edit',$user->id)}}">Editar</a>
						<a class="dropdown-item" href="#">Ver Usuario</a>
						<a class="dropdown-item" href="#">Enviar Notificación</a>
						<div class="dropdown-divider"></div>
						<form action="{{route('usuarios.destroy',$user->id)}}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="dropdown-item text-danger">Eliminar</button>
                        </form>
					</div>
				</div>
            </td>
        </tr>
		@endforeach
		</tbody>
	</table>


    <div class="modal fade" tabindex="-1" role="dialog" id="create-user">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div><form action="{{route('usuarios.store')}}"  enctype="multipart/form-data" class="form" method="POST">
                {{ method_field('POST') }}
                {{csrf_field()}}
                <div class="modal-body">
                	
	                    <div class="form-group">
	                        <label for="firstname" class="custom-label">Nombre</label>
	                        <input type="text" name="firstname" class="form-control" >
	                    </div>
	                    <div class="form-group">
	                        <label for="slug" class="custom-label">Apellido</label>
	                        <input type="text" name="lastname" class="form-control" >
	                    </div>
	                    <div class="form-group">
	                        <label for="slug" class="custom-label">E-mail</label>
	                        <input type="email" name="email" class="form-control">
	                    </div>
	                    <div class="form-group">
	                        <label for="slug">Perfil de usuario</label>
	                        <select  name="roles" class="form-control">
	                            <option name="role" value="0">-- Elige el tipo de usuario</option>
	                            @foreach($roles as $role)
	                            <option  value="{{$role->id}}">{{$role->name}}</option>
	                            @endforeach
	                            
	                        </select>
	                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Guardar">
                </div></form>	
            </div>
        </div>
    </div>

	
	
	
	@endsection
	@section('scripts')
	
<script>
    @if (session('info'))
            toastr.info("{{ session('info') }}");
   @endif
</script>

<script>
	$(function() {
		$('#select-filter').on('change',function (e) {
			var val = $(this).attr('name');
			var filter = $(e.target).find("option:selected").attr('name').toLowerCase();
			var request = $(e.target).find("option:selected").val().toLowerCase();
			var URL = filter+'='+request;
			var action = $( '#form-filter' ).attr( 'action' );
			if(filter == 'reset'){
				window.location = action;
			}else {
				window.location = action + '?'+URL;
			}
			
		});
	});
</script>
	<script>
		$(function() {
	$('#checkall').on('click', function(e){
		console.log('probando');
		$this = this;
		$.each($(':checkbox'), function(i, item){
		$(item).prop('checked', $this.checked);
		});
		});
	});
	</script>
	<script>
	// register modal component
	
	var userapp = new Vue({
		el:'#users',
		created: function() {
			this.getUsuarios();
		},
		data:{
			usuarios:[],
			newUser:[],
			errors:[],
			roles: {!!$roles!!},
			/*rolesSelected: [{!! old('roles') ? old('roles') : '' !!}],*/
      		rolesSelected:0,
      		user:{
      			name:'',
      			lastname:'',
      			email:'',
      			rolesSelected:0
      		},
      		attachment: '',
      		files: {},
        	file: {},
        	formData: {},
        	
		},
		methods:{
			getUsuarios: function() {
				var _url = 'usuarios/all';
				axios.get(_url).then(response => {
					this.usuarios = response.data
				});
			},
			deleteUser:function(data){
				//alert(data.id);
				toastr.success('Usuario eliminado correctamente');
			},
			storeUser:function(){
				var _url = 'usuarios';
				axios.post(_url, {
					name:this.user.name,
					email:this.user.email,
					role:this.user.rolesSelected,
				})
				.then(response => {
					this.getUsuarios();
					this.user = '';
					this.errors = [];
					$("#create-user").modal('hide');
					toastr.success('Usuario Agregado con éxito');
					console.log(response.data);
				});
			},
			createUser:function(){
				$("#create-user").modal('show');
			},
			importAddFile() {
	            this.attachment = this.$refs.file.files[0];
	        },
			importExcel(){
				this.formData = new FormData();
	            this.formData.append('file', this.attachment);

				axios.post('tools/import',this.formData, {
					
					headers: {
		                'Content-Type': 'multipart/form-data'
		            }
				})
				.then(response => {
					console.log(response.data);
				});

      		},
			importFile:function(){
				$("#import-file").modal('show');
			}
		}
	});
	</script>
	<script>
		@if ($errors->any())
		@foreach ($errors->all() as $error)
		toastr.error("{{ $error }}");
		@endforeach
		@endif
@if (session('info'))
toastr.success("{{ session('info') }}");
@endif
</script>
	@endsection