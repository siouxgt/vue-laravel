<div class="modal fade" id="responder_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-rojo modal-title" id="exampleModalLabel">Respuesta</h5>
        <button type="button" class="close text-rojo1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
        <form id="frm_respuesta">
          <div class="form-row">
              <div class="form-group">
                <label for="fecha_respuesta" class="font-weight-bold mr-2">Fecha de atención</label><br>
                <div class="col-12">
                  <div class="input-group date">
                    <input type="text" class="form-control text-1" name="fecha_respuesta" id="fecha_respuesta" value="{{ date('d/m/Y') }}" required readonly>
                    <span class="input-group-addon input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div>             
          </div>
          <div class="form-group">
            <label for="escala" class="col-form-label">Escala</label>
            <select class="form-control col-12 text-1" required name="escala" id="escala">
              <option value="0">Seleccione una opción...</option>
              <option value="Leve">Leve</option>
              <option value="Moderada">Moderada</option>
              <option value="Grave">Grave</option>
            </select>
          </div>
          <div class="form-group">
            <label for="sancion" class="col-form-label">Sanción</label>
            <select class="form-control col-12 text-1" required name="sancion" id="sancion">
              <option value="">Seleccione una opción...</option>
            </select>
          </div>
          <div class="form-group">
            <label for="respuesta" class="col-form-label">Respuesta</label>
            <textarea class="form-control text-1" id="respuesta" rows="5" cols="10" name="respuesta" onkeydown="caracteres(this,'con_resp')" required ></textarea>
            <p class="form-text text-right" id="con_resp">0/1000 palabras</p>
          </div>
          <input type="hidden" id="incidente" name="incidente">
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-secondary bac-red text-blanco "  onclick="respuestaSave();">Enviar</button>
      </div>
    </div>
    
  </div>
</div>