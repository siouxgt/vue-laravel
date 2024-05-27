<div class="modal fade" id="edit_adhesion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="frm_adhesion">
					<div class="container">
						<div class="row">
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="fecha_adhesion" class="text-1 mx-3">Fecha adhesión</label>
									<div class="input-group date">
										<input type="text" class="form-control text-1" name="fecha_adhesion" id="fecha_adhesion" required @if($habilitarProveedor->fecha_adhesion) value="{{ $habilitarProveedor->fecha_adhesion->format('d/m/Y') }}" @endif>
											<span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="archivo_adhesion" class="text-1 mx-3">Contrato de adhesión</label>
									<input type="file" class="form-control text-1" id="archivo_adhesion" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="archivo_adhesion" @if(!$habilitarProveedor->archivo_adhesion) required @endif>
									@if($habilitarProveedor->archivo_adhesion)
										<label class="text-1 mt-3 mx-3">Archivo actual:</label> <a href="{{ asset('storage/contrato-adhesion/'.$habilitarProveedor->archivo_adhesion) }}" target="_blank" class="text-1">{{ $habilitarProveedor->archivo_adhesion }}</a>
									@endif
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-sm-4 text-align-center">
								<div class="form-group">
									<label for="formGroupExampleInput">Habilitar en contrato marco</label>
									<div class="custom-control custom-switch">
										<label class="switch">
											<input type="checkbox" name="habilitado" @if($habilitarProveedor->habilitado) checked @endif value="1">
											<span class="slider round"></span>
										  </label>
									</div>
								</div>
							</div>
						</div>						
					</div>
					<input type="hidden" name="id_adhesion" id="id_adhesion" value="{{ $habilitarProveedor->id_e }}">
				</form>
				<div class="modal-footer">
					<button type="button" class="btn boton-1" id="update_adhesion" onclick="update_adhesion();">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>
