<div class="modal fade" id="cancelar_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-rojo modal-title" id="exampleModalLabel">Cancelar compra</h5>
        <button type="button" class="close text-rojo1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
        <form id="frm_cancel">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Motivo de la cancelación</label>
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
            <textarea class="form-control text-1" id="message-text" rows="5" cols="10" name="descripcion" onkeydown="caracteres(this,'con_desc')" required ></textarea>
            <p class="form-text text-right" id="con_desc">0/1000 palabras</p>
          </div>
          <input type="hidden" id="seccion" name="seccion">
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-secondary bac-red text-blanco "  onclick="cancelarSave();">Cancelar compra</button>
      </div>
    </div>
    
  </div>
</div>