<div class="modal fade" id="facturacion_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="AgregarPersonaAlmacenLabel"><samp class="text-mensaje">Datos de facturación</samp></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="frm_facturacion">
                <div class="form-group">
                    <label for="razon_social">Razón social</label>
                    <input type="text" class="form-control" value="{{ $contrato->razon_social_fiscal }}" readonly>
                </div>

                <div class="form-group">
                    <label for="rfc_fiscal">RFC</label>
                    <input type="text" class="form-control" value="{{ $contrato->rfc_fiscal }}" readonly>
                </div>

                <div class="form-group">
                    <label for="domicilio_fiscal">Domicilio fiscal</label>
                    <input type="text" class="form-control" value="{{ $contrato->domicilio_fiscal }}" readonly>
                </div>

                <div class="form-group">
                    <label for="domicilio_fiscal">Método de pago</label>
                    <input type="text" class="form-control" value="{{ $contrato->metodo_pago }}" readonly>
                </div>

                <div class="form-group">
                    <label for="domicilio_fiscal">Forma de pago</label>
                    <input type="text" class="form-control" value="{{ $contrato->forma_pago }}" readonly>
                </div>

                <div class="form-group">
                    <label for="uso_cfdi">Uso del CFDI</label>
                    <input type="text" class="form-control" value="{{ $contrato->uso_cfdi }}" readonly>
                </div>
            </form>            
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn boton-12" data-dismiss="modal">Confirmar datos</button>
        </div>
      </div>
    </div>
</div>