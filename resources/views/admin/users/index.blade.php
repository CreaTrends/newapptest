@extends('layouts.adminDashboard')
@section('title', 'Administracion de Usuarios')
@section('page-subtitle','Use this elements, if you want to show some hints or additional information')
@section('content')
<div class="container">
	<div class="row" id="users">

		<div class="col col-md-12 col-lg-12 col-xl-12">
			<div class="card card-page">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-stretch mb-3">
						<div class="toolbar-card mr-3" role="toolbar">
							<button type="submit" class="btn custom-btn is-purple is-small" v-on:click.prevent="importFile()">Importar</button>
							<span class="border-right mr-2 ml-2"></span>
							<button type="submit" class="btn custom-btn is-purple is-small" v-on:click.prevent="createUser()">Agregar Usuarios</button>
							
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
					<div class="table-responsive">
						<table class="table table-striped dashboard-table">
							<thead>
								<tr>
									<th><input type="checkbox"  id="checkall"></th>
									<th>First Name</th>
									<th>Last Name</th>
									<th>Estado</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								
								<tr v-for="usuario in usuarios">
									<td><input type="checkbox" class="your_checkbox_class" name="ids[]" v-bind:id="usuario.id"></td>
									<td>@{{ usuario.name }}</td>
									<td>@{{ usuario.email }}</td>
									
									<td >
										<span class="badge badge-success badge-in-table" v-if="usuario.profile.status > '0'">Activo</span>
										<span v-else class="badge badge-danger badge-in-table">Inactivo</span>
									</td>
									
									
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-danger custom-btn is-dropdown-options">Editar</button>
											<button type="button" class="btn btn-danger custom-btn is-dropdown-options dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span class="sr-only">Toggle Dropdown</span>
											</button>
											<div class="dropdown-menu dropdown-menu-right">
												
												<a class="dropdown-item" href="#">Editar</a>
												<a class="dropdown-item" href="#">Ver Usuario</a>
												<a class="dropdown-item" href="#">Enviar Notificación</a>
												<div class="dropdown-divider"></div>
												<a href="#" class="dropdown-item text-danger" v-bind:id="usuario.id" v-on:click.prevent="deleteUser(usuario)">Eliminar</a>
											</div>
										</div>
									</td>
								</tr>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
		@include('admin.users.create')
		
	</div>
	
	
	
	
	@endsection
	@section('scripts')
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
	@endsection