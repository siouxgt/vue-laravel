<div class="modal fade" id="rechazados" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-rojo modal-title" id="exampleModalLabel">Productos rechazados</h5>
          <button type="button" class="close text-rojo1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
        <div>
          <ul class="list-group list-group-flush">
            <li class="list-group-item border bg-white">
              <div class="row">
                <div class="col-12">
                  <p class="font-weight-bold mt-2">{{ count($bienes) }} Productos que no se entregarán</p>
                  <ul>
                    @foreach($bienes as $key => $bien)
                      <li class="mt-2 ml-3"> {{ $bien->cantidad }} {{ $bien->medida }} {{ $bien->nombre }}</li>
                    @endforeach
                  </ul>                    
                </div>
              </div>
            </li>
          </ul>
        </div>
        <br>
        @if($bienes[0]->motivo_rechazo)
          <div class="form-group">
            <p class="font-weight-bold">Motivo</p>
            <p>{{ $bienes[0]->motivo_rechazo }}</p>
            <br>
            <p class="font-weight-bold">Mensaje</p>
            <p>{{ $bienes[0]->descripcion_rechazo }}</p>  
          </div>
        @endif
      </div>  
    </div>
  </div>
</div>