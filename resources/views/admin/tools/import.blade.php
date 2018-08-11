<form  method="POST" v-on:submit.prevent="importExcel">
    {{ csrf_field() }}
    <input type="hidden" name="curso_id" v-model="curso_id">
    <div class="modal fade" tabindex="-1" role="dialog" id="import-file">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >@{{modalTitle}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-primary" role="alert" v-if="loading">
  Cargando Archivos
</div>
                    <div class="content-form">
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" ref="file" name="file" @change="getFileName()">
                                <label class="custom-file-label" for="inputGroupFile02">Choose file</label>
                            </div>
                        </div>
                        <span class="file-name" v-if="attachment.name" v-html="attachment.name"></span>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" v-model="selected":native-value="0" >
                            <label class="form-check-label" name="send_email" for="send_email">Enviar Nuevos Accesos por correo</label>
                          </div>
                    </div>
                    <span v-for="error in errors" class="text-danger">@{{ error }}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn custom-btn is-link" data-dismiss="modal"  @click="onClose">Close</button>
                    <input type="submit" class="btn custom-btn is-green" value="Importar">
                </div>
            </div>
        </div>
    </div>
</form>