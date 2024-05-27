<div class="modal fade" id="modal_adjuntar_prefactura" data-backdrop="static" data-keyboard="false" role="dialog"
    aria-labelledby="AdjuntarPrefactura" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header badge-light">
                <h5 class="modal-title" id="AdjuntarPrefacturaLabel">
                    <span class="text-rojo">Adjuntar Prefactura</span>
                </h5>
                <button type="button" class="close text-rojo" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_adjuntar_prefactura" method="POST" action="#">
                    <div class="form-group">
                        <label for="fecha_envio" class="font-weight-bold mr-2">1. Fecha del envío</label><br>
                        <input type="date" class="form-control" id="fecha_envio" name="fecha_envio"
                            min="{{ $fecha_hoy }}" value="{{ $fecha_hoy }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="archivo_prefactura" class="font-weight-bold mr-2">2. Adjuntar archivo</label>
                        <input type="file" class="form-control" id="archivo_prefactura"
                            name="archivo_prefactura" accept=".pdf" required>
                    </div>

                    <div class="form-group">
                        <label for="tipo_archivo" class="font-weight-bold mr-2">3. Tipo de archivo</label>
                        <select class="form-control" id="tipo_archivo" name="tipo_archivo" required disabled>
                            <option value="{{ session('tipoArchivo') }}">{{ session('tipoArchivo') }}</option>
                        </select>
                    </div>

                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn boton-12" id="btn_enviar_prefactura">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
