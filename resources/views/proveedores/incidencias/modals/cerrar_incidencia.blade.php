<div class="modal fade" id="modal_cerrar_incidencia" tabindex="-1" role="dialog" data-backdrop="static"
    data-keyboard="false" aria-labelledby="cerrarIncidencia-1Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="cerrarIncidencia-1Label">
                    <span class="text-mensaje">Cerrar incidencia</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_cerrar_incidencia">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="id_incidencia" value="{{ $incidencia->id_e }}">
                    <div class="form-group">
                        <label for="fecha_cierre" class="font-weight-bold mr-2">Fecha de cierre</label>
                        <input type="date" class="form-control" id="fecha_cierre" name="fecha_cierre"
                            min="{{ $incidencia->created_at->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}" value="{{  \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="conformidad" class="font-weight-bold">¿Estas conforme con la respuesta?</label>
                        <select class="form-control text-2" style="width: 100px;" id="conformidad" name="conformidad"
                            required>
                            <option value="si">Sí</option>
                            <option value="no">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="comentario" class="font-weight-bold">Si contestaste que no, indica la razón.</label>
                        <textarea class="form-control text-2" id="comentario" name="comentario" rows="4" maxlength="1000"
                            placeholder="Proporciona un comentario si no estás de acuerdo con la respuesta dada."></textarea>
                    </div>

                    <p class="float-right" style="margin-top: -0.8rem;" id="contador_caracteres">0/1000</p>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn boton-12" id="btn_cerrar_incidencia">Cerrar incidencia</button>
            </div>
        </div>
    </div>
</div>
