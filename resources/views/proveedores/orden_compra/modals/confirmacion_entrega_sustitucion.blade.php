<div class="modal fade" id="modal_confirmacion_entrega_sustitucion" data-backdrop="static" data-keyboard="false"
    role="dialog" aria-labelledby="modal_confirmacion_entrega_sustitucionLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header badge-light">
                <h5 class="modal-title" id="modal_confirmacion_entrega_sustitucionLabel">
                    <span class="text-rojo">Confirmación de entrega</span>
                </h5>
                <button type="button" class="close text-rojo" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_confirmacion_entrega_sustitucion">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fecha_entrega_almacen" class="font-weight-bold mr-2">1. Fecha de entrega en
                            almacén</label>
                        <input class="form-control" type="date" onfocus="this.showPicker()"
                            id="fecha_entrega_almacen" name="fecha_entrega_almacen" min="{{ $fecha_hoy }}"
                            value="{{ $fecha_hoy }}" required readonly>
                    </div>

                    <div class="form-group mt-3">
                        <label for="nota_remision" class="font-weight-bold mr-2">2. Adjuntar Nota de
                            remisión</label>
                        <input type="file" class="form-control" id="nota_remision" name="nota_remision"
                            accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button class="btn boton-12" type="button"
                        id="btn_guardar_confirmacion_entrega_sustitucion">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
