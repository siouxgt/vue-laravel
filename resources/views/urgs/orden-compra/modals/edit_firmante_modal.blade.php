<div class="modal fade" id="editar_firmante" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="AgregarPersonaLabel"><samp class="text-mensaje">Editar firmante</samp></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="fm_firmante">
                <div class="form-group">
                    <label for="rfc">Busca RFC</label>
                    <input type="text" class="form-control" id="rfc" name="rfc" value="{{ $firmante->rfc }}">
                    <div id="error" class="invalid-feedback">
                        No se encontró RFC. Contacta al administrador.  
                    </div>
                </div>
                <div class="form-group">
                    <label for="nombre_completo">Nombre</label>
                    <input type="text" id="nombre_completo"  name="nombre_completo" class="form-control text-1" value="{{ $firmante->nombre." ".$firmante->primer_apellido." ".$firmante->segundo_apellido }}" readonly required>
                </div>

                <div class="form-group">
                    <label for="puesto">Puesto</label>
                    <input type="text" id="puesto" name="puesto" class="form-control text-1" value="{{ $firmante->puesto }}" readonly required>
                </div>
                
                <input type="hidden" name="id" id="id" value="{{ $firmante->id_e }}">  
                <input type="hidden" name="nombre" id="nombre" value="{{ $firmante->nombre }}">
                <input type="hidden" name="primer_apellido" id="primer_apellido" value="{{ $firmante->primer_apellido }}">
                <input type="hidden" name="segundo_apellido" id="segundo_apellido" value="{{ $firmante->segundo_apellido }}">
                <input type="hidden" name="telefono" id="telefono" value="{{ $firmante->telefono }}">
                <input type="hidden" name="extension" id="extension" value="{{ $firmante->extension }}">
                <input type="hidden" name="correo" id="correo" value="{{ $firmante->correo }}">
            </form>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn boton-12" onclick="firmanteEdit();">Actualizar</button>
        </div>
      </div>
    </div>
  </div>