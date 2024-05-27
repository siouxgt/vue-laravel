<div class="modal fade" id="modal_responder" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-sm-4  mt-2">
                        <p class="text-2 font-weight-bold">Origen</p>
                        <p class="text-2">{{ $mensaje->origen }}</p>
                    </div>
                    <div class="col-12 col-sm-4  mt-2">
                        <p class="text-2 font-weight-bold">ID ORDEN</p>
                        <p class="text-2">1928-1</p>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12 col-sm-10 mt-2">
                        <p><b>Usuario</b></p>
                        <p class="text-2">{{ $mensaje->nombre_usuario }}</p>
                    </div>
                    <div class="col-12 col-sm-2 mt-2">
                        <p class=""><b>Fecha</b></p>
                        <p class="text-2 ">{{ $mensaje->fecha }}</p>
                    </div>
                </div>

                {{-- <hr>

                <p class=" mt-4"><b>ASUNTO</b></p>
                <div class="col-12 bg-light mt-1 mb-3">
                    <p class="">{{ $mensaje->asunto }}</p>
                </div>
                <p><b>MENSAJE</b></p>
                <div class="col-12 bg-light mt-1">
                    <p class="">{{ $mensaje->mensaje }}</p>
                </div> --}}
                <hr>
                <form method="post" id="frm_responder_mensaje">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="respuesta"><b>Asunto</b></label>
                        <input class="form-control" type="text" value="{{ $mensaje->asunto }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="respuesta"><b>Mensaje</b></label>
                        <input class="form-control" type="text" value="{{ $mensaje->mensaje }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="respuesta"><b>Responde aquí el mensaje</b></label>
                        <textarea class="form-control" id="respuesta" name="respuesta" rows="3" maxlength="1000" required></textarea>
                        <p class="text-right">
                            <span id="cantidad_caracteres_respuesta">0/1000</span> caracteres
                        </p>
                        <input type="hidden" id="id_mensaje" value="{{ $mensaje->id_e }}">
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton-1" id="btn_responder_mensaje">Enviar</button>
            </div>

        </div>
    </div>
</div>
