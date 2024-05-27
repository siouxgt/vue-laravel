<div class="modal fade" id="modal_publica" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"><strong>Validación económica</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ml-3">
        <div class="row hr">
          <p class="titel-2">{{ $nombre->nombre_producto }}</p>
        </div>
        <div class="row">
          <p class="text-2">Este producto está listo para ser publicado. Al confirmar la acción estará disponible para las URG y no se podrá revertir la acción.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn boton-1" id="publicar_producto" onclick="publicarProducto()">Publicar</button>
        </div>
      </div>
    </div>
  </div>
</div>
