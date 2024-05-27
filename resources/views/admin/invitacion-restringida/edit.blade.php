<div class="tab-content border" id="nav-tabContent">
    <div class="accordion" id="accordionExample">
	    <div class="accordion-item">
	            <h2 class="mb-0 accordion-header" id="headingOne">
	                <button class="accordion-button boton-2 text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="contratacion">
	                    CONTRATACIÓN <span class="text-dorado float-end">Sección <span id="seccion_contratacion">completa</span> <i class="fa-solid fa-circle-exclamation"></i></span>
	                </button>
	            </h2>
	        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
	            <div class="accordion-body m-2">
				    <form id="frm_invitacion_1" enctype="multipart/form-data">
				        <div class="row">
				        	<div class="col-12">
				        		<p class="text-1 mt-4">Para capturar la información deberás consultar el documento “Lista de asistencia”.</p>
								<hr>
				        	</div>
				        	<div class="col-12 col-md-8">
								<h6 class="titl-1">Información de la contratación</h6>
								<p class="text-1">Información sobre invitación restringida.</p>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="articulo" class="text-1 mx-3">Artículo</label>
									<select name="articulo" id="articulo" class="form-control text-1" required>
										<option value="Articulo 54" @if($invitacion->articulo == 'Articulo 54') selected @endif>Articulo 54</option>
										<option value="Articulo 55" @if($invitacion->articulo == 'Articulo 55') selected @endif>Articulo 55</option>
										<option value="Articulo 57" @if($invitacion->articulo == 'Articulo 57') selected @endif>Articulo 57</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="fraccion" class="text-1 mx-3">Fracción</label>
									<select name="fraccion" id="fraccion" class="form-control text-1" disabled>
										<option value="I" @if($invitacion->fraccion == 'I') selected @endif>I</option>
										<option value="II" @if($invitacion->fraccion == 'II') selected @endif>II</option>
										<option value="III" @if($invitacion->fraccion == 'III') selected @endif>III</option>
										<option value="IV" @if($invitacion->fraccion == 'IV') selected @endif>IV</option>
										<option value="V" @if($invitacion->fraccion == 'V') selected @endif>V</option>
										<option value="VI" @if($invitacion->fraccion == 'VI') selected @endif>VI</option>
										<option value="VII" @if($invitacion->fraccion == 'VII') selected @endif>VII</option>
										<option value="VIII" @if($invitacion->fraccion == 'VIII') selected @endif>VIII</option>
										<option value="IX" @if($invitacion->fraccion == 'IX') selected @endif>IX</option>
										<option value="X" @if($invitacion->fraccion == 'X') selected @endif>X</option>
										<option value="XI" @if($invitacion->fraccion == 'XI') selected @endif>XI</option>
										<option value="XII" @if($invitacion->fraccion == 'XII') selected @endif>XII</option>
										<option value="XIII" @if($invitacion->fraccion == 'XIII') selected @endif>XIII</option>
										<option value="XIV" @if($invitacion->fraccion == 'XIV') selected @endif>XIV</option>
										<option value="XV" @if($invitacion->fraccion == 'XV') selected @endif>XV</option>
										<option value="XVI" @if($invitacion->fraccion == 'XVI') selected @endif>XVI</option>
										<option value="XVII" @if($invitacion->fraccion == 'VII') selected @endif>XVII</option>
										<option value="XVIII" @if($invitacion->fraccion == 'XVIII') selected @endif>XVIII</option>
										<option value="XIX" @if($invitacion->fraccion == 'XIX') selected @endif>XIX</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="fecha_sesion" class="text-1 mx-3">Fecha sesión del subcomité</label>
									<div class="input-group date hoyant">
											<input type="text" class="form-control text-1" name="fecha_sesion" id="fecha_sesion" disabled @if($invitacion->fecha_sesion) value="{{ $invitacion->fecha_sesion->format('d/m/Y') }}" @endif>
											<span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="numero_sesion" class="text-1 mx-3">Número de sesión del subcomité</label>
										<input type="number" class="form-control text-1" name="numero_sesion" id="numero_sesion" min="0" disabled value="{{ $invitacion->numero_sesion }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="numero_cotizacion" class="text-1 mx-3">Número de cotizaciones estudiadas</label>
										<input type="number" class="form-control text-1" name="numero_cotizacion" id="numero_cotizacion" min="0" required value="{{ $invitacion->numero_cotizacion }}">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-4 mz-2">
                            	<div class="form-group">
									<label class="text-1 mx-3">Proveedores invitados al procedimiento <span id="contador_proveedores_invitados"> {{ $invitacion->numero_proveedores_invitados }} </span></label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<input type="text" id="buscar" onkeyup="buscador()" class="form-control text-1" placeholder="Buscar proveedor por RFC...">
							</div>
						</div>
						<div class="row scroll @if(count($proveedoresInvitados) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores">
									@foreach($proveedoresInvitados as $key => $proveedor)
										<div class="row hr">
				                           <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="rfc" class="text-1 mx-3">RFC</label>
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-3">
				                                <div class="form-group">
				                                    <input type="text" name="rfc[]" class="form-control" readonly value="{{ $proveedor->rfc }}">
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="estatus[{{ $key }}]" value="1" onclick="contador(this,'invitados');" @if($proveedor->seleccionado == 1) checked @endif>
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
						<div class="row">
							<div class="col-12 col-md-12">
								<h6 class="titl-1">Adjuntar documentos</h6>
								<p class="text-1">Escanea el documento en formato PDF no mayor a 30MB.</p>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="aprobacion_original" class="text-1 mx-3">Aprobación del subcomité</label>
									<input type="file" class="form-control text-1" id="aprobacion_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="aprobacion_original" disabled>
									<label class="text-1 mt-3 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$invitacion->archivo_aprobacion_original) }}" target="_blank" class="text-1">{{ $invitacion->archivo_aprobacion_original }}</a>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="aprobacion_publica" class="text-1 mx-3">Aprobación del subcomité (versión pública)</label>
									<input type="file" class="form-control text-1" id="aprobacion_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="aprobacion_publica" disabled>
									<label class="text-1 mt-3 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$invitacion->archivo_aprobacion_publica) }}" target="_blank" class="text-1">{{ $invitacion->archivo_aprobacion_publica }}</a>
								</div>
							</div>
						</div>
						<input type="hidden" id="numero_proveedores_invitados" name="numero_proveedores_invitados" value="{{ $invitacion->numero_proveedores_invitados }}">	
						<input type="hidden" name="update" value="1">
	                </form>
	                <div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_invitacion_1" onclick="update(1)">Actualizar</button>
					</div>
	            </div>
	        </div>
	    </div>

	    <div class="accordion-item">
                <h2 class="mb-0 card-header" id="headingTwo">
                	@if( $invitacion->numero_proveedores_participaron > 0)
                     	<button class="accordion-button collapsed boton-2 btn-block text-left text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="junta">
                       	 	JUNTA DE ACLARACIONES<span class="text-dorado float-end">Sección <span id="seccion_junta">completa</span> <i class="fa-solid fa-circle-exclamation"></i></span>
                        @else
                        	<button class="accordion-button collapsed boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="junta">
                        JUNTA DE ACLARACIONES<span class="text-rojo float-end">Sección <span id="seccion_junta">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></span>
                        @endif
                    </button>
                </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body m-2">
                	<form id="frm_invitacion_2" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <p class="text-1 mt-4">Para capturar la información deberás consultar el documento “Acta de la junta de aclaraciones”.</p>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-12 col-md-6 mz-2">
                            	<div class="form-group">
										<label class="text-1 mx-3">Proveedores que participaron en la junta de aclaraciones <span id="contador_proveedores_junta"> {{ $invitacion->numero_proveedores_participaron }} </span></label>
								</div>
							</div>
						</div>
                		<div class="row scroll @if(count($proveedoresParticiparon) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif" id="espacio_junta">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_junta">
								 	@foreach($proveedoresParticiparon as $key => $proveedor)
								 		<div class="row hr">
				                           <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="rfc" class="text-1 mx-3">RFC</label>
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-3">
				                                <div class="form-group">
				                                    <input type="text" name="rfc[]" class="form-control text-1" readonly value="{{ $proveedor->rfc }}">
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="estatus[{{ $key }}]" value="1" onclick="contador(this,'junta');" @if($proveedor->seleccionado == 1) checked @endif>
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
						<div class="row">
							<div class="col-12 col-md-12">
								<h6 class="titl-1">Adjuntar documentos</h6>
								<p class="text-1">Escanea el documento en formato PDF no mayor a 30MB.</p>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="aclaracion_original" class="text-1 mx-3">Acta de la junta de aclaraciones</label>
									<input type="file" class="form-control text-1" id="aclaracion_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="aclaracion_original">
									<label class="text-1 mt-3 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$invitacion->archivo_aclaracion_original) }}" target="_blank" class="text-1">{{ $invitacion->archivo_aclaracion_original }}</a>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="aclaracion_publica" class="text-1 mx-3">Acta de la junta de aclaraciones (versión pública)</label>
									<input type="file" class="form-control text-1" id="aclaracion_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="aclaracion_publica">
									<label class="text-1 mt-3 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$invitacion->archivo_aclaracion_publica) }}" target="_blank" class="text-1">{{ $invitacion->archivo_aclaracion_publica }}</a>
								</div>
							</div>
						</div>	
						<input type="hidden" id="id_invitacion" name="id_invitacion" value="{{ $invitacion->id_e }}">
						<input type="hidden" id="numero_proveedores_junta" name="numero_proveedores_junta" value="{{ $invitacion->numero_proveedores_participaron }}">
						<input type="hidden" name="update" value="2" >
                	</form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_invitacion_2"  onclick="update(2);">Actualizar</button>
					</div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
                <h2 class="mb-0 card-header" id="headingThree">
                	@if( $invitacion->numero_proveedores_propuesta > 0 )
	                     <button class="accordion-button collapsed boton-2 btn-block text-left text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" id="propuesta">
	                        PRESENTACIÓN Y APERTURA DE PROPUESTAS<p class="text-dorado float-end">Sección <span id="seccion_propuesta">completa</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                        @else
	                        <button class="accordion-button collapsed boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" id="propuesta">
	                        PRESENTACIÓN Y APERTURA DE PROPUESTAS<p class="text-rojo float-end">Sección <span id="seccion_propuesta">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                        @endif
                    </button>
                </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                <div class="accordion-body m-2">
                	<form id="frm_invitacion_3" enctype="multipart/form-data">
                        <div class="row">
                			<div class="col-12">
                        		<p class="text-1 mt-4">Documentos requeridos: “Acta de presentación y apertura de propuesta”.</p>
                                <hr>
                            </div>
                		</div>
                        <div class="row">
                        	<div class="col-12 col-md-4 mz-2">
                            	<div class="form-group">
										<label class="text-1 mx-3">Proveedores que enviaron propuesta <span id="contador_proveedores_propuesta"> {{ $invitacion->numero_proveedores_propuesta }} </span></label>
								</div>
							</div>
						</div>
                		<div class="row scroll @if(count($proveedoresPropuesta) > 3 ) espacio_proveedores_largo @else espacio_proveedores_corto @endif" id="espacio_propuesta">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_propuesta">
									@foreach($proveedoresPropuesta as $key => $proveedor)
										<div class="row hr">
				                           <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="rfc" class="text-1 mx-3">RFC</label>
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-3">
				                                <div class="form-group">
				                                    <input type="text" name="rfc[]" class="form-control text-1" readonly value="{{ $proveedor->rfc }}">
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="estatus[{{ $key }}]" value="1" onclick="contador2(this,'propuesta', '{{ $proveedor->rfc }}' );" @if($proveedor->seleccionado == 1) checked @endif>
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
						<div class="row">&nbsp;</div>
						<div class="row">
							<div class="col-12 col-md-6 mz-2">
                            	<div class="form-group">
										<label class="text-1 mx-3">Proveedores descalificados en evaluación cuantitativa <span id="contador_proveedores_descalificados"> {{ $invitacion->numero_proveedores_descalificados }} </span></label>
								</div>
							</div>
						</div>
                		<div class="row scroll @if(count($proveedoresDescalificados) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif" id="espacio_descalificados">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_descalificados">
									@foreach($proveedoresDescalificados as $key => $proveedor)
										<div class="row hr" id="{{ $proveedor->rfc}}descalificados">
				                           <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="rfc" class="text-1 mx-3">RFC</label>
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-3">
				                                <div class="form-group">
				                                    <input type="text" name="_rfc[]" class="form-control text-1" readonly value="{{ $proveedor->rfc }}">
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="_estatus[{{ $proveedor->rfc }}]" value="1" onclick="contador(this,'descalificados');" @if($proveedor->seleccionado == 1) checked @endif>
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
						<div class="row">
							<div class="col-12 col-md-12">
								<h6 class="titl-1">Adjuntar documentos</h6>
								<p class="text-1">Escanea el documento en formato PDF no mayor a 30MB.</p>
								<hr>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="presentacion_original" class="text-1 mx-3">Acta de presentación y apertura de propuestas</label>
									<input type="file" class="form-control text-1" id="presentacion_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="presentacion_original">
									<label class="text-1 mt-3 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$invitacion->archivo_presentacion_original) }}" target="_blank" class="text-1">{{ $invitacion->archivo_presentacion_original }}</a>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="presentacion_publica" class="text-1 mx-3">Acta de presentación y apertura de propuestas (versión pública)</label>
									<input type="file" class="form-control text-1" id="presentacion_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="presentacion_publica">
									<label class="text-1 mt-3 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$invitacion->archivo_presentacion_publico) }}" target="_blank" class="text-1">{{ $invitacion->archivo_presentacion_publico }}</a>
								</div>
							</div>
						</div>	
						<input type="hidden" id="numero_proveedores_propuesta" name="numero_proveedores_propuesta" value="{{ $invitacion->numero_proveedores_propuesta}}">
						<input type="hidden" id="numero_proveedores_descalificados" name="numero_proveedores_descalificados" value="{{ $invitacion->numero_proveedores_descalificados }}">
						<input type="hidden" name="update" value="3" >
                	</form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_invitacion_3" onclick="update(3)">Actualizar</button>
					</div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
                <h2 class="mb-0 card-header" id="headingFour">
                	@if( $invitacion->numero_proveedores_aprobados > 0)
	                     <button class="accordion-button collapsed boton-2 btn-block text-left text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" id="fallo">
	                        FALLO<p class="text-dorado float-end">Sección <span id="seccion_fallo">completa</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                        @else
                        	<button class="accordion-button collapsed boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" id="fallo">
	                        FALLO<p class="text-rojo float-end">Sección <span id="seccion_fallo">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                        @endif 
                    </button>
                </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="accordion-body m-2">
                	<form id="frm_invitacion_4">
                        <div class="row">
	                		<div class="col-12">
	                			<p class="text-1 mt-4">Para capturar la información deberás consultar el documento “Dictamen de análisis cualitativo” y “Acta de fallo”. El campo “Proveedores adjudicados” indicará cuáles son los que participan en este Contrato Marco.</p>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-12 col-md-6 mz-2">
                            	<div class="form-group">
										<label class="text-1 mx-3">Proveedores aprobados en evaluación cualitativa <span id="contador_proveedores_aprobados"> {{ $invitacion->numero_proveedores_aprobados }} </span></label>
								</div>
							</div>
						</div>
                		<div class="row scroll @if(count($proveedoresAprobados) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif" id="espacio_aprobados">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_aprobados">
									@foreach($proveedoresAprobados as $key => $proveedor)
										<div class="row hr">
				                           <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="rfc" class="text-1 mx-3">RFC</label>
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-3">
				                                <div class="form-group">
				                                    <input type="text" name="rfc[]" class="form-control text-1" readonly value="{{ $proveedor->rfc }}">
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="estatus[{{ $key }}]" value="1" onclick="contador2(this,'aprobados', '{{ $proveedor->rfc }}' );" @if($proveedor->seleccionado == 1) checked @endif>
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
						<div class="row">&nbsp;</div>
						<div class="row">
							<div class="col-12 col-md-4 mz-2">
                            	<div class="form-group">
										<label class="text-1 mx-3">Proveedores adjudicados <span id="contador_proveedores_adjudicados"> {{ $invitacion->numero_proveedores_adjudicados }} </span></label>
								</div>
							</div>
						</div>
                		<div class="row scroll @if(count($proveedoresAdjudicados) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif" id="espacio_adjudicados">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_adjudicados">
									 @foreach($proveedoresAdjudicados as $key => $proveedor)
										<div class="row hr" id="{{ $proveedor->rfc}}adjudicados">
				                           <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="rfc" class="text-1 mx-3">RFC</label>
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-3">
				                                <div class="form-group">
				                                    <input type="text" name="_rfc[]" class="form-control text-1" readonly value="{{ $proveedor->rfc }}">
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="_estatus[{{ $proveedor->rfc }}]" value="1" onclick="contador(this,'adjudicados');" @if($proveedor->seleccionado == 1) checked @endif>
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
						<input type="hidden" id="numero_proveedores_aprobados" name="numero_proveedores_aprobados" value="{{ $invitacion->numero_proveedores_aprobados }}">
						<input type="hidden" id="numero_proveedores_adjudicados" name="numero_proveedores_adjudicados" value="{{ $invitacion->numero_proveedores_adjudicados }}">
						<input type="hidden" name="update" value="4" >
                	</form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_invitacion_4" onclick="update(4)">Actualizar</button>
					</div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
                <h2 class="mb-0 card-header" id="headingFive">
                	@if($countAnexos >= 2)
                     	<button class="accordion-button collapsed boton-2 btn-block text-left text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" id="anexos">
                        	ANEXOS<p class="text-dorado float-end">Sección <span id="seccion_anexos">completa</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                    @else
                    	<button class="accordion-button collapsed boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" id="anexos">
                        	ANEXOS<p class="text-rojo float-end">Sección <span id="seccion_anexos">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                    @endif
                    </button>
                </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                <div class="accordion-body m-2">
                    <div class="row">
                		<div class="col-12">
	                        <h6 class="titl-1 mt-3">Adjuntar documentos</h6>
	                        <p class="text-1">Escanea y djunta los siguientes documentos en formato PDF no mayor a 30MB. Se requerirán la versión original y pública.</p>
	                        <hr>
	                    </div>
                    </div>
                    <div class="row elemtos d-flex">
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
                                <i class="fa fa-plus" aria-hidden="true"></i> Adjuntar
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
        @if(!$expediente->liberado)
	        <div class="row">
	            <div class="col-12 col-md-4 offset-md-8" id="liberar">
	                <button class="btn m-2 boton-1" type="button" onclick="liberar()">Liberar procedimiento</button>
	            </div>
	        </div>
	    @endif

    </div>
</div>

	@section('js2')
		{{-- @routes(['invitacion','anexosInvitacion']); --}}
		<script src="{{ asset('asset/js/invitacion_restringida.js') }}" type="text/javascript"></script>
	@endsection
