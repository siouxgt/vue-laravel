<div class="modal fade" id="modal_confirmacion_envio" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header badge-light">
                <h5 class="modal-title" id="modal_confirmacion_envioLabel">
                    <span class="text-rojo">Confirmación de envío</span>
                </h5>
                <button type="button" class="close text-rojo" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_confirmacion_envio" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-2">Los campos marcados con asterisco (<span class="asterisco_obligatorio">*</span>) son obligatorios.</p>         
                        <hr>
                    <div class="form-group">
                        <label for="fecha_envio" class="font-weight-bold text-1 mr-2">Fecha del envío<span class="asterisco_obligatorio">*</span></label><br>
                        <input type="date" class="form-control" id="fecha_envio"
                            name="fecha_envio" min="{{ $fecha_hoy }}" value="{{ $fecha_hoy }}" readonly required>
                    </div>
                    <div class="form-group mt-3">
                        <label class="font-weight-bold text-1"
                            for="txt_comentarios_confirmacion_envio">Comentarios<span class="asterisco_obligatorio">*</span></label>
                        <textarea class="form-control text-1" id="txt_comentarios_confirmacion_envio" name="txt_comentarios_confirmacion_envio"
                            placeholder="Proporciona un comentario sobre el envío del producto" rows="4" maxlength="1000" required></textarea>
                    </div>
                    <p class="float-right" style="margin-top: -0.8rem;" id="cantidad_caracteres_confirmacion_envio">
                        0/1000</p>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn boton-12" type="submit" id="btn_confirmacion_envio">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
