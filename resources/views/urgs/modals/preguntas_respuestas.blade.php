<div class="modal fade" id="mod_preguntas" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-1 font-weight-bold" id="staticBackdropLabel">
                    Preguntas sobre el producto
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body overflow-auto tamaño-1">
                <div id="miscroll" class="col-12 col-sm-12">

                    @for($i = 0; $i < count($ppr); $i++) 
                        <div class="row">
                            <div class="col-12">
                                <div class="text-center vl-2 col-1"></div>
                                <div class="col-12" style="top: -5rem;">
                                    <p class="text-1 font-weight-bold">{{ $ppr[$i]->tema_pregunta }}</p>
                                </div>
                                <div class="col-11" style="top: -4.8rem;">
                                    <p class="text-2">{{ $ppr[$i]->pregunta }}</p>
                                </div>
                                <div class="col-12" style="top: -4.5rem;">
                                    <p class="text-12 font-italic">{{ $ppr[$i]->nombre_urg }} - {{ $ppr[$i]->fecha_pregunta }}</p>
                                </div>
                            </div>
                            @if($ppr[$i]->respuesta != null)
                            <div class="col-12" style="top: -4rem;">
                                <div class="col-12">
                                    <p class="text-2 ml-4">{{$ppr[$i]->respuesta}}</p>
                                </div>
                                <div class="col-12">
                                    <p class="text-12 font-italic ml-4">{{ $ppr[$i]->nombre_proveedor }} - {{ $ppr[$i]->fecha_respuesta }}</p>
                                </div>
                            </div>
                            @endif
                            <hr>
                        </div>
                        @endfor
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>