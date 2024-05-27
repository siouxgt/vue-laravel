<div class="modal fade" id="modal_dimensiones" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdrop_1Label" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdrop_1Label">
                    <p class="titel-2">Dimensiones</p>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_dimensiones" class="form-inline">
                    <div class="form-group col-12 d-flex justify-content-start">
                        <div class="col-3">
                            <p class="text-1">Largo:</p>
                        </div>
                        <div class="col-6 ml-2">                           
                            <input type="number" class="form-control" id="largo" name="largo" min="0" required value="@if($las_dimensiones[0]->dimensiones != null){{ $las_dimensiones[0]->dimensiones[0]->largo }}@endif">
                        </div>
                        <div class="col-2 ml-2">
                            <select id="unidad_largo" name="unidad_largo" class="form-control">
                                @php $unidadesMedidaLongitud = [ "m.", "cm.", "mm." ]; @endphp
                                @foreach($unidadesMedidaLongitud as $key => $item)
                                <option value="{{ ($key) }}" @if($las_dimensiones[0]->dimensiones != null) @if($las_dimensiones[0]->dimensiones[0]->unidad_largo == $key) selected='selected' @endif @elseif($key == 1) selected='selected' @endif>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-12 d-flex justify-content-start">
                        <div class="col-3">
                            <p class="text-1">Ancho:</p>
                        </div>
                        <div class="col-6 ml-2">
                            <input type="number" class="form-control" id="ancho" name="ancho" min="0" required value="@if($las_dimensiones[0]->dimensiones != null){{ $las_dimensiones[0]->dimensiones[0]->ancho }}@endif">
                        </div>
                        <div class="col-2 ml-2">
                            <select id="unidad_ancho" name="unidad_ancho" class="form-control">
                                @foreach($unidadesMedidaLongitud as $key => $item)
                                <option value="{{ ($key) }}" @if($las_dimensiones[0]->dimensiones != null) @if($las_dimensiones[0]->dimensiones[0]->unidad_ancho == $key) selected='selected' @endif @elseif($key == 1) selected='selected' @endif>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-12 d-flex justify-content-start">
                        <div class="col-3">
                            <p class="text-1">Alto:</p>
                        </div>
                        <div class="col-6 ml-2">
                            <input type="number" class="form-control" id="alto" name="alto" min="0" required value="@if($las_dimensiones[0]->dimensiones != null){{ $las_dimensiones[0]->dimensiones[0]->alto }}@endif">
                        </div>
                        <div class="col-2 ml-2">
                            <select id="unidad_alto" name="unidad_alto" class="form-control">
                                @foreach($unidadesMedidaLongitud as $key => $item)
                                <option value="{{ ($key) }}" @if($las_dimensiones[0]->dimensiones != null) @if($las_dimensiones[0]->dimensiones[0]->unidad_alto == $key) selected='selected' @endif @elseif($key == 1) selected='selected' @endif>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group col-12 d-flex justify-content-start">
                        <div class="col-3">
                            <p class="text-1 ">Peso</p>
                        </div>
                        <div class="col-6 ml-2">
                            <input type="number" class="form-control" id="peso" name="peso" min="0" required value="@if($las_dimensiones[0]->dimensiones != null){{ $las_dimensiones[0]->dimensiones[0]->peso }}@endif">
                        </div>
                        <div class="col-2 ml-2">
                            <select id="unidad_peso" name="unidad_peso" class="form-control">
                                @php $unidadesMedidaPeso = [ "t.", "kg.", "g." ]; @endphp
                                @foreach($unidadesMedidaPeso as $key => $item)
                                <option value="{{ ($key) }}" @if($las_dimensiones[0]->dimensiones != null) @if($las_dimensiones[0]->dimensiones[0]->unidad_peso == $key) selected='selected' @endif @elseif($key == 1) selected='selected' @endif>{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton-1" id="btn_guardar_dimensiones">Guardar</button>
            </div>
        </div>
    </div>
</div>