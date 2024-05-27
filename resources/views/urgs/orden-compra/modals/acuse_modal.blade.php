<div class="modal fade" id="acuse_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-rojo modal-title" id="exampleModalLabel">Subir Acuse</h5>
        <button type="button" class="close text-rojo1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
        <form id="frm_acuse">
          <div class="form-row">
              <div class="col-12">
                  <label for="acuse" class="text-1">Adjuntar Acuse de recepción de prórroga</label>
                  <input type="file" class="form-control" id="acuse" accept=".pdf" name="acuse" required>
              </div>                
          </div>
          <input type="hidden" id="prorroga" name="prorroga">
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-secondary bac-red text-blanco "  onclick="subirAcuseUpdate();">Subir</button>
      </div>
    </div>
    
  </div>
</div>