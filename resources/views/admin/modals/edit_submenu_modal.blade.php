<div class="modal fade" id="add_submenu" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					{{-- <span aria-hidden="true">&times;</span> --}}
				</button>
			</div>
			<div class="modal-body">
				<form id="frm_submenu">
					<div class="container">

						<div class="row mb-4 my-3">
                            <div class="col-12 col-md-4">
                                <div class="input-group date">
                                    <label for="fecha_inicio" class="text-1 mx-3">Fecha de inicio</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control text-1" id="fecha_inicio" autocomplete="off" required>
                                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="input-group date">
                                    <label for="fecha_fin" class="text-1 mx-3">Fecha de fin</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control text-1" id="fecha_fin" autocomplete="off" required>
                                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<input type="hidden" name="submenu_id" id="submenu_id" value="{{ $submenu->id_e }}">
					<input type="hidden" name="seccion" id="seccion">					
				</form>
				<div class="modal-footer">
					<button type="button" class="btn boton-1" id="store_validacion" onclick="update_submenu();">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>
