<div class="modal fade" id="firmar" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="AgregarPersonaAlmacenLabel"><samp class="text-1">Firma de contrato</samp></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="frm_firma">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-6 m-4 p-3 border rounded text-center">
                        <p class="text-1"><strong>Archivo .cer</strong></p>
                        <input type="file" id="archivo_cer" name="archivo_cer" class="ocultar" accept=".cer" required />
                        <div class="rounded punteado m-3 p-4 integrar_cursor text-1" id="drop_cer">
                        </div>
                        <p class="text-1" id="nombre_cer" required></p>
                    </div>

                    <div class="col-6 m-4 p-3 border rounded text-center">
                        <p class="text-1"><strong>Archivo .key</strong></p>
                        <input type="file" id="archivo_key" name="archivo_key"  class="ocultar"  accept=".key" required>
                        <div class="rounded punteado m-3 p-4 integrar_cursor text-1" id="drop_key">
                        </div>
                         <p class="text-1" id="nombre_key"></p>
                    </div>
                        
                </div>
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-7">
                        <div class="form-group">
                            <label for="contrasena"><p class="text-1 ml-4">Contraseña</p></label>
                            <input type="password" id="contrasena" name="contrasena" class="form-control mx-sm-3" required>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="contrato" name="contrato">
            </form>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn boton-2" onclick="firmarSave()">Firmar Contrato</button>
        </div>
      </div>
    </div>
</div>