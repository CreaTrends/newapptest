<form method="POST" v-on:submit.prevent="storeUser">
    <div class="modal fade" tabindex="-1" role="dialog" id="create-user">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="firstname" class="custom-label">Nombre</label>
                        <input type="text" name="firstname" class="form-control" v-model="user.name">
                    </div>
                    <div class="form-group">
                        <label for="slug" class="custom-label">Apellido</label>
                        <input type="text" name="firstname" class="form-control" v-model="user.lastname">
                    </div>
                    <div class="form-group">
                        <label for="slug" class="custom-label">E-mail</label>
                        <input type="email" name="firstname" class="form-control" v-model="user.email">
                    </div>
                    <div class="form-group">
                        <label for="slug">Perfil de usuario</label>
                        <select v-model="user.rolesSelected" name="roles" class="form-control">
                            <option name="role" value="0">-- Elige el tipo de usuario</option>
                            <option v-for="role in roles" v-bind:value="role.id" name="role">@{{role.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Guardar">
                </div>
            </div>
        </div>
    </div>
</form>