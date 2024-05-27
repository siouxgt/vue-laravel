<div class="modal fade" id="sap_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-rojo modal-title" id="exampleModalLabel">Ingreso de factura en SAP GRP</h5>
        <button type="button" class="close text-rojo1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
        <form id="frm_sap">
          <div class="form-row">
              <div class="form-group">
                <label for="fecha_sap" class="font-weight-bold mr-2">Fecha de ingreso</label><br>
                <div class="col-12">
                  <div class="input-group date">
                    <input type="text" class="form-control text-1" name="fecha_sap" id="fecha_sap" value="{{ date('d/m/Y') }}" required>
                    <span class="input-group-addon input-group-text"><i class="fa fa-calendar"></i></span>
                  </div>
                </div>
              </div>             
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-secondary bac-red text-blanco "  onclick="aceptarFacturaSap();">Guardar</button>
      </div>
    </div>
    
  </div>
</div>