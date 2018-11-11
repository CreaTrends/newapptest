@extends('layouts.adminDashboard')
@section('content')

<!-- start form -->

<div class="d-block d-md-flex no-block align-items-center bg-light py-3 px-3 mt-4">
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input sl-all" id="cstall">
        <label class="custom-control-label" for="cstall"><strong>Seleccionar todo</strong></label>
        
    </div>
    <div class="ml-auto mr-2">
        <button type="button" class="btn custom-btn is-lightblue" data-toggle="modal" data-target="#modal-add-data" id="add">Crear Circular</button>
    </div>
    <div >
        <a href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="is-options-menu">
            <i class="fas fa-ellipsis-h"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <button class="dropdown-item" type="button">Ver</button>
            <button class="dropdown-item" type="button">Editar</button>
            <div class="dropdown-divider"></div>
            <form action="{{route('notes.deleteall')}}" method="POST" id="bulk_delete" enctype="multipart/form-data">
                <input type="hidden" name="noteSelected[]" id="noteSelected" />
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="dropdown-item" type="submit">Eliminar</button>
            </form>
        </div>
    </div>
    
</div>


<div class="table-responsive" style="border: 1px solid rgba(120, 130, 140, 0.13) !important;">
    <table class="table">

        <tbody>
            @each('admin.notes.noteslist', $notes, 'note')
            
        </tbody>
    </table>

</div>
<div class="my-3">

</div>
<!-- Modal -->
<!-- view / edit note -->

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

<div id="mf-edit-modal" class="modal fade is-modal-form" tabindex="-1" role="dialog" data-action="edit-note">
    <div class="modal-dialog modal-lg">
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
<!-- add note -->
<!-- Modal -->
<div class="modal fade" id="modal-add-data" tabindex="-1" role="dialog" aria-labelledby="modal-add-data" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><strong>Enviar nueva circular a : </strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-before d-none" style="
                position: absolute;
                width: 100%;
                background-color: #fff;
                height: 100%;
                z-index: 999999;
                ">
                <div class="box h-100 d-flex justify-content-center flex-column text-center align-items-center">
                    
                    <h3><strong>Enviando Circular</strong></h3>
                    <p>Espera mientras enviamos la circular</p>
                    <div id="output" class="container"></div>
                    <div class="progress" style="width:400px">
  <div id="dynamic" class="progress-bar progress-bar-success is-lightgreen" role="progressbar">
    
  </div>
