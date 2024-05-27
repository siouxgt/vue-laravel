<div class="modal fade" id="modal_productos_cm" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-1 font-weight-bold" id="staticBackdropLabel">
                    Productos del Contrato Marco
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body tamaño">
                <p class="text-1">Filtra la información por CLAVE CABMSCDMX</p>
                <div id="miscroll" class="col-12 col-sm-12">
                    <form action="" method="post" id="frm_filtros_cabms">
                        @for($i = 0; $i < count($catp); $i++) <!-- -->
                            @if($catp[$i]->total != 0)
                                <div class="row mt-2">
                                    <div class="col-2 text-center">
                                        <input class="form-check-input text-carrusel defaultCheck" type="radio" name="cabms" value="{{ $catp[$i]->cabms }}" id="defaultCheck{{$i}}" @if($la_cabms == $catp[$i]->cabms) checked @endif>
                                    </div>
                                    <div class="col-10">
                                        <p class="text-carrusel">{{ $catp[$i]->cabms }} - {{ $catp[$i]->descripcion }} ({{ $catp[$i]->total }})</p>
                                    </div>
                                </div>

                            @else
                                <div class="row mt-2">
                                    <div class="col-2 text-center">
                                    </div>
                                    <div class="col-10">
                                        <p class="text-1">{{ $catp[$i]->cabms }} - {{ $catp[$i]->descripcion }} ({{ $catp[$i]->total }})</p>
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="filtrarPorCabms">Filtrar</button>
            </div>
        </div>
    </div>
</div>