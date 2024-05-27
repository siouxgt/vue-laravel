<div class="modal fade" id="modal_mensaje" tabindex="-1" aria-labelledby="exampleModaPreguntasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title font-weight-bold text-1">Enviar Mensaje</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="frm_mensaje">
          <div class="form-group">
            <label for="asunto" class="text-1 font-weight-bold">Asunto</label>
            <textarea class="form-control" id="asunto" name="asunto" rows="2" required onkeydown="caracteres(this,'con_asunto',100)"></textarea>
            <p class="form-text text-right" id="con_asunto">0/100 palabras</p>
          </div>

          <div class="form-group">
            <label for="mensaje" class="text-1 font-weight-bold">Mensaje</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="3" required onkeydown="caracteres(this,'con_mensaje',1000)"></textarea>
            <p class="form-text text-right" id="con_mensaje">0/1000 palabras</p>
          </div>

          <div class="form-group">
            <label for="imagen" class="text-1">Adjuntar imagen </label>
            <input type="file" class="form-control" id="imagen" accept="image/*" name="imagen">
          </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn boton-1" onclick="storeMensaje()">Enviar</button>
      </div>
    </div>
  </div>
</div>