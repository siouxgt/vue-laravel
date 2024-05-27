<div class="modal fade" id="modal_encuesta_comentarios" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="modal de comentarios" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="ComentariosProveedorLabel">
                    <span class="text-mensaje">Comentarios del proveedor</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_encuesta_comentarios">
                    <div class="form-group">
                        <label for="comentario" class="text-1">Describe la situación</label>
                        <textarea class="form-control text-1" id="comentario" name="comentario" placeholder="Escribe aquí tu comentario"
                            rows="4" maxlength="1000" required></textarea>
                    </div>
                    <p class="float-right" style="margin-top: -0.8rem;" id="cantidad_caracteres_comentario">
                        0/1000
                    </p>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn boton-12" id="btn_enviar_encuesta_comentario">Enviar</button>
            </div>
        </div>
    </div>
</div>
