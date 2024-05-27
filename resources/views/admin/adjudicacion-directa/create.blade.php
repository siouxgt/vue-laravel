<div class="tab-content border" id="nav-tabContent">
	<div class="accordion" id="accordionExample">
		<div class="accordion-item">
			    <h2 class="mb-0 accordion-header" id="headingOne">
			        <button class="accordion-button boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="contratacion">
			            CONTRATACIÓN <span class="text-rojo float-end">Sección <span id="seccion_contratacion">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></span>
			        </button>
			    </h2>
			<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
				<div class="accordion-body m-2">
				    <form id="frm_adjudicacion_1" enctype="multipart/form-data">
		                <div class="row my-3">
	                		<div class="col-12">
	                			<p class="text-1 mt-4">Para capturar la información deberás consultar el documento “Lista de asistencia”.</p>
								<hr>
							</div>
							<div class="col-12 col-md-8">
								<h6 class="titl-1">Información de la contratación</h6>
								<p class="text-1">Información sobre adjudicación directa.</p>
                        	</div>
                        </div>
						<div class="row my-3">
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="articulo" class="text-1 mx-3">Artículo</label>
									<select name="articulo" id="articulo" class="form-control text-1" required>
										<option value="">Selecciones una opción</option>
										<option value="Articulo 54">Articulo 54</option>
										<option value="Articulo 55">Articulo 55</option>
										<option value="Articulo 57">Articulo 57</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="fraccion" class="text-1 mx-3">Fracción</label>
									<select name="fraccion" id="fraccion" class="form-control text-1" disabled required>
										<option value="">Selecciones una opción</option>
										<option value="I">I</option>
										<option value="II">II</option>
										<option value="III">III</option>
										<option value="IV">IV</option>
										<option value="V">V</option>
										<option value="VI">VI</option>
										<option value="VII">VII</option>
										<option value="VIII">VIII</option>
										<option value="IX">IX</option>
										<option value="X">X</option>
										<option value="XI">XI</option>
										<option value="XII">XII</option>
										<option value="XIII">XIII</option>
										<option value="XIV">XIV</option>
										<option value="XV">XV</option>
										<option value="XVI">XVI</option>
										<option value="XVII">XVII</option>
										<option value="XVIII">XVIII</option>
										<option value="XIX">XIX</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="fecha_sesion" class="text-1 mx-3">Fecha sesión del subcomité</label>
									<div class="input-group date hoyant">
											<input type="text" class="form-control text-1" name="fecha_sesion" id="fecha_sesion" disabled required>
											<span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="numero_sesion" class="text-1 mx-3">Número de sesión del subcomité</label>
										<input type="number" class="form-control text-1" name="numero_sesion" id="numero_sesion" min="0" disabled required>
								</div>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="numero_cotizacion" class="text-1 mx-3">Número de cotizaciones estudiadas</label>
										<input type="number" class="form-control text-1" name="numero_cotizacion" id="numero_cotizacion" min="0" required>
								</div>
							</div>
						</div>
							
						<div class="row my-3">
							<div class="col-12 col-md-12">
								<h6 class="titl-1">Adjuntar documentos</h6>
								<p class="text-1">Escanea el documento en formato PDF no mayor a 30MB.</p>
								<hr>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="aprobacion_original" class="text-1 mx-3">Aprobación del subcomité</label>
										<input type="file" class="form-control text-1" id="aprobacion_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="aprobacion_original" disabled required>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="aprobacion_publica" class="text-1 mx-3">Aprobación del subcomité (versión pública)</label>
										<input type="file" class="form-control text-1" id="aprobacion_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="aprobacion_publica" disabled required>
								</div>
							</div>
						</div>	
				    </form>
	                <div class="modal-footer">
						<button type="button" class="btn boton-1" id="store_adjudicacion" onclick="store();">Guardar</button>
					</div>
	            </div>
			</div>
		</div>

		<div class="accordion-item">
                <h2 class="mb-0 accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="fallo">
                        FALLO<span class="text-rojo float-end">Sección <span id="seccion_fallo">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></span>
                    </button>
                </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body m-2">
                    <form id="frm_adjudicacion_2">
                		<div class="row my-3">
                			<div class="col-12">
                        		<p class="text-1 mt-4">Para capturar la información deberás consultar el documento “Acta de fallo”. El campo “Proveedores adjudicados” indicará cuáles son los que participan en este Convenio Marco.</p>
                        		<hr>
                        	</div>
                		</div>
                        <div class="row my-3">
                        	<div class="form-group">
								<label class="text-1 mx-3">Proveedor adjudicado <span id="contador_proveedores"> 0 </span></label>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-4">
								<input type="text" id="buscar" onkeyup="buscador()" class="form-control text-1" placeholder="Buscar proveedor por RFC...">
							</div>
						</div>
                		<div class="row my-3 scroll @if(count($proveedores) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group p-3" id="proveedores">
									@foreach($proveedores as $key => $proveedor)
										<div class="row hr">
				                           <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="rfc" class="text-1 mx-3">RFC</label>
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-3">
				                                <div class="form-group">
				                                    <input type="text" id="rfc" name="rfc[]" class="form-control text-1" readonly value="{{ $proveedor->rfc }}">
				                                </div>
				                            </div>
				                            {{-- <div class="col-12 col-sm-1">
					                            <div class="form-group">
					                                <label for="nombre">nombre</label>
					                            </div>
					                        </div>
					                        <div class="col-12 col-sm-3">
					                            <div class="form-group">
					                                <input type="text" id="nombre" name="nombre[]" class="form-control" readonly value="{{ $proveedor->nombre }}">
					                            </div>
					                        </div>
				                            <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="formGroupExampleInput">Activo</label>
				                                </div>
				                            </div> --}}
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group p-3">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="estatus[{{ $key }}]" value="1" onclick="contador(this);">
				                                            <span class="slider round"></span>
				                                          </label>
				                                    </div>
				                                </div>
				                            </div>
				                    	</div> 
					                @endforeach
								</div>
							</div>
						</div>
						<input type="hidden" id="id_adjudicacion" name="id_adjudicacion">
						<input type="hidden" id="numero_proveedores" name="numero_proveedores" value="0">
						<input type="hidden" name="update" value="2">
                    </form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_adjudicacion2" disabled onclick="update(2)">Guardar</button>
					</div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
                <h2 class="mb-0 accordion-header" id="headingThree">
                     <button class="accordion-button collapsed boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" id="anexos">
                        ANEXOS<span class="text-rojo float-end"> Sección <span id="seccion_anexos">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></span>
                    </button>
                </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body m-2">
                	<div class="row my-3">
                		<div class="col-12">
	                        <h6 class="titl-1 mt-3">Adjuntar documentos</h6>
	                        <p class="text-1">Escanea y djunta los siguientes documentos en formato PDF no mayor a 30MB. Se requerirán la versión original y pública.</p>
	                        <hr>
	                    </div>
                    </div>
                    <div class="row my-3 elemtos d-flex">
                        <div class="row col-12 col-md-8 justify-content-start">
                            <h4 class="text">
                                <div class="dataTables_length" id="example1_length">
                                    <label>
                                        Documentos adjuntos 
                                    </label>
                                </div>
                            </h4>
                        </div>
                        <div class="col-12 col-md-4 justify-content-center">
                            <button type="button" class="btn btn-white boton-1 btn-block col-lg-5 col-md-8 p-1" data-toggle="modal" data-target="#staticBackdrop" id="anexos_modal">
                                <i class="fa-solid fa-upload" aria-hidden="true"></i> Adjuntar
                            </button>
                        </div>
                    </div>
                    <div class="container">
                    	<table class="table justify-content-md-center" id="tabla_anexos">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nombre del documento</th>
									<th scope="col"> Original</th>
									<th scope="col">Público</th>
									<th scope="col" class="tab-cent">Editar</th>
								</tr>
							</thead>
						</table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
    	<div class="row">
		    <div class="col-12 col-md-4 offset-md-8" id="liberar">
		        <button class="btn m-2 boton-1" type="button" onclick="liberar()">Liberar procedimiento</button>
		    </div>
    	</div>
  	</div>
</div>

@section('js2')
	{{-- @routes(['adjudicacion','anexosAdjudicacion']); --}}
	<script src="{{ asset('asset/js/adjudicacion_directa.js') }}" type="text/javascript"></script>
@endsection