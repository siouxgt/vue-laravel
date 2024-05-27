<div class="modal fade" id="editar_facturacion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="AgregarPersonaAlmacenLabel"><samp class="text-mensaje">Edición de datos</samp></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="frm_facturacion">
                <div class="form-group">
                    <label for="razon_social">Razón social</label>
                    <input type="text" class="form-control" id="razon_social" name="razon_social" value="{{ $contrato->razon_social_fiscal }}">
                </div>

                <div class="form-group">
                    <label for="rfc_fiscal">RFC</label>
                    <input type="text" class="form-control" id="rfc_fiscal" name="rfc_fiscal" value="{{ $contrato->rfc_fiscal }}">
                </div>

                <div class="form-group">
                    <label for="domicilio_fiscal">Domicilio fiscal</label>
                    <input type="text" class="form-control" id="domicilio_fiscal" name="domicilio_fiscal" value="{{ $contrato->domicilio_fiscal }}">
                </div>

                <div class="form-group">
                    <label for="domicilio_fiscal">Método de pago</label>
                    <input type="text" class="form-control" readonly value="{{ $contrato->metodo_pago }}">
                </div>

                <div class="form-group">
                    <label for="domicilio_fiscal">Forma de pago</label>
                    <input type="text" class="form-control" readonly value="{{ $contrato->forma_pago }}">
                </div>

                <div class="form-group">
                    <label for="uso_cfdi">Uso del CFDI</label>
                    <input type="text" class="form-control" id="uso_cfdi" name="uso_cfdi" value="{{ $contrato->uso_cfdi }}">
                </div>
            </form>

            
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn boton-12" onclick="facturacionEdit();">Actualizar</button>
        </div>
      </div>
    </div>
</div>