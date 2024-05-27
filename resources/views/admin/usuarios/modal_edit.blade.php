<div class="modal fade" id="edit_usuario" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="frm_usuario">
					<div class="container">
						<div class="row">
							<div class="col-12 col-sm-4">
								<div class="form-group rfc-1">
									<label for="rfc">RFC</label>
									<input type="text" id="rfc" name="rfc" class="form-control"value="{{ $usuario->rfc }}" readonly>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group">
									<label for="curp">CURP </label>
									<input type="text" id="curp" name="curp" class="form-control" value="{{ $usuario->curp }}" readonly>
								</div>
							</div>
							<div class="col-12 col-sm-4 text-align-center">
								<div class="form-group">
									<label for="formGroupExampleInput">Activo</label>
									<div class="custom-control custom-switch">
										<label class="switch">
											<input type="checkbox" name="estatus" @if( $usuario->estatus) checked @endif value="1">
											<span class="slider round"></span>
										  </label>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group">
									<label for="nombre">Nombre</label>
									<input type="text" id="nombre" name="nombre" class="form-control" value="{{ $usuario->nombre }} {{ $usuario->primer_apellido }} {{ $usuario->segundo_apellido }}" readonly>
								</div>
							</div>
						</div>	
						<div class="row">
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="cargo">Cargo</label>
									<input type="text" id="cargo" name="cargo" class="form-control" value="{{ $usuario->cargo }}" readonly>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="text" id="email" name="email" class="form-control" value="{{ $usuario->email }}">
								</div>
							</div>
						</div>		
						<div class="row">
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="telefono">Telefono</label>
									<input type="text" id="telefono" name="telefono" class="form-control" value="{{ $usuario->telefono }}">
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="extension">Extensión</label>
									<input type="number" id="extension" name="extension" class="form-control" value="{{ $usuario->extension }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="urg">URG</label>
									<select class="form-control text-1" id="urg" name="urg" required>
                                        <option value="0" disabled="" selected="">Seleccione</option>
                                        @foreach($urgs as $urg)
                                        	<option value="{{ $urg->id_e}}" @if( $usuario->urg_id == $urg->id ) selected @endif> {{ $urg->nombre }} </option>
                                        @endforeach
                                    </select>
								</div>
							</div>
							<div class="col-12 col-sm-6">
								<div class="form-group">
									<label for="rol">Rol</label>
									<select class="form-control text-1" id="rol" name="rol" required>
                                        <option value="0" disabled="" selected="">Seleccione</option>
                                        @foreach($roles as $rol)
                                        	<option value="{{ $rol->id_e}}" @if( $usuario->rol_id == $rol->id ) selected @endif> {{ $rol->rol }} </option>
                                        @endforeach
                                    </select>
								</div>
							</div>
						</div>				
					</div>
					<input type="hidden" name="id_usuario" id="id_usuario" value="{{ $usuario->id_e }}">
				</form>
				<div class="modal-footer">
					<button type="button" class="btn boton-1" id="update_adhesion" onclick="usuario_update();">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</div>
