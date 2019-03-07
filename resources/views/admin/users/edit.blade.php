@extends('layouts.adminDashboard')
@section('title', 'Editar Usuario')
@section('page-subtitle','Editar usuario')
@section('content')

<div class="row justify-content-center mb-5">
    <div class="col-md-10 col-lg-8">
        <form action="{{route('usuarios.update',$userprofile->id)}}"  enctype="multipart/form-data" class="form" method="POST" >
            {{method_field('PUT')}}
            {{csrf_field()}}
            <div class="avatar-upload">
                            <div class="avatar-edit">
                                
                                <input name="fileupload" id="imageUpload" type="file" />
                                <label for="imageUpload" ></label>
                            </div>
                            <div class="avatar-preview">
                                <?php 
                                $image = url('/static/image/profile/'.$userprofile->profile->image);
                                ?>
                                <div id="imagePreview" style="background-image: url({{$image}})">
                                </div>
                            </div>
                        </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                <h5><strong>Datos Personales </strong></h5>
            <div class="form-group">
                <label for="">Nombre completo</label>
                <input type="text" name="firstname" class="form-control" value="{{$userprofile->profile->first_name}}">
            </div>
            <div class="form-group">
                <label for="">Apellido completo</label>
                <input type="text" name="lastname" class="form-control" value="{{$userprofile->profile->last_name}}">
            </div>
            <div class="form-group">
                <label for="">Fecha de nacimiento</label>
                <input type="text" id="birthday" name="birthday" class="form-control" value="{{$userprofile->profile->birthday}}">
            </div>
            
            <h5><strong>Datos de Contacto</strong></h5>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" name="email" class="form-control" value="{{$userprofile->profile->email}}">
            </div>
            <div class="form-group">
                <label for="">Dirección</label>
                <input type="text" name="address" class="form-control" value="{{$userprofile->profile->address}}">
            </div>
            <div class="form-group">
                <label for="">Teléfono</label>
                <input type="text" name="phone" class="form-control" value="{{$userprofile->profile->telephone}}">
            </div>
            <div class="form-group">
                <label for="">Hijos</label>

                <select id="childs" class="list_user" multiple name="childs[]">

                    @foreach($userprofile->alumno_parent as $child)
                    <option selected value="{{$child->id}}">
                        {{$child->firstname}} {{$child->lastname}}
                    </option>
                            
                            @endforeach()
                            </select>
            </div>
            @if($userprofile->id == Auth::user()->id)
                <h5><strong>Contraseña</strong></h5>
                <div class="alert alert-warning" role="alert">
                  Si quieres cambiar tu contraseña debes ingresar todo los campos solicitados a continuación.
                </div>
                <div class="form-group">
                    <label for="">Contraseña actual</label>
                    <input type="password" name="oldpassword" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label for="">Nueva Contraseña</label>
                    <input type="password" name="password" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label for="">Confirmar nueva Contraseña</label>
                    <input type="password" class="form-control" name="password_confirmation" >
                </div>
            @endif
            <input type="submit" class="btn custom-btn is-lightgreen" value="Guardar">
            <a href="{{route('usuarios.index')}}" class="btn custom-btn is-red">Volver</a>
        </form>
    </div>
</div>
@endsection
@section('scripts')

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
<script>
    @if (session('info'))
            toastr.info("{{ session('info') }}");
   @endif
</script>
<script type="text/javascript">
    $('#birthday').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd'
            });
</script>
<script>
    $('#childs').tokenize2({
    dataSource: function(term, object) {
        var url = "{{ url('/api/childlist') }}";
        
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