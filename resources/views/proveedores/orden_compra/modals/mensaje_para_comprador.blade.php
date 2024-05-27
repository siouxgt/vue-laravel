<div class="modal fade" id="mensaje_para_comprador" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="MensajeProveedoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ProblemasTecnicosLabel">
                    <span class="text-mensaje">Mensaje para el comprador</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_mensaje_comprador">
                <div class="modal-body">
                    <p class="text-2">Los campos marcados con asterisco (<span class="asterisco_obligatorio">*</span>) son obligatorios.</p>         
                        <hr>
                    <div class="form-group">
                        <label class="text-1" for="asunto">Motivo de la consulta<span class="asterisco_obligatorio">*</span></label>
                        <select class="form-control" id="asunto" name="asunto" required>
                            <option value="">Selecciona una opción</option>
                            <option value="confirmacion">Confirmación</option>
                            <option value="contrato">Contrato</option>
                            <option value="envio">Envío</option>
                            <option value="entrega">Entrega</option>
                            <option value="facturacion">Facturación</option>
                            <option value="pago">Pago</option>
                            <option value="consulta_general">Consulta general</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="text-1" for="mensaje">Describe la situación<span class="asterisco_obligatorio">*</span></label>
                        <textarea class="form-control" name="mensaje" id="mensaje" cols="30" rows="5" maxlength="1000" required
                            placeholder="Escribe aquí"></textarea>
                        <p class="text-right">
                            <span id="cantidad_caracteres_mensaje">0/1000</span> caracteres
                        </p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn boton-12" id="btn_enviar_mensaje_comprador">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>
