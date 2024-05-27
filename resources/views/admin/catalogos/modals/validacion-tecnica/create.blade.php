<div class="modal fade" id="add_validador" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					{{-- <span aria-hidden="true">&times;</span> --}}
				</button>
			</div>
			<div class="modal-body">
				<form id="frm_validador">
					<div class="container">
						<div class="row align-items-center justify-content-center my-3">
							<div class="col-12 col-sm-4">
								<div class="form-group rfc-1">
									<label for="ccg">Clave Centro Gestor</label>
									<input type="text" id="ccg" name="ccg" class="form-control" placeholder="Clave centro gestor" onchange="cargaCg(this);">
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group">
									<label for="entidad">Entidad </label>
									<input type="text" id="entidad" name="entidad" class="form-control" readonly>
								</div>
							</div>
							<div class="col-12 col-sm-4 text-align-center">
								<div class="form-group">
									<label for="formGroupExampleInput">Activo</label>
									<div class="custom-control custom-switch">
										<label class="switch">
											<input type="checkbox" name="estatus_urg" checked value="1">
											<span class="slider round"></span>
										  </label>
									</div>
								</div>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="direccion">Área Validadora</label>
									<input type="text" id="direccion" name="direccion" class="form-control text-2">
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="siglas">Siglas del área validadora</label>
									<input type="text" id="siglas" name="siglas" class="form-control text-2">
								</div>
							</div>
						</div>

						<div class="scroll container" id="personal">
							
						</div>								
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" class="btn boton-1" id="store_validacion" onclick="save_validacion_create();">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>
