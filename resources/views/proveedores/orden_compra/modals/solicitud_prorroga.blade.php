<div class="modal fade" id="modal_solicitud_prorroga" data-backdrop="static" data-keyboard="false"
    aria-labelledby="modal_solicitud_prorrogaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header badge-light">
                <h5 class="modal-title text-rojo" id="modal_solicitud_prorrogaLabel">Solicitud de Prórroga</h5>
                <button type="button" class="close text-rojo" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_solicitud_prorroga">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 col-sm-3">
                            <div class="form-group">
                                <label for="fecha_solicitud" class="font-weight-bold">1. Fecha de solicitud</label>
                                <input class="form-control" type="date" value="{{ $fecha_hoy }}"
                                    id="fecha_solicitud" name="fecha_solicitud"
                                    style="max-width: 150px; min-width: 150px;" min="{{ $fecha_hoy }}" required
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p class="text-1 font-weight-bold mt-3">2. Días solicitados</p>
                            <p class="text-2 text-justify">La Prórroga se debe solicitarse durante la vigencia del
                                contrato. El envío de la
                                solicitud no representa su aceptación
                                ya que esta sujeta a revisión y aprobación.</p>
                        </div>

                        <div class="form-group col mt-2">
                            <input type="number" class="form-control text-center" id="dias_solicitados"
                                name="dias_solicitados" style="max-width: 150px; min-width: 150px;" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group">
                            <div class="col">
                                <label for="fecha_compromiso_entrega" class="font-weight-bold">3. Fecha compromiso de
                                    entrega</label>
                            </div>
                            <div class="col">
                                <input type="date" class="form-control font-weight-bold text-1"
                                    id="fecha_compromiso_entrega" name="fecha_compromiso_entrega"
                                    style="max-width: 150px; min-width: 150px;" min="{{ $fecha_hoy }}" required
                                    readonly>
                            </div>
                        </div>
                    </div>

                    <hr class="mz-2">

                    <div class="row">
                        <div class="col">
                            <p class="text-1 font-weight-bold mt-2">4. Indica el motivo de la solicitud</p>

                            <div class="form-group">
                                <label class="text-1" for="descripcion_situacion_solicitud">Describe la situación.
                                    También puedes adjuntar un documento PDF no mayor a 5MB que
                                    justifique la solicitud.</label>
                                <textarea class="form-control text-1" id="descripcion_situacion_solicitud" name="descripcion_situacion_solicitud"
                                    placeholder="Describe la situación..." rows="3" maxlength="1000" required></textarea>
                            </div>
                            <p class="float-right text-2" id="numero_caracteres_motivo_solicitud">0/1000</p>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="documento_justificacion" class="font-weight-bold">¿Quieres adjuntar algún
                                    documento que justifique la Prórroga?</label>
                                <input type="file" class="form-control-file" id="documento_justificacion"
                                    name="documento_justificacion" accept=".pdf">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center mt-1">
                    <button type="submit" class="btn boton-12" id="btn_generar_solicitud_prorroga">Generar
                        solicitud</button>
                </div>
            </form>
        </div>
    </div>
</div>
