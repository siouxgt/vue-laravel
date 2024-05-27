<div class="modal fade" id="edit_validador" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"></h5>
				<button type="button"class="btn-close" data-bs-dismiss="modal" aria-label="Close">
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
									<input type="text" id="ccg" name="ccg" class="form-control" placeholder="Clave centro gestor" onchange="cargaCg(this);" value="{{ $validacion->urg->ccg }}" readonly>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group">
									<label for="entidad">Entidad </label>
									<input type="text" id="entidad" name="entidad" class="form-control" value="{{ $validacion->urg->nombre }}" readonly>
								</div>
							</div>
							<div class="col-12 col-sm-4 text-align-center">
								<div class="form-group">
									<label for="formGroupExampleInput">Activo</label>
									<div class="custom-control custom-switch">
										<label class="switch">
											<input type="checkbox"  @if($validacion->estatus) checked @endif value="1" disabled>
											<span class="slider round"></span>
										</label>
										<input type="hidden" name="estatus_urg" @if($validacion->estatus)  value="1" @endif >
									</div>
								</div>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="direccion">Área Validadora</label>
									<input type="text" id="direccion" name="direccion" class="form-control text-2" value="{{ $validacion->direccion }}">
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="siglas">Siglas del área validadora</label>
									<input type="text" id="siglas" name="siglas" class="form-control text-2" value="{{ $validacion->siglas }}">
								</div>
							</div>
						</div>
	
						{{-- @if( $validacion->responsable->personal != [] )
							<div class="scroll" id="personal" style="height: 300px;">
								@foreach( $validacion->responsable->personal as $responsable)
									<div class="row">
			                           <div class="col-12 col-sm-2">
			                                <div class="form-group">
			                                    <label for="nombre">Nombre</label>
			                                </div>
			                            </div>
			                            <div class="col-12 col-sm-4">
			                                <div class="form-group">
			                                    <input type="text" id="nombre" name="nombre[]" class="form-control" readonly value="{{ $responsable->nombre}}">
			                                    <input type="hidden" name="rfc[]" value="{{ $responsable->rfc }}">
			                                </div>
			                            </div>
			                            <div class="col-12 col-sm-1">
			                                <div class="form-group">
			                                    <label for="formGroupExampleInput">Activo</label>
			                                </div>
			                            </div>
			                            <div class="col-12 col-sm-2 text-align-center">
			                                <div class="form-group">
			                                    <div class="custom-control custom-switch">
			                                        <label class="switch">
			                                        	{{ $responsable->seleccionado }}
			                                            <input type="checkbox" name="estatus[{{ $responsable->rfc }}]" @if($responsable->seleccionado) checked @endif value="1">
			                                            <span class="slider round"></span>
			                                          </label>
			                                    </div>
			                                </div>
			                            </div>
	                    			</div> 
				                    <div class="row">
				                        <div class="col-12 col-sm-2">
				                            <div class="form-group">
				                                <label for="cargo">Cargo</label>
				                            </div>
				                        </div>
				                        <div class="col-12 col-sm-4">
				                            <div class="form-group">
				                                <input type="text" id="cargo" name="cargo[]" class="form-control" readonly value="{{ $responsable->cargo }}">
				                            </div>
				                        </div>
				                    </div>
				                    <div class="row">
				                        <div class="col-12 col-sm-2">
				                            <div class="form-group">
				                                <label for="permiso">Permiso</label>
				                            </div>
				                        </div>
				                        <div class="col-12 col-sm-4">
				                            <div class="form-group">
				                            	<select name="permiso[]" class="form-control text-1">
				                            	    <option value="{{ $responsable->permiso }}">{{ $responsable->permiso }}</option>
				                            	    <option value="tecnico">Técnico</option>
				                            	</select> 
				                            </div>
				                        </div>
				                    </div>
	                   			 	<hr> 
								@endforeach
							</div>
						@else
							<div class="scroll" id="personal" style="height: 50px;">
								<div class="row">
                                    <div class="col-12 col-sm-12">
                                        <div class="form-group">
                                            <p class="text-center">Sin usuarios registrados en Acceso Unico</p>
                                        </div>
                                    </div>
                                </div>
							</div>
						@endif --}}
						<input type="hidden" id="id" name="id" value="{{ $validacion->id_e }}">
					</div>
				</form>
				<div class="modal-footer">
					<button type="button" class="btn boton-1" id="store_validacion" onclick="validacion_update();">Actualizar</button>
				</div>
			</div>
		</div>
	</div>
</div>
