<div class="modal fade" id="modal_eco" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><strong>Validación económica</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ml-3">
          <div class="row hr">
            <p class="titel-2">{{ $nombre }}</p>
          </div>
        @foreach($economicas as $economica)
            <div class="row mt-3">
              <div class=".col-3">
                <div class="mt-4 text-center ml-3">
                  @if($economica->validado == true) 
                    <p class="indicador-count-card fa-solid fa-check text-center"></p>
                  @else
                    <p class="indicador-count-card-3 fa-solid fa-xmark text-center"></p>
                    @endif
                </div>
              </div>
              <div class="col-7">
                @if($economica->validado == true)
                  <p class="text-1 mt-2">Ficha aprobada</p>
                @else
                  <p class="text-1 mt-2">Ficha rechazada</p>
                @endif
                  <p class="text-2"> {{ \Carbon\Carbon::parse($economica->created_at)->format('d/m/Y') }} </p>
                  <p class="text-2"> Intento {{ $economica->intento }} </p>
              </div>
            </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
