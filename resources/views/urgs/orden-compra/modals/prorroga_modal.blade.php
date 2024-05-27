<div class="modal fade" id="prorroga_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-rojo modal-title" id="exampleModalLabel">Responder prorroga</h5>
        <button type="button" class="close text-rojo1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
        <form id="frm_prorroga">
          <div class="form-row">
              <div class="col-6">
                  <p class="text-1">¿Se acepta la prorroga?</p>
              </div>
              <div class="col-6">
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="aceptada" value="1" id="aceptadosi" required>
                      <label class="form-check-label" for="inlineRadio1">Sí</label>
                  </div>
                  <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="aceptada" value="0" id="aceptadono" required>
                      <label class="form-check-label" for="inlineRadio2">No</label>
                  </div>
              </div>                
          </div>
          <div id="cancelacion" class="ocultar">
            <div class="form-group">
              <label for="recipient-name" class="col-form-label text-1">Motivo de la cancelación</label>
              <select class="form-control col-8 text-1" required name="motivo">
                <option value="">Seleccione una opción...</option>
                <option value="Plazo demaciado largo">Plazo demaciado largo</option>
                <option value="Falta de comunicación">Falta de comunicación</option>
                <option value="Justificación no válida">Justificación no válida</option>
                <option value="Otro">Otro</option>
              </select>
            </div>
            <div class="form-group hr">
              <label for="descripcion" class="col-form-label">Describe la situación</label>
              <textarea class="form-control text-1" id="descripcion" rows="5" cols="10" name="descripcion" required onkeydown="caracteres(this,'con_desc')"></textarea>
              <p class="form-text text-right" id="con_desc">0/1000 palabras</p>
            </div>
          </div>
          <div class="form-group">
            <p class="text-1"> Datos del responsable de firmar la solicitud de prorroga</p>
          </div>
          <div class="form-group">
            <label for="nombre_firmante" class="col-form-label">Nombre completo</label>
            <input type="text" class="form-control text-1" id="nombre_firmante"name="nombre_firmante" required>
          </div>
          <div class="form-group">
            <label for="cargo_firmante" class="col-form-label">Cargo</label>
            <input type="text" class="form-control text-1" id="cargo_firmante"name="cargo_firmante" required>
          </div>
          <div class="form-group">
            <label for="correo_firmante" class="col-form-label">Correo</label>
            <input type="text" class="form-control text-1" id="correo_firmante"name="correo_firmante" required>
          </div>

          <input type="hidden" id="prorroga" name="prorroga">
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-secondary bac-red text-blanco "  onclick="responderProrrogaUpdate();">Responder</button>
      </div>
    </div>
    
  </div>
</div>