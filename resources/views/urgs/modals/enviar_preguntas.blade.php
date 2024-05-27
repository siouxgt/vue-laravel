<div class="modal fade" id="modal_enviar_preguntas" tabindex="-1" aria-labelledby="exampleModaPreguntasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title font-weight-bold text-1" id="exampleModaPreguntasLabel">Preguntas para el Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_enviar_pregunta" method="POST">
          <div class="form-group">
            <label for="exampleFormControlSelect1" class="text-1 font-weight-bold">Selecciona el tema de tu pregunta</label>
            <select class="form-control" id="tema_pregunta" name="tema_pregunta">
              <option value="Precio">Precio.</option>
              <option value="Características">Características.</option>
              <option value="Disponibilidad">Disponibilidad.</option>
              <option value="Presentación">Presentación.</option>
              <option value="Otro">Otro.</option>
            </select>
          </div>

          <div class="form-group">
            <label for="exampleFormControlTextarea1" class="text-1 font-weight-bold">Escribe tu pregunta</label>
            <textarea class="form-control" id="pregunta" name="pregunta" rows="3"></textarea>
          </div>
        </form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn boton-1" id="btn_guardar_pregunta">Enviar</button>
      </div>
    </div>
  </div>
</div>