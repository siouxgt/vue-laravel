<div class="modal fade" id="solicitar_cambios_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-rojo modal-title" id="exampleModalLabel">Datos incorrectos</h5>
        <button type="button" class="close text-rojo1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
        <form id="frm_solicitud">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Tipo de dato por corregir</label>
            <select class="form-control col-8 text-1" required name="dato_corregir">
              <option value="">Seleccione una opción...</option>
              @foreach($combos as $combo)
                <option value="{{ $combo }}">{{ $combo }}</option>
              @endforeach
              <option value="Otro">Otro</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Descrión del cambio</label>
            <textarea class="form-control text-1" id="message-text" rows="5" cols="10" name="descripcion" onkeydown="caracteres(this,'con_desc')" required></textarea>
            <p class="form-text text-right" id="con_desc">0/1000 palabras</p>
          </div>
          <input type="hidden" id="tipo_factura" name="tipo_factura">
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-secondary bac-red text-blanco"  onclick="solicitarCambioSave();">Solicitar cambios</button>
      </div>
    </div>
    
  </div>
</div>