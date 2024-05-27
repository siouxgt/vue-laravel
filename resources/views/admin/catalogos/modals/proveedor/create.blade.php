<div class="modal fade" id="add_proveedor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
					{{-- <span aria-hidden="true">&times;</span> --}}
				</button>
			</div>
			<div class="modal-body">
				<ul id="msg"></ul>
				<form id="frm_proveedor">
					<div class="container m-1">
						<div class="row align-items-end  mb-1">
							<div class="col-12 col-sm-4">
								<div class="rfc-1">
									<label for="rfc">RFC</label>
									<input type="text" id="rfc" name="rfc" class="form-control" placeholder="Escribe tu RFC" onchange="proveedor(this);">
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group">
									<label for="folio_padron">Folio Padrón Proveedores </label>
									<input type="text" id="folio_padron" name="folio_padron" class="form-control" readonly>
								</div>
							</div>
							<div class="col-12 col-sm-4 text-align-center">
								<div class="float-end">
									<label for="formGroupExampleInput">Activo</label>
									<div class="custom-control custom-switch">
										<label class="switch">
											<input type="checkbox" name="estatus" checked value="1">
											<span class="slider round"></span>
										  </label>
									</div>
								</div>
							</div>
						</div>
						<div class="row mb-1">
							<div class="col-12 col-sm-12">
								<div class="form-group">
									<label for="nombre">Nombre</label>
									<input type="text" id="nombre" name="nombre" class="form-control" readonly>
								</div>
							</div>
						</div>
						<div class="row mb-1">
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="persona">Persona</label>
									<input type="text" id="persona" name="persona" class="form-control" readonly>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="nacionalidad">Nacionalidad</label>
									<input type="text" id="nacionalidad" name="nacionalidad" class="form-control" readonly>
								</div>
							</div>
						</div>
						<div class="row mb-1">
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="mipyme">MIPYME</label>
									<input type="text" id="mipyme" name="mipyme" class="form-control" readonly>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="tipo_pyme">Tipo de PYME</label>
									<input type="text" id="tipo_pyme" name="tipo_pyme" class="form-control" readonly>
								</div>
							</div>
						</div>
						<hr>
						<div class="row mb-1">
							<div class="col-12 col-sm-12">
								<div class="form-group">
									<label for="nombre_completo">Nombre completo del Representante legal</label>
									<input type="text" id="nombre_completo" class="form-control" readonly>
								</div>
							</div>
						</div>
						<div class="row mb-1">
							<div class="col-12 col-sm-12">
								<div class="form-group">
									<label for="direccion">Domicilio del Representante legal</label>
									<input type="text" id="direccion"  class="form-control" readonly>
								</div>
							</div>
						</div>
						<div class="row align-items-end mb-1">
							<div class="col-3 col-sm-3">
								<div class="form-group">
									<label for="telefono_legal">Número fíjo</label>
									<input type="text" id="telefono_legal" name="telefono_legal" class="form-control" readonly>
								</div>
							</div>
							<div class="col-3 col-sm-3">
								<div class="form-group">
									<label for="extension_legal">Extensión</label>
									<input type="text" id="extension_legal" name="extension_legal" class="form-control" readonly>
								</div>
							</div>
							<div class="col-3 col-sm-3">
								<div class="form-group">
									<label for="celular_legal">Número celular</label>
									<input type="text" id="celular_legal" name="celular_legal" class="form-control" readonly>
								</div>
							</div>
							<div class="col-3 col-sm-3">
								<div class="form-group">
									<label for="correo_legal">Correo electrónico</label>
									<input type="email" id="correo_legal" name="correo_legal" class="form-control" readonly>
								</div>
							</div>

							<input type="hidden" id="constancia" name="constancia">
							<input type="hidden" id="nombre_legal" name="nombre_legal">
							<input type="hidden" id="primer_apellido_legal" name="primer_apellido_legal">
							<input type="hidden" id="segundo_apellido_legal" name="segundo_apellido_legal">
							<input type="hidden" id="rfc_legal" name="rfc_legal">
							<input type="hidden" id="codigo_postal" name="codigo_postal">
							<input type="hidden" id="colonia" name="colonia">
							<input type="hidden" id="alcaldia" name="alcaldia">
							<input type="hidden" id="entidad_federativa" name="entidad_federativa">
							<input type="hidden" id="pais" name="pais">
							<input type="hidden" id="tipo_vialidad" name="tipo_vialidad">
							<input type="hidden" id="vialidad" name="vialidad">
							<input type="hidden" id="numero_exterior" name="numero_exterior">
							<input type="hidden" id="numero_interior" name="numero_interior">
							<input type="hidden" id="imagen" name="imagen">
							<input type="hidden" id="acta_identidad" name="acta_identidad">
							<input type="hidden" id="fecha_constitucion_identidad" name="fecha_constitucion_identidad">
							<input type="hidden" id="titular_identidad" name="titular_identidad">
							<input type="hidden" id="num_notaria_identidad" name="num_notaria_identidad">
							<input type="hidden" id="entidad_identidad" name="entidad_identidad">
							<input type="hidden" id="num_reg_identidad" name="num_reg_identidad">
							<input type="hidden" id="fecha_reg_identidad" name="fecha_reg_identidad">
							<input type="hidden" id="num_instrumento_representante" name="num_instrumento_representante">
							<input type="hidden" id="titular_representante" name="titular_representante">
							<input type="hidden" id="num_notaria_representante" name="num_notaria_representante">
							<input type="hidden" id="entidad_representante" name="entidad_representante">
							<input type="hidden" id="num_reg_representante" name="num_reg_representante">
							<input type="hidden" id="fecha_reg_representante" name="fecha_reg_representante">

						</div>
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" class="btn boton-1" id="store_proveedor" onclick="save_proveedor_create();">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>