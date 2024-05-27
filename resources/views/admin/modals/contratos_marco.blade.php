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
                <p class="text-1">Filtra productos por Contrato Marco</p>
                <div id="miscroll" class="col-12 col-sm-12">
                    <form action="" method="post" id="frm_filtro_cm">
                        @forelse ($contratosMarcos as $contrato)
                            <div class="row mt-2">
                                <div class="col-2 text-center">
                                    <input class="form-check-input text-carrusel defaultCheck" type="radio" name="cm" value="{{ $contrato->id_e }}" @if($activa == $contrato->id_e) checked @endif>
                                </div>
                                <div class="col-10">
                                    <p class="text-carrusel">{{ $contrato->nombre_cm }} - ({{ $contrato->total }})</p>
                                </div>
                            </div>
                        @empty
                            <div class="row mt-2">
                                <p class="text-carrusel"> Sin Contratos</p>
                            </div>
                        @endforelse
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="contrato()">Filtrar</button>
            </div>
        </div>
    </div>
</div>