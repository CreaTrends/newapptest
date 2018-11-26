@extends('layouts.adminDashboard')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-6 col-lg-3 w-sm-50 mb-3 ">
        <div class="card card-body h-100">
            <div class="buton-icon-container  d-flex justify-content-center align-self-center ">
                <a  href="#" role="button" class="link-item text-center" 
                
                data-activity="Activity"
                data-type="activity" 
                data-url="{{route('notebook.store',['action'=>'activity'])}}"
                id="open-modal">
                    <div class="icon-header is-pink p-4 mb-3">
                        <i class="icofont icofont-abc"></i>
                    </div>
                    <p style="text-align:  center; ">
                        <strong>Actividades</strong>
                    </p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 w-sm-50 mb-3 ">
        <div class="card card-body h-100">
            <div class="buton-icon-container  d-flex justify-content-center align-self-center ">
                <a  href="#" role="button" class="link-item text-center" data-activity="Activity"
                data-type="photo" 
                data-url="{{route('notebook.store',['action'=>'photo'])}}"
                id="open-modal">
                    <div class="icon-header is-default p-4 mb-3">
                        <i class="icofont icofont-camera"></i>
                    </div>
                    <p style="text-align:  center; ">
                        <strong>Galerias / Fotos </strong>
                    </p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 w-sm-50 mb-3 ">
        <div class="card card-body h-100">
            <div class="buton-icon-container  d-flex justify-content-center align-self-center ">
                <a  href="#" role="button" class="link-item text-center"
                data-activity="Activity"
                data-type="mood" 
                data-url="{{route('notebook.store',['action'=>'mood'])}}"
                id="open-modal">
                    <div class="icon-header is-lightgreen p-4 mb-3">
                        <i class="icofont icofont-emo-laughing"></i>
                    </div>
                    <p style="text-align:  center; ">
                        <strong>Estado de animo</strong>
                    </p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 w-sm-50 mb-3 ">
        <div class="card card-body h-100">
            <div class="buton-icon-container  d-flex justify-content-center align-self-center ">
                <a  href="#" role="button" class="link-item text-center"
                data-activity="Activity"
                data-type="food" 
                data-url="{{route('notebook.store',['action'=>'food'])}}"
                id="open-modal">
                    <div class="icon-header is-darkgreen p-4 mb-3">
                        <i class="icofont icofont-fast-food"></i>
                    </div>
                    <p style="text-align:  center; ">
                        <strong>Comidas</strong>
                    </p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 w-sm-50 mb-3 ">
        <div class="card card-body h-100">
            <div class="buton-icon-container  d-flex justify-content-center align-self-center ">
                <a  href="#" role="button" class="link-item text-center"
                data-activity="Activity"
                data-type="nap" 
                data-url="{{route('notebook.store',['action'=>'nap'])}}"
                id="open-modal">
                    <div class="icon-header is-yellow p-4 mb-3">
                        <i class="icofont icofont-bed"></i>
                    </div>
                    <p style="text-align:  center; ">
                        <strong>Siestas</strong>
                    </p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 w-sm-50 mb-3 ">
        <div class="card card-body h-100">
            <div class="buton-icon-container  d-flex justify-content-center align-self-center ">
                <a  href="#" role="button" class="link-item text-center"
                data-activity="Activity"
                data-type="deposition" 
                data-url="{{route('notebook.store',['action'=>'deposition'])}}"
                id="open-modal">
                    <div class="icon-header is-orange p-4 mb-3">
                        <i class="icofont icofont-baby-cloth"></i>
                    </div>
                    <p style="text-align:  center; ">
                        <strong>Mudas</strong>
                    </p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 w-sm-50 mb-3 ">
        <div class="card card-body h-100">
            <div class="buton-icon-container  d-flex justify-content-center align-self-center ">
                <a  href="#" role="button" class="link-item text-center">
                    <div class="icon-header is-red p-4 mb-3">
                        <i class="icofont icofont-bandage"></i>
                    </div>
                    <p style="text-align:  center; ">
                        <strong>Accidentes</strong>
                    </p>
                </a>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3 w-sm-50 mb-3 ">
        <div class="card card-body h-100">
            <div class="buton-icon-container  d-flex justify-content-center align-self-center ">
                <a  href="#" role="button" class="link-item text-center"
                data-activity="Activity"
                data-type="nota" 
                data-url="{{route('notebook.store',['action'=>'nota'])}}"
                id="open-modal">
                    <div class="icon-header is-purple p-4 mb-3">
                        <i class="icofont icofont-notepad"></i>
                    </div>
                    <p style="text-align:  center; ">
                        <strong>Observaciones</strong>
                    </p>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- /* add activity daily Modal */  !-->
<div id="mf-view-modal" class="modal fade mf-view-modal" tabindex="-1" role="dialog" data-action="view-note">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary custom-btn is-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary custom-btn is-green">Enviar Circular</button>
                </div>
        </div>
    </div>
