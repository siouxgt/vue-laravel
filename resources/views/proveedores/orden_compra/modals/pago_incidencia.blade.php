<div class="modal fade" id="modal_incidencia_pago" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="modal_incidencia_pagoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modal_incidencia_pagoLabel">
                    <span class="text-mensaje">Abrir una incidencia</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_incidencia_pago">
                    <div class="form-group">
                        <label class="text-1" for="motivo">Motivo de la incidencia</label>
                        <select class="form-control text-1" id="motivo" name="motivo">
                            <option value="Retraso en el pago">Retraso en el pago</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold text-1" for="descripcion">
                            Describe la situación
                        </label>
                        <textarea class="form-control text-1" id="descripcion" name="descripcion"
                            placeholder="Proporciona un comentario sobre el envío del producto" rows="4" maxlength="1000" required></textarea>
                    </div>
                    <p class="float-right" style="margin-top: -0.8rem;"
                        id="cantidad_caracteres_descripcion_incidencia_pago">
                        0/1000
                    </p>
                </form>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn boton-12" id="btn_enviar_incidencia_pago">Abrir incidencia</button>
            </div>
        </div>
    </div>
</div>
