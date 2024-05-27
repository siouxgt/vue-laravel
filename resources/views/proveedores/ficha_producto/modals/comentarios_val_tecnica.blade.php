<div class="modal fade" id="modal_comentarios_val_tec" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdrop_1Label" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdrop_1Label">
                    <span class="titel-2">Validación técnica</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row hr">
                    <div class="col">
                        <p class="titel-2">{{ $nombre }}</p>
                    </div>
                </div>
                @if ($tecnicas == null)
                    <div class="row">
                        <div class="col">
                            <p class="text-1">Este producto no requiere validación técnica.</p>
                        </div>
                    </div>
                @endif
                @foreach ($tecnicas as $tec)
                    <div class="row">
                        <div class="row mt-3">
                            <div class="col-3">
                                <div class="mt-4 text-center ml-3">
                                    @if ($tec->aceptada == true)
                                        <p class="indicador-count-card fa-solid fa-check text-center"></p>
                                    @else
                                        <p class="indicador-count-card-3 fa-solid fa-xmark text-center"></p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-7">
                                @if ($tec->aceptada == true)
                                    <p class="text-1 mt-2">Ficha aprobada</p>
                                @else
                                    <p class="text-1 mt-2">Ficha rechazada</p>
                                @endif
                                <p class="text-2"> {{ \Carbon\Carbon::parse($tec->created_at)->format('d/m/Y') }} </p>
                            </div>
                            <div class="col-12">
                                <p class="text-2"> Comentario </p>
                                <p class="text-2">{{ $tec->comentario }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
