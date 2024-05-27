<div class="modal fade" id="modal_responder_preguntas" tabindex="-1" aria-labelledby="Modal responder pregunta"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold text-1" id="exampleModaPreguntasLabel">
                    Pregunta para el Proveedor (Desde proveedor)
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_responder_pregunta" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tema_pregunta" class="text-1 font-weight-bold">Tema de la
                            pregunta</label>
                        <p class="text-1">{{ $ppr->tema_pregunta }}</p>
                    </div>
                    <div class="form-group">
                        <label for="pregunta" class="text-1 font-weight-bold">Pregunta</label>
                        <p class="text-1 text-justify">{{ $ppr->pregunta }}</p>
                    </div>
                    <div class="form-group">
                        <label for="respuesta" class="text-1 font-weight-bold">Escribe tu
                            respuesta</label>
                        <textarea class="form-control text-1" id="respuesta" name="respuesta" rows="3" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton-1" id="btn_responder_pregunta">Responder</button>
            </div>
        </div>
    </div>
</div>
