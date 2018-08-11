<form method="POST" v-on:submit.prevent="updateCurso(fillCurso.id)">
    <div class="modal fade" id="edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Editar</h4>
                    <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                    </button>
                    
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nombre Curso</label>
                        <input type="text" name="name" class="form-control" v-model="fillCurso.name">
                    </div>
                    <div class="form-group">
                        <label for="slug">Url amigable </label>
                    </div>
                    <div class="alert alert-danger" v-for="error in errors">
                        @{{ error }}
                    </div>
                    
                    
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Actualizar">
                </div>
            </div>
        </div>
    </div>
</form>