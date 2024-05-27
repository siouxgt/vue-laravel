<div class="modal fade" id="agregar_almacen" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="AgregarPersonaAlmacenLabel"><samp class="text-mensaje">Responsable Almacén</samp></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="frm_almacen">
                <div class="form-group">
                    <label for="inputAddress2">Clave del Centro Gestor</label>
                    <input type="text" class="form-control" id="ccg" name="ccg" placeholder="Clave" value="{{  auth()->user()->urg->ccg }}">
                </div>

                <div class="form-group">
                    <label for="exampleFormControlSelect1">Domicilio</label>
                    <select class="form-control" id="direcciones" name="direccion">
                    </select>
                </div>

                <div class="form-group">
                    <label for="responsable">Responsable de Almacén</label>
                    <input type="text" id="responsable" class="form-control" name="responsable" readonly>
                </div>

                <div class="form-group">
                    <label for="puesto">Puesto</label>
                    <input type="text" id="puesto" class="form-control" name="puesto" readonly>
                </div>
                      
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono" readonly>
                </div>
            </form>

            
        </div>
        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn boton-12" onclick="almacenSave();">Agregar</button>
        </div>
      </div>
    </div>
</div>