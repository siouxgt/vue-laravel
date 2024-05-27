<div class="modal fade" id="modal_add_admin" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><strong>Validación administrativa</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body ml-3">
                <div class="row hr">
                    <p class="titel-2">{{ $nombre->nombre_producto }}</p>
                </div>
                <form id="frm_admin">
                    <div class="form-row align-items-center d-flex">
                        <div class="col-4">
                            <p class="text-1">¿Se acepta la ficha?</p>
                        </div>
                        <div class="col-3">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="aceptada" value="1" required>
                                <label class="form-check-label" for="inlineRadio1">Sí</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="aceptada" value="0" required>
                                <label class="form-check-label" for="inlineRadio2">No</label>
                            </div>
                        </div>                
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="fecha_revision" class="text-1">Fecha de revisión</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control text-1" name="fecha_revision" id="fecha_revision" value="{{ date('d/m/Y') }}" autocomplete="off" required>
                                    <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="comentario" class="text-1">Comentario para el proveedor (Obligatorio)</label>
                            <textarea class="form-control text-1" rows="3" name="comentario" required></textarea>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn boton-1" id="store_validacion_admin" onclick="add_admin()">Guardar</button>
                </div>
                <hr/>
                @foreach($administrativas as $admin)
                    <div class="row">
                        <div class="row mt-3">
                          <div class=".col-3">
                            <div class="mt-4 text-center ml-3">
                              @if($admin->aceptada == true) 
                                <p class="indicador-count-card fa-solid fa-check text-center"></p>
                              @else
                                <p class="indicador-count-card-3 fa-solid fa-xmark text-center"></p>
                                @endif
                            </div>
                          </div>
                          <div class="col-7">
                            @if($admin->aceptada == true)
                              <p class="text-1 mt-2">Ficha aprobada</p>
                            @else
                              <p class="text-1 mt-2">Ficha rechazada</p>
                            @endif
                              <p class="text-2"> {{ \Carbon\Carbon::parse($admin->created_at)->format('d/m/Y') }} </p>
                          </div>
                          <div class="col-12">
                              <p class="text-2"> Comentario </p>
                              <p class="text-2">{{ $admin->comentario }}</p>
                          </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