</div>
                </div>
                
            </div>
            <div class="modal-body">

                <form method="post" id="insert_form" enctype="multipart/form-data">
                    {{ method_field('POST') }}
                    {{csrf_field()}}
                    <input type="hidden" name="note_id" id="note_id" />
                    <input type="hidden" name="action" id="action" />
                    
                    <div class="alert alert-danger d-none" role="alert">
                        Por favor Rellena los campos necesarios
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            
                            <div class="col-md-8">
                                
                                <div class="form-group">
                                    <label for="input-subject">Asunto</label>
                                    <input type="text" class="form-control" id="input-subject" name="subject" >
                                </div>
                                <div class="form-group">
                                    <label for="input-message">Mensaje</label>
                                    <textarea class="form-control h-auto" id="message" rows="10" name="message"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Archivo Adjunto</label>
                                    <div class="custom-file">
                                        <input type="file" id="photo" class="custom-file-input" name="photos[]" multiple />
                                        <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                    </div>
                                    <span class="d-none total_files mt-2"></span>
                                </div>
                                <div class="form-group form-check">
                                    <input type="hidden" name="sticky" value="0">
                                    <input type="checkbox" name="sticky" value="1" class="form-check-input" id="sticky">
                                    <label class="form-check-label" for="exampleCheck1">Destacar ?</label>
                                </div>
                                <div class="form-group" id="readed_by_group">
                                    <label for="custom-label">Leido por : </label>
                                    <input type="hidden" name="readed_by[]" id="readed_by">
                                    
                                    
                                    <span class="small" >
                                        leido por
                                    </span>
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <input type="hidden" id="recipientsSelected" name="recipientsSelected" id="recipients_all"  />

                                <label for="slug" class="custom-label">Selecciona Cursos</label>
                                <ul class="list-group list-group-flush d-none curso-list" id="curso_list">
                                    <!-- all cursos -->
                                    @role('superadministrator')
                                    <li class="list-group-item d-flex justify-content-start align-items-center px-1 py-2">
                                        <label class="form-check-label d-flex w-100" for="recipients_all">
                                            <input type="checkbox" class="d-block"
                                             name="recipients_all" id="recipients_all">
                                            <div class="avatar" id="uid-all">
                                                <img class="align-self-center mr-0 rounded-circle mw-25" src="https://www.gravatar.com/avatar/{{md5(time())}}?s=48&d=identicon&r=PG" width="48">
                                            </div>
                                            <div class="ml-3 name">
                                                <h6 class="mb-0"><strong>Todo los cursos</strong></h6>
                                                <small class="d-block text-muted" style="line-height: 13px;font-size: 11px;">
                                                
                                                </small>
                                            </div>
                                        </label>
                                    </li>
                                    @endrole
                                    <!-- start cursos list -->
                                    
                                    @foreach($cursos as $curso)
                                    <li class="list-group-item d-flex justify-content-start align-items-center px-1 py-2">
                                        <label class="form-check-label d-flex w-100" for="recipients-{{$curso->id}}">
                                            <input type="checkbox" class="d-block" id="recipients-{{$curso->id}}" name="recipients[]" value="{{$curso->id}}">
                                            <div class="avatar" id="uid-{{$curso->id}}">
                                                <img class="align-self-center mr-0 rounded-circle mw-25" src="https://www.gravatar.com/avatar/{{md5($curso->id)}}?s=48&d=identicon&r=PG" width="48">
                                            </div>
                                            <div class="ml-3 name">
                                                <h6 class="mb-0"><strong>{{$curso->name}}</strong></h6>
                                                <small class="d-block text-muted" style="line-height: 13px;font-size: 11px;">
                                                
                                                </small>
                                            </div>
                                        </label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary custom-btn is-default" data-dismiss="modal">Close</button>
                    
                    <input type="submit" name="insert" id="insert" value="Insert" class="btn btn-success custom-btn is-green" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>  
 $(document).ready(function(){  
    //clear and reset form
let readed_container = $("#readed_by_group");
$(document).on('submit', '#bulk_delete', function(event){
    event.preventDefault();
    var form = $(this);
    var $_data_bulklist = form.find('#noteSelected').val();
    var $_data_action = '{{route('notes.deleteall')}}';

    console.log($_data_bulklist);
    axios({
                method: "POST",
                url: $_data_action,
                data: {
                    id: $_data_bulklist,
                  },
                header: {
                'Content-Type': 'multipart/form-data'
            }
            }).then(function (response) {
        //console.log(response.data);
        $.each(response.data.ids, function(index, item) {
            $('#list_note-'+item).stop().hide(function(){
                $(this).remove();
                $(this).find('input[name="checkItem[]"]').prop( "checked", false );

            })
        });
        form[0].reset();

    })
    .catch(error => {
    console.log(error.response.data.errors)

    $('.alert-danger').addClass('d-block');
    });
});
    
$('#add').click(function() {

    var form =$("#insert_form"); 
    var $_metodo = "POST";
    var $_action = " {{ route('notes.save')}}";
    var $_input_token = $('input[name=_token]');

    $_input_token.val($('meta[name="csrf-token"]').attr('content'));

    form.trigger('reset');

    $('#insert').val("Enviar");
    $("#readed_by_group").addClass('d-none');
    
    $('input[name=_method]').val($_metodo);
    
    $('input[name=action]').val($_action);
    
});
// view note
$(document).on('click', '.view_note', function(){
    var $this = $(this);
    $_note_id = $this.data('id');
    $_note_action = $this.data('url');
    $_modal = $('.mf-view-modal');

    console.log($_note_id);
    let config = {
      onUploadProgress: progressEvent => {
        let percentCompleted = Math.floor((progressEvent.loaded * 100) / progressEvent.total);
        // do whatever you like with the percentage complete
        // maybe dispatch an action that will update a progress bar or something
      }
    }
    axios({
            method: 'get',
            url:$_note_action,
            data: {
                id :$_note_id
            },
            header: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(function(response) {
            console.log(response.data);
            $_modal.find('.modal-body').html(response.data.message);
            $_modal.find('.modal-title').text(response.data.title);
            $_modal.modal('show');

            $_modal.find('.modal-body').slimscroll({
                height: '490px',
                color: 'rgba(0,0,0,.8)',
                size: '4px',
                alwaysVisible: false,
                borderRadius: '0',
                railBorderRadius: '0',
                start: 'top'
            });

            


        })
        .catch(error => {
            console.log(error.response.data.errors)

            $('.alert-danger').addClass('d-block');
            $('.modal-before').removeClass('d-block');
        });

    });
});
    // action for edit 
    $(document).on('click', '.edit_note', function(){
        console.log('abrete');
        // define variables
        var $_note_id = $(this).data('id');
        var $_url =$(this).data('url');
        var $_url_update =$(this).data('urledit');

        var $_note_url =$_url_update;
        $('input[name=action]').val($_note_url);

        $("#readed_by_group").addClass('d-none');
        
        var $_metodo = "PUT";
        $('input[name=_method]').val($_metodo);

        console.log($_note_id);
        
        

        $.ajax({
            url:$_url,
            headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                  }, 
            type: 'get',  
            dataType:"json",
            success:function(response){ 
                console.log(response);
                $('#input-subject').val(response.subject);
                CKEDITOR.instances.message.setData(response.body);
                $('#input-subject').val(response.subject);
                $('#note_id').val(response.id);
                $('#sticky').prop('checked', response.sticky == 1);
                $('#sticky').prop('checked', response.sticky == 1);
                //$('#files_attached').val(JSON.stringify(response.attached.encrypt));
                console.log('longitud de variable :'+response.attached);
                if(response.attached){
                    $ftext = response.attached.length+' archivos adjuntos';
                    $('.total_files').text($ftext).addClass('d-block').fadeIn('slow');  
                }
                
                if(response.readed.length > 0) {
                    var readed_users = [];
                    $.each(response.readed, function(i) {
                        readed_users.push(this.profile.first_name +' '+ this.profile.last_name+' ');
                    });

                    
                    $('#readed_by').val(readed_users);
                    $("#readed_by_group ").removeClass('d-none');
                    $("#readed_by_group > .small").text(readed_users);
                }
               
                
                

                
                $('#insert').val("Update"); 


                
                $('#modal-add-data').modal('show');
                $('#action_form').data('action','POST') 
            }
        });
    });

$(document).on('submit', '#insert_form', function(event){

    event.preventDefault();
    
    var method = $(this).find('input[name=_method]').val() || 'POST';
    let action = $(this).find('input[name=action]').val();
    var _token = $('meta[name="_token"]').attr('content');
    var loader = $('.modal-before');
    let output = document.getElementById('output');

    let progress = $('.progress');
    let bar = progress.find('.progress-bar');

    

    let self = this;

    let formData = new FormData($(this)[0]);
    var file = document.getElementById('photo').files[0];



   /* formData.append("file", file.files[0]);*/
   formData.append('file', file);

var config = {
    onUploadProgress: function(e) {
    let percentCompleted = Math.round( (e.loaded * 100) / e.total );
       console.log("Progress:-"+percentCompleted);

       output.innerHTML = percentCompleted+'%';

       //$(bar).text('subiendo').width(percentCompleted+'%');
        if (e.lengthComputable) {
        loader.addClass("d-block");
        $('div.progress > div.progress-bar').css({ "width":percentCompleted + "%" }).text(percentCompleted+'%');
        }
        
    }
};

axios.post(action, formData, config)
    .then(function(res) {
        output.className = 'container';
        output.innerHTML = res.data;
        
        loader.removeClass("d-block");
        console.log(res.data);
        console.log(method);
        if(method == 'POST'){
            if(res.data.sticky > 0){
              $('.table > tbody tr:first').before(res.data.html).fadeIn(function(){
                $("#list_note-"+res.data.id).css('background-color', '#f0f8ff');
                console.log($("#list_note-"+res.data.id));
              })
            }else {
                $('.table > tbody').append(res.data.html);
            }
        }else {
            console.log('el di a cambiar es : '+res.data.id);
            $(document).find("#list_note-"+res.data.id).replaceWith(res.data.html);
        }
        

        loader.removeClass("d-block");
        $("#insert_form").trigger('reset');;
        $('#modal-add-data').modal('hide');

        
        $("#insert_form").find('.avatar').removeClass('active');
        
        
    })
    .catch(function(err) {
        console.log(err);
        $('.alert-danger').removeClass('d-none');
        
        loader.removeClass("d-block");
    });





// bulk function

});


 </script>
<script>
    $('#recipients_all').change(function() {
        $('input[name="recipients[]"]').not(this).prop('checked', this.checked);
        $('input[name="recipients[]"]').not(this).parent().find('.avatar').toggleClass('active');
        
    });

    
    $('input[name="recipients[]"]').change(function() {

        
            // have an empty array to store the values in
            let values = [];
            // check each checked checkbox and store the value in array
            $.each($('input[name="recipients[]"]:checked'), function(){
                values.push($(this).val());
            });
            // convert the array to string and store the value in hidden input field
            $('#recipientsSelected').val(values);

            console.log(values);
        });
    var s = [];
    var k = [];
    var k = s.push({!! $cursos->pluck('id') !!});
    $('#recipientsSelected').val(k);


$('#cstall').change(function() {
    $('input[name="checkItem[]"]').not(this).prop('checked', this.checked);
    var myarray = [];
    $.each($('input[name="checkItem[]"]:checked'), function(){
        myarray.push($(this).val());
    });
    
    $('#noteSelected').val(myarray);
    console.log(myarray);

});

$('input[name="checkItem[]"]').change(function() {
    
    var myarray = [];
    $.each($('input[name="checkItem[]"]:checked'), function(){
        myarray.push($(this).val());
    });
    
    $('#noteSelected').val(myarray);
    console.log(myarray);
});



$('#modal-add-data').on('hidden.bs.modal', function(e){
    // reset values
    var form = $("#insert_form");
    var input_message = CKEDITOR.instances.message;
    var total_file_text = $('.total_files');
    form.trigger('reset');
    form.find('.avatar').removeClass('active');
    input_message.setData();
    total_file_text.text('').removeClass('d-block');
        
       
    }) ;


$('#photo').change(function(e){

var fileName = $(this).get(0).files;
$ht = fileName.length+' archivos seleccionados';
$('.total_files').text($ht).addClass('d-block').fadeIn('slow');
});
        $(document).ready(function() {
        $('input[name="recipients[]"]').change(function() {

            $(this).parent().find('.avatar').toggleClass('active');

        });
        
        
        $('.curso-list').addClass('d-block');
        $('.curso-list').slimscroll({
        height: '400px',
        color: 'rgba(0,0,0,.8)',
        size: '5px',
        alwaysVisible: true,
        borderRadius: '0',
        railBorderRadius: '0',
        distance: '0px',
        start: 'top',
    });
    });
 $( "#button" ).click(function() {
        $( "#form" ).submit();
    });
$(function() {


});

</script>
@if ($errors->any())
<script>
$('#exampleModalCenter').modal('toggle')
</script>
@endif

<script>
@if (session('info'))
toastr.success("{{ session('info') }}");
@endif
</script>
<script>

          
       CKEDITOR.replace( 'message', {
            // Define the toolbar groups as it is a more accessible solution.
            toolbarGroups: [
                {"name":"basicstyles","groups":["basicstyles"]},
                {"name":"document","groups":["mode"]},
                {"name":"insert","groups":["insert"]},
                {"name":"styles","groups":["styles"]},
            ],
            // Remove the redundant buttons from toolbar groups defined above.
            removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
        } );
        
        </script>
@endsection