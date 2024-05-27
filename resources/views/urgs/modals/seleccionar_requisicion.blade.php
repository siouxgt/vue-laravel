<div class="modal fade" id="modal_seleccionar_requisicion" tabindex="-1" role="dialog" aria-labelledby="exampleModalSelecReqLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-rojo-titulo" id="exampleModalSelecReqLabel">Selecciona una Requisición</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 align-self-center">
                        <i class="fa-solid fa-triangle-exclamation numValida-rojo ml-5"></i>
                    </div>
                    <div class="col-9">
                        <p class="text-1">
                            Este producto aparece en distintas requisiciones.
                            Para registrar el producto, selecciona una.
                        </p>
                    </div>
                    <div class="col-12">
                        <form class="form-inline">
                            <legend class="col-form-label text-3 font-weight-bold col-4">ID Requisición</legend>
                            <select class="form-control col-8" id="select_requisiciones">
                                @for($i = 0; $i < count($datos); $i++) 
                                    <option value="{{$datos[$i]->id_e}}">{{$datos[$i]->requisicion}} - {{$datos[$i]->objeto_requisicion}}</option>
                                    @endfor
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton-1" id="btn_guardar_requisicion">Guardar</button>
            </div>
        </div>
    </div>
</div>