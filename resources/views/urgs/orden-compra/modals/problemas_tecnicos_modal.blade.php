<div class="modal fade" id="ProblemasTecnicos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="ProblemasTecnicosLabel"><samp class="text-mensaje">Problema técnico</samp></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
                <label for="exampleFormControlSelect1" class="text-1">Tipo de problema</label>
                <select class="form-control text-1" name="problema">
                  <option>Selecciona una opción</option>
                  <option value="Datos de facturación">Datos de facturación</option>
                  <option value="Datos Incorectos">Datos Incorectos</option>
                  <option value="Inconveniente con la página">Inconveniente con la página</option>
                  <option value="No se encuentra el RFC">No se encuentra el RFC</option>
                  <option value="Problemas al editar">Problemas al editar</option>
                  <option value="Otro">Otro</option>
                </select>
              </div>

              <div class="form-group">
                <label for="situacion" class="text-1">Describe la situación</label>
                <textarea class="form-control" id="situacion" name="situacion" rows="3" onkeydown="caracteres(this,'con_desc')"></textarea>
                <p class="form-text text-right" id="con_desc">0/1000 palabras</p>
              </div>
          </form>
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn boton-12">Enviar</button>
        </div>
      </div>
    </div>
  </div>