@switch($quien)
    @case(0) 
        <div class="modal fade" id="rechazar_orden_compra" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="RechazarOrdenLabel">
                            <span class="text-rojo">Rechazar Orden de compra</span>
                        </h5>
                        <button type="button" class="close text-rojo" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <div id="div_alerta">                                
                        </div>
                        <form id="frm_rechazo_orden">
                            <div class="form-group">
                                <label class="text-1" for="motivo_rechazo_orden">Motivo del rechazo</label>
                                <select class="form-control" id="motivo_rechazo_orden" name="motivo_rechazo_orden">
                                    <option value="">Selecciona una opción</option>
                                    <option value="Disponibilidad">Disponibilidad</option>
                                    <option value="Retraso en los pagos">Retraso en los pagos</option>
                                    <option value="Monto insuficiente">Monto insuficiente</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="text-1" for="txt_a_descripcion_rechazo_orden">Describe la situación</label>
                                <textarea class="form-control" id="txt_a_descripcion_rechazo_orden" name="txt_a_descripcion_rechazo_orden" placeholder="Describe la situación de tu rechazo para la orden de compra." rows="3" maxlength="1000"></textarea>
                            </div>
                            <p class="float-right text-2" id="alerta_cantidad_caracteres_rechazo_orden" style="margin-top: -0.8rem;" title="1000 (mil) caracteres es lo máximo que se te permite en la descripción de la situación">0/1000</p>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">                           
                        <button type="button" class="btn boton-12" id="btn_aceptar_rechazar_orden">Rechazar Orden</button>
                    </div>
                </div>
            </div>
        </div>
    @break
    @case(1)
        <div class="modal fade" id="rechazar_orden_compra_confirmar" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="ConfirmarAccion2Label"><span class="text-rojo">Confirmada la acción</span></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-triangle-exclamation text-17"></i>
                            </div>
                            <div class="col-10">
                                <p class="text-2">
                                    Estas por rechazar toda la Orden de compra. Al confirmar la acción no se podrá deshacer.
                                </p>                                
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center mt-3">
                            <p class="text-10">¿Confirmas la acción?</p>
                        </div>
                        <div class="row d-flex justify-content-center mt-3">
                            <div class="col text-right">
                                <button type="button" class="btn boton-5 ajustar-btn-si-no" style="font-size: medium;" data-dismiss="modal" id="btn_no_rechazar_orden">
                                    No
                                </button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn boton-12 ajustar-btn-si-no" style="font-size: medium;" data-dismiss="modal" id="btn_si_rechazar_orden">
                                    Sí
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @break
@endswitch