<div class="modal fade" id="modal_enviar_mensaje" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
    aria-labelledby="Enviar mensaje" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title">
                    <span class="text-mensaje">Enviar mensaje</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_enviar_mensaje" method="POST">
                    @csrf
                    {{-- <input type="hidden" id="id_incidencia" value="{{ $incidencia->id_e }}"> --}}

                    <div class="form-group">
                        <label for="asunto" class="col-form-label font-weight-bold mr-2">Asunto</label>
                        <textarea class="form-control" name="asunto" id="asunto" cols="30" rows="3" maxlength="100" required></textarea>
                        <p class="text-right">
                            <span id="cantidad_caracteres_asunto">0</span>/100 caracteres
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="mensaje" class="col-form-label font-weight-bold mr-2">Mensaje</label>
                        <textarea class="form-control" name="mensaje" id="mensaje" cols="30" rows="5" maxlength="1000" required></textarea>
                        <p class="text-right">
                            <span id="cantidad_caracteres_mensaje">0</span>/1000 caracteres
                        </p>
                    </div>

                    <div class="form-group">
                        <input type="checkbox" id="mostrar-ocultar-input">
                        <label for="mostrar-ocultar-input" class="col-form-label font-weight-bold mr-2">Subir
                            imagen</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*"
                            style="display: none;">
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn boton-12" id="btn_enviar">Enviar</button>
            </div>
        </div>
    </div>
</div>
