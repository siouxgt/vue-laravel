<div class="modal fade" id="conformidad_incidencia" tabindex="-1" role="dialog" aria-labelledby="cerrarIncidenciaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="cerrarIncidenciaLabel">
                    <spam class="text-mensaje">Cerrar incidencia</spam>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_conformidad">
                    <p class="text-2">Fecha de atención</p>
                    <input type="text" class="form-control text-2" readonly value="{{ date('d/m/Y')}}" name="fecha">

                    <div class="form-group mt-2">
                        <label for="exampleFormControlSelect1">¿Estas conforme con la respuesta?</label>
                        <select class="form-control col-3 text-2" name="conformidad" id="conformidad">
                            <option value="Sí">Sí</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="form-group ocultar" id="div_comentario">
                        <label for="comentario" class="col-form-label">Comentario</label>
                        <textarea class="form-control text-1" id="comentario" rows="5" cols="10" name="comentario" onkeydown="caracteres(this,'con_com')" required></textarea>
                        <p class="form-text text-right" id="con_com">0/1000 palabras</p>
                    </div>
                    <input type="hidden" name="incidencia" id="incidencia">
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn boton-12" onclick="saveConformidad()">Cerrar incidencia</button>
            </div>
        </div>
    </div>
</div>