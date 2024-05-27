<div class="modal fade" id="productos_sustituir_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-rojo modal-title" id="exampleModalLabel">Productos por sustituir</h5>
        <button type="button" class="close text-rojo1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
        <form id="frm_sustitucion">
          <div class="form-group">
             <p class="text-1"><strong><span id="contador">0</span> de {{ count($bienes)}} Productos seleccionados</strong></p>

            <div class="cajasElementos">
              @foreach($bienes as $bien)
                <div class="row d-flex align-items-center">
                    <div class="col-1">
                      <div class="form-group row">
                        <div class="form-check mt-3">
                          <input type="checkbox" class="form-check-input" id="producto" name="producto[{{ $bien->id_e}}]" onclick="contador(this);">
                        </div>
                      </div>
                    </div>
                    <div class="col-11">
                        <p class="text-1">{{ $bien->nombre }} {{ $bien->cantidad }} {{ $bien->medida }}</p>
                    </div>
                </div>
              @endforeach
            </div>
            <hr>

            <label for="recipient-name" class="col-form-label">Motivo de la sustitución</label>
            <select class="form-control col-8 text-1" required name="motivo">
              <option value="">Seleccione una opción...</option>
              @foreach($combos as $combo)
                <option value="{{ $combo }}">{{ $combo }}</option>
              @endforeach
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Describe la situación</label>
            <textarea class="form-control text-1" id="message-text" rows="5" cols="10" name="descripcion" onkeydown="caracteres(this,'con_desc')" required></textarea>
            <p class="form-text text-right" id="con_desc">0/1000 palabras</p>
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-secondary bac-red text-blanco" onclick="acuseSustitucion()">Generar Acuse</button>
      </div>
    </div>
    
  </div>
</div>