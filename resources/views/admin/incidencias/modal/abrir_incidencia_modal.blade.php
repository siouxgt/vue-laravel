<div class="modal fade" id="abrir_incidente_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="text-rojo modal-title" id="exampleModalLabel">Abrir una incidencia</h5>
        <button type="button" class="close text-rojo1" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body">
        <form id="frm_incidencia">
          <div class="form-group">
            <label for="usuario" class="col-form-label">Usuario</label>
            <select class="form-control col-12 text-1" required name="usuario" id="usuario">
              <option value="">Seleccione una opción...</option>
              <option value="1">Usuario</option>
              <option value="2">Proveedor</option>
            </select>
          </div>
          <div class="form-group">
            <label for="nombre" class="col-form-label">Nombre</label>
            <select class="form-control col-12 text-1" required name="nombre" id="nombre">
              <option value="">Seleccione una opción...</option>
            </select>
          </div>
          <div class="form-group">
            <label for="origen" class="col-form-label">Origen</label>
            <select class="form-control col-12 text-1" required name="origen" id="origen" onchange="idOrigen()">
              <option value="">Seleccione una opción...</option>
            </select>
          </div>
          <div class="form-group">
            <label for="id_origen" class="col-form-label">ID Origen</label>
            <select class="form-control col-12 text-1" required name="id_origen" id="id_origen">
              <option value="">Seleccione una opción...</option>
            </select>
          </div>
          <div class="form-group">
            <label for="escala" class="col-form-label">Escala</label>
            <select class="form-control col-12 text-1" required name="escala" id="escala" onchange="sanciones()">
              <option value="">Seleccione una opción...</option>
              <option value="Leve">Leve</option>
              <option value="Moderada">Moderada</option>
              <option value="Grave">Grave</option>
            </select>
          </div>
          <div class="form-group">
            <label for="sancion" class="col-form-label">Sanción</label>
            <select class="form-control col-12 text-1" required name="sancion" id="sancion" onchange="motivos()">
              <option value="">Seleccione una opción...</option>
            </select>
          </div>
          <div class="form-group">
            <label for="motivo" class="col-form-label">Motivo</label>
            <select class="form-control col-12 text-1" required name="motivo" id="motivo">
              <option value="0">Seleccione una opción...</option>
            </select>
          </div>
          <div class="form-group">
            <label for="descripcion" class="col-form-label">Descripción</label>
            <textarea class="form-control text-1" id="descripcion" rows="5" cols="10" name="descripcion" onkeydown="caracteres(this,'con_desc')" required ></textarea>
            <p class="form-text text-right" id="con_desc">0/1000 palabras</p>
          </div>
        </form>
      </div>
      <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-secondary bac-red text-blanco"  onclick="adminIncidenteSave();">Guardar</button>
      </div>
    </div>
    
  </div>
</div>