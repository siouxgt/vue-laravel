<div class="modal fade" id="modal_comentarios_val_admin" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdrop_1Label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdrop_1Label">
                    <span class="titel-2">Validación administrativa</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                @if ($validacion != null)
                    <div class="row hr">
                        <div class="col">
                            <p class="titel-2">{{ $validacion[0]->nombre_producto }}</p>
                        </div>
                    </div>
                @else
                <div class="row">
                    <div class="col">
                        <p class="text-1">Este producto aún no ha sido evaluado administrativamente.</p>
                    </div>
                </div>
                @endif

                @foreach ($validacion as $admin)
                    <div class="row">
                        <div class="col">
                            <div class="row mt-3">
                                <div class="col-auto">
                                    <div class="mt-4 ml-3">
                                        @if ($admin->aceptada == true)
                                            <p class="indicador-count-card fa-solid fa-check"></p>
                                        @else
                                            <p class="indicador-count-card-3 fa-solid fa-xmark"></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-auto">
                                    @if ($admin->aceptada == true)
                                        <p class="text-1">Ficha aprobada</p>
                                    @else
                                        <p class="text-1">Ficha rechazada</p>
                                    @endif
                                    <p class="text-2">
                                        {{ \Carbon\Carbon::parse($admin->created_at)->format('d/m/Y') }}
                                    </p>
                                </div>
                                <div class="col-12">
                                    <p class="text-1">Comentario</p>
                                    <p class="text-2">{{ $admin->comentario }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach


            </div>
        </div>
    </div>
</div>
