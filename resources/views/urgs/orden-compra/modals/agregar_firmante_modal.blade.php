<div class="modal fade" id="agregar_firmante" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="AgregarPersonaLabel"><samp class="text-mensaje">Agregar firmante</samp></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="fm_firmante">
                <div class="form-group">
                    <label for="rfc">Busca RFC</label>
                    <input type="text" class="form-control" id="rfc" name="rfc">
                    <div id="error" class="invalid-feedback">
                        No se encontró RFC. Contacta al administrador.  
                    </div>
                </div>
                <div class="form-group">
                    <label for="nombre_completo">Nombre</label>
                    <input type="text" id="nombre_completo"  name="nombre_completo" class="form-control text-1" readonly required>
                </div>

                <div class="form-group">
                    <label for="puesto">Puesto</label>
                    <input type="text" id="puesto" name="puesto" class="form-control text-1" readonly required>
                </div>
                  
                <input type="hidden" name="nombre" id="nombre">
                <input type="hidden" name="primer_apellido" id="primer_apellido">
                <input type="hidden" name="segundo_apellido" id="segundo_apellido">
                <input type="hidden" name="telefono" id="telefono">
                <input type="hidden" name="extension" id="extension">
                <input type="hidden" name="correo" id="correo">
                <input type="hidden" name="identificador" id="identificador">
            </form>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn boton-12" onclick="firmanteSave();">Agregar</button>
        </div>
      </div>
    </div>
  </div>