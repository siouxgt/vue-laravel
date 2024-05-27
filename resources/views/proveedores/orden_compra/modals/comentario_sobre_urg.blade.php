<div class="modal fade" id="comentario_sobre_urg" tabindex="-1" role="dialog" aria-labelledby="ComentariosSobreLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-1" id="ComentariosSobreLabel">Comentarios sobre URG</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body cajasElementos">
                @foreach ($comentarios as $key => $item)
                    @if ($key > 0 && $key < count($comentarios))
                        <hr>
                    @endif
                    <p class="text-2 font-weight-bold">{{ $item->nombre }}</p>
                    <p class="text-2 mt-2 text-justify">
                        {{ $item->comentario }}
                    </p>
                    <p class="text-2 font-weight-light font-italic mt-2">{{ $item->fecha }}</p>
                @endforeach
                @if (count($comentarios) === 0)
                    <div class="row justify-content-center align-items-center" style="height: 40vh;">
                        <div class="col-lg-12">
                            <h2 class="text-center">No existen comentarios</h2>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
