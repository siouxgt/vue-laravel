<div class="modal fade" id="info_urg_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="AgregarPersonaAlmacenLabel"><samp class="text-mensaje">Datos del contacto - URG</samp></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" value="{{ $user->nombre." ".$user->primer_apellido." ".$user->segundo_apellido }}" readonly>
            </div>

            <div class="form-group">
                <label for="cargo">Cargo</label>
                <input type="text" class="form-control" id="cargo" value="{{ $user->cargo }}" readonly>
            </div>

            <div class="form-row">
                <div class="col">
                    <label for="">Número fijo</label>
                    <input class="form-control" type="text" id="" value="{{ $user->telefono }}" readonly>
                </div>
                <div class="col">
                    <label for="">Extensión</label>
                    <input class="form-control" type="text" id="" value="{{ $user->extension }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="">Correo electrónico</label>
                <input type="text" class="form-control" id="" value="{{ $user->email }}" readonly>
            </div>

        </div>
      </div>
    </div>
</div>