</div>
<!-- /* add activity daily Modal Add Form */  !-->
<div class="modal fade" id="modal-add-data" tabindex="-1" role="dialog" aria-labelledby="modal-add-data" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="insert_form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="loading-overlay bg-white position-absolute  w-100 h-100 d-none " style="z-index: 999; left:0; top: 0;" id="loader-modal">
                        <div class="loading-content d-flex justify-content-center h-100">
                            <div class="loading-content w-100 align-self-center">
                                
                                <div class="loading d-flex justify-content-center align-items-center  w-100 h-100 " style="    max-height: 25vh;">
                                    <div class="loading-content w-100 align-self-center">
                                        
                                        <div class="loader-sppinner m-auto mb-3 text-center">
                                            <div class="loader m-auto"></div>
                                        </div>
                                        <div class="loaing-text w-100 text-center mt-3">
                                            <h5>Cargando</h5>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="error-overlay bg-white position-absolute  w-100 h-100 d-none" style="z-index: 999; left:0; top: 0;">
                        <div class="error-content d-flex justify-content-center h-100">
                            <div class="alert alert-danger align-self-center" role="alert">
                                <h4 class="alert-heading">Opps!! Error al cargar</h4>
                                <p>Hubo un error al procesar , por favor intentalo nuevamente</p>
                            </div>
                        </div>
                    </div>
                    {{ method_field('POST') }}
                    {{csrf_field()}}
                    <input type="hidden" name="note_id" id="note_id" />
                    <input type="hidden" name="action" id="action" />
                    <input type="hidden" name="new_recipientsSelected" value="">
                    <input type="hidden" name="activity_type" value="">
                    
                    <div class="alert alert-danger d-none" role="alert">
                        Por favor Rellena los campos necesarios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <span id="display"></span>
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-12 col-md-8 col-lg-8 order-1 order-md-1" id="form-template">
                                
                                
                            </div>
                            <div class="col-md-4 order-0 order-md-2">
                                <input type="hidden" id="recipientsSelected" name="recipientsSelected" id="recipients_all"  />
                                <select class="form-control mb-3" id="filter_users" name="filter_users">
                                    <option value="">Filtrar por curso</option>
                                    @foreach($cursos as $curso)
                                    <option value="{{$curso->id}}">{{$curso->name}}</option>
                                    @endforeach
                                </select>
                                <div class="loading d-flex justify-content-center align-items-center  w-100 h-100 d-none" style="    max-height: 25vh;" id="loader-userlist">
                                    <div class="loading-content w-100 align-self-center">
                                        
                                        <div class="loader-sppinner m-auto mb-3 text-center">
                                            <div class="loader m-auto"></div>
                                        </div>
                                        <div class="loaing-text w-100 text-center mt-3">
                                            <h5>Cargando Alumnos</h5>
                                        </div>
                                        
                                    </div>
                                </div>
                                <ul class="list-group list-group-flush d-block is-list-create" id="user_list" style="max-height: 36vh">
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary custom-btn is-default" data-dismiss="modal">Close</button>
                    <input type="submit" name="insert" id="insert" value="Guardar" class="btn btn-success custom-btn is-green" />
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>

var cboxArray = [];
var AddButton = ''; //Add button ID

function select_tickets(el) {

    var id = $(el).val();
    if (el.checked) {
        cboxArray.push(id);
    } else {
        cboxArray = $.grep(cboxArray, function(value) {
            return value !== id;
        }); // remove id from array if unchecked
    }
    console.log(cboxArray);
}

function check_value(val) {
    var array = '';
    for (i = 0; i < val.length; i++) {
        //alert(array[i]);

        $('input[name="recipients[]"]').each(function() {
            if ($(this).val() == val[i]) {
                $(this).prop('checked', true);
                $(this).parent().find('.avatar').toggleClass('active');
            }
        });
    }
}
$(document).on('change', 'input[name="recipients[]"]', function() {
    select_tickets(this);
    $(this).parent().find('.avatar').toggleClass('active');
    $('input[name="new_recipientsSelected"]').val(cboxArray);
});

$(document).on('click', '#open-modal', function(e) {
    e.preventDefault();
    $modal          = $('#modal-add-data');
    $form           = $('#insert_form');
    $form_action    = $(this).data('url');
    $activity_type  = $(this).data('type');
    $loader = $('#loader-modal');

    $modal.find('.error-overlay').addClass('d-none');

    $form.attr('action',$form_action);
    $form.find('input[name=activity_type]').val($activity_type);

    $loader.removeClass('d-none');
    $modal.modal('show');

    
    $('#filter_users').trigger('change',function(){
        console.log('se cargo');
    });

    console.log($(this).data('type'));
    axios.get('{{route('notebook.forms')}}', {
              params: {
                form: $(this).data('type'),
                
              }
            }).then(function(response) {
                console.log('respuest : '+ response.data);
                $modal.find('#form-template').html(response.data.form);
                $('#loader-modal').addClass('d-none');

            }).catch(error => {
            console.log('tuvimos error');
            $modal.find('.error-overlay').removeClass('d-none');

        });
});

$('#modal-add-data').on('hidden.bs.modal', function (e) {
  $('#insert_form')[0].reset();
  $(document).find('input[name="new_recipientsSelected"]').val();
})

$(document).on('change', '#filter_users', function(activity_type) {

    console.log('cambiamos usuarios');
    
    $list = $(this);
    $id = $list.val();
    $select_input = $(document).find('input[name="new_recipientsSelected"]');
    $select_val = $select_input.val();

    $activity_type = activity_type || null;


    $('#user_list').html('');
    
    $('#loader-userlist').addClass('d-flex');
    $('#user_list').slimscroll({
                height: '0vh',
                size: '5px',
            });

    axios.get('{{url('api/alumnos')}}', {
              params: {
                api_token: '{{Auth::user()->api_token}}',
                id: $id
              }
            }).then(function(response) {

            $select_input.val($select_val);
            $('.modal-title').html('Ingresar Actividades diarias');
            $('#user_list').html(response.data.html);
            
            $('#loader-userlist').removeClass('d-flex').hide();

            
            console.log(response.data);


            check_value(cboxArray);
            
            
            $('#user_list').slimscroll({
                height: '36vh',
                size: '5px',
            });

        })
        .catch(error => {
            console.log(error.response.data.errors)


        });

});
$(document).ready(function(){



});
@if (session('status'))
            toastr.success("{{ session('status') }}");
   @endif

</script>

@endsection