<form method="POST" id="{{$alumno->id}}" class="form-invite" 
  data-action="{{route('invite.send',$alumno->id)}}">
<div class="modal fade" id="invite-parent-modal-{{$alumno->id}}" tabindex="-1" role="dialog" aria-labelledby="invite-parentLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <input type="hidden" value="{{$alumno->id}}" name="alumnoid">
        <input type="hidden" value="4" name="role">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Invitar Apoderado de {{$alumno->firstname}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
        <label for="keep">Nombre Apoderado</label>
        <input type="text" name="parent_name" class="form-control" value="">
      </div>
      <div class="form-group">
        <label for="keep">Apellido</label>
        <input type="text" name="parent_lastname" class="form-control" value="">
      </div>
      <div class="form-group">
        <label for="keep">E-mail</label>
        <input type="text" name="parent_email" class="form-control" value="">
      </div>
      <div class="form-group">
        <label for="keep">Teléfono</label>
        <input type="text" name="parent_phone" class="form-control" value="">
      </div>
        <div class="form-group form-check">
          <input type="checkbox" class="form-check-input" id="create_account" name="parent_account">
          <label class="form-check-label" for="create_account">Crear la cuenta de manera automatica (Se genera un usuario y password y se le envia al apoderado) </label>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn custom-btn is-default" data-dismiss="modal" onclick="actions.hideinvite({{$alumno->id}});">Cancelar</button>
        <input type="submit" role="sent-invitation" id="sent-invitation" class="btn custom-btn is-green" value="Enviar Invitación">
      </div>
    </div>
  </div>
</div>
</form>