<div class="card border-0">
    <div class="card-header is-default">
        <i class="icofont icofont-camera"></i> <strong>Images</strong>
    </div>

    <div class="card-body p-0 mt-3">
        <div class="photo-container">
            <div class="photo-item">
                <div class="mr-3 w-100">
                    <div class="input-group mb-3">
                      <input type="file" class="custom-file-input" id="photos" lang="es" multiple name="fileupload[]" accept="image/*" capture="camera">
                        <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                    </div>
                </div>
                <div class="mr-3 ">
                    <div class="form-group">
                        <label for="">Nota / Comentario</label>
                        
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="data"></textarea>
                    </div>
                </div>
            </div>
            
        </div>
        <span class="d-none total_files mt-2"></span>
        
    </div>
</div>
<script>
$(document).ready(function() {
$('#photos').change(function(e){

var fileName = $(this).get(0).files;
$ht = fileName.length+' archivos seleccionados';
$('.total_files').text($ht).addClass('d-block').fadeIn('slow');
});
});
</script>