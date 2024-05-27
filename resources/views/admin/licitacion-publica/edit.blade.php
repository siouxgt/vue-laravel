<div class="tab-content border" id="nav-tabContent">
	<div class="accordion" id="accordionExample">
	   <div class="accordion-item">
	            <h2 class="mb-0 accordion-header" id="headingOne">
	                <button class="accordion-button btn btn-block text-left boton-2 text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="datos">
	                    DATOS GENERALES<p class="text-dorado text-end">Sección <span id="seccion_datos">completa</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	                </button>
	            </h2>
	    
	        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
	            <div class="accordion-body">
	                <form id="frm_licitacion_1">
				        <div class="row my-3">
				        	<div class="col-12">
				        		<p class="text-1 mt-4">Si no se encuentran datos en “Tianguis digital”, la captura será manual. El documento de consulta será el de “Licitación Pública” y “Ofertas”.</p>
								<hr>
							</div>
						</div>
						<div class="row my-3">
							 <div class="col-12 col-md-12">
                                <p class="text-1 mx-3">Esta registrada en tianguis digital</p>
                                <div class="form-check-inline col-3">
                                    <input class="form-check-input" type="radio" name="tianguis" id="tianguis_si" value="true" @if( $licitacion->tiangis == true) checked @endif required>
                                    <label class="form-check-labe text-1 mx-3l" for="tianguis_si">
                                        Sí
                                    </label>
                                </div>
                                <div class="form-check-inline col-3 mz-2">
                                    <input class="form-check-input" type="radio" name="tianguis" id="tianguis_no" value="false" @if( $licitacion->tiangis == false) checked @endif required>
                                    <label class="form-check-label text-1 mx-3" for="tianguis_no">
                                        No
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="tipo_licitacion" class="text-1 mx-3">Tipo de Convocatoria Pública Contrato Marco</label>
									<select name="tipo_licitacion" id="tipo_licitacion" class="form-control text-1" required>
										<option value="Nacional" @if($licitacion->tipo_licitacion == 'Nacional') selected @endif>Nacional</option>
										<option value="Internacional" @if($licitacion->tipo_licitacion == 'Internacional') selected @endif>Internacional</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="tipo_contratacion" class="text-1 mx-3">Tipo de contratación por rubro de gasto</label>
									<select name="tipo_contratacion" id="tipo_contratacion" class="form-control text-1" required>
										<option value="Adquisición de bienes" @if($licitacion->tipo_contratacion == 'Adquisición de bienes') selected @endif>Adquisición de bienes</option>
										<option value="Prestación de servicios" @if($licitacion->tipo_contratacion == 'Prestación de servicios') selected @endif>Prestación de servicios</option>
										<option value="Arrendamiento de bienes o servicios" @if($licitacion->tipo_contratacion == 'Arrendamiento de bienes o servicios') selected @endif>Arrendamiento de bienes o servicios</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="fecha_convocatoria" class="text-1 mx-3">Publicación convocatoria</label>
									<div class="input-group date">
											<input type="text" class="form-control tetx-1" name="fecha_convocatoria" id="fecha_convocatoria" @if($licitacion->fecha_convocatoria) value="{{ $licitacion->fecha_convocatoria->format('d/m/Y') }}"  @endif required>
											<div class="input-group-append">
												<span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
  											</div>
									</div>
								</div>
							</div>
						</div>
						<input type="hidden" name="update" value="1">	
	                </form>
	                <div class="modal-footer">
						<button type="button" class="btn boton-1"  id="update_licitacion_1" onclick="update(1)">Actualizar</button>
					</div>
	            </div>
	        </div>
	    </div>

	    <div class="accordion-item">
                <h2 class="mb-0 accordion-header" id="headingTwo">
                	@if($licitacion->numero_proveedores_base > 0)
	                     <button class="accordion-button collapsed btn boton-2 btn-block text-left text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="adquisicion">
	                        ADQUISICIÓN DE BASES<p class="text-dorado text-end">Sección <span id="seccion_adquisicion">completa</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	                    @else
	                       	<button class="accordion-button collapsed btn boton-1 btn-block text-left text-rojo-titulo" type="button" data-t-bsoggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="adquisicion">
                        		ADQUISICIÓN DE BASES<p class="text-rojo text-end">Sección <span id="seccion_adquisicion">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	                    @endif
                    </button>
                </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                <div class="accordion-body m-2">
                	<form id="frm_licitacion_2" enctype="multipart/form-data">
                        <div class="row">
				        	<div class="col-12">
				        		<p class="text-1 mt-4">Para esta captura requerirás el documento “Lista de asistencia”. Lo puedes solicitar al área convocante.</p>
                                <hr>
                            </div>
                        </div>
                       <div class="row">
							<div class="col-12 col-md-8 mz-2">
                            	<div class="form-group">
									<label class="text-1 mx-3">Proveedores que adquirieron las bases de la Convocatoria Pública Contrato Marco <span id="contador_proveedores_base"> {{ $licitacion->numero_proveedores_base }} </span></label>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<input type="text" id="buscar" onkeyup="buscador()" class="form-control text-1" placeholder="Buscar proveedor por RFC...">
							</div>
						</div>
						<div class="row scroll @if(count($proveedoresBase) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif" id="espacio_base">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores">
									@foreach($proveedoresBase as $key => $proveedor)
										<div class="row hr">
				                           <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="rfc" class="text-1 mx-3">RFC</label>
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-3">
				                                <div class="form-group">
				                                    <input type="text" id="base_rfc" name="rfc[]" class="form-control" readonly value="{{ $proveedor->rfc }}">
				                                </div>
				                            </div>
				                            {{-- <div class="col-12 col-sm-1">
					                            <div class="form-group">
					                                <label for="nombre">nombre</label>
					                            </div>
					                        </div>
					                        <div class="col-12 col-sm-3">
					                            <div class="form-group">
					                                <input type="text" id="base_nombre" name="nombre[]" class="form-control" readonly value="{{ $proveedor->nombre }}">
					                            </div>
					                        </div>
				                            <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="formGroupExampleInput">Activo</label>
				                                </div>
				                            </div> --}}
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="estatus[{{$key}}]" value="1" onclick="contador(this,'base');" @if($proveedor->seleccionado == 1) checked @endif>
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
									<label for="base_licitacion" class="text-1 mx-3">Bases de Convocatoria Pública Contrato Marco</label>
									<input type="file" class="form-control text-1" id="base_licitacion" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="base_licitacion">
									<label class="text-1 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$licitacion->archivo_base_licitacion) }}" target="_blank" class="text-1">{{ $licitacion->archivo_base_licitacion }}</a>
								</div>
							</div>
						</div>
						<input type="hidden" id="numero_proveedores_base" name="numero_proveedores_base" value="{{ $licitacion->numero_proveedores_base }}">	
						<input type="hidden" id="id_licitacion" name="id_licitacion" value="{{ $licitacion->id_e }}">
						<input type="hidden" name="update" value="2">	
                	</form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_licitacion_2" onclick="update(2)">Actualizar</button>
					</div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
                <h2 class="mb-0 accordion-header" id="headingTrhee">
                	@if($licitacion->fecha_aclaracion)
	                     <button class="accordion-button collapsed btn boton-2 btn-block text-left text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" id="aclaraciones">
	                        JUNTA DE ACLARACIONES BASES<p class="text-dorado text-end">Sección <span id="seccion_aclaracion">completa</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	            	@else
	            		<button class="accordion-button collapsed btn boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" id="aclaraciones">
                        JUNTA DE ACLARACIONES BASES<p class="text-rojo text-end">Sección <span id="seccion_aclaracion">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	            	@endif
                    </button>
                </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                <div class="accordion-body m-2">
                	<form id="frm_licitacion_3" enctype="multipart/form-data">
                        <div class="row my-3">
				        	<div class="col-12">
				        		<p class="text-1 mt-4">Captura la información en los siguientes campos.</p>
                                <hr>
                            </div>
                        </div>
                        <div class="row my-3">
                        	<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="fecha_aclaracion" class="text-1 mx-3">Fecha</label>
									<div class="input-group date">
										<input type="text" class="form-control text-1" name="fecha_aclaracion" id="fecha_aclaracion" @if($licitacion->fecha_aclaracion) value="{{ $licitacion->fecha_aclaracion->format('d/m/Y') }}" @endif required>
										<span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
									</div>
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
									<label for="acta_declaracion_original" class="text-1 mx-3">Acta de la junta de aclaraciones</label>
									<input type="file" class="form-control text-1" id="acta_declaracion_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_declaracion_original">
									<label class="text-1 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$licitacion->archivo_acta_declaracion_original) }}" target="_blank" class="text-1">{{ $licitacion->archivo_acta_declaracion_original }}</a>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="acta_declaracion_publica" class="text-1 mx-3">Acta de la junta de aclaraciones (versión pública)</label>
									<input type="file" class="form-control text-1" id="acta_declaracion_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_declaracion_publica">
									<label class="text-1 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$licitacion->archivo_acta_declaracion_publico) }}" target="_blank" class="text-1">{{ $licitacion->archivo_acta_declaracion_publico }}</a>
								</div>
							</div>
						</div>
						<input type="hidden" name="update" value="3">		
                	</form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_licitacion_3" onclick="update(3)">Actualizar</button>
					</div>
                </div>
            </div>
        </div>

         <div class="accordion-item">
                <h2 class="mb-0 accordion-header" id="headingFour">
                	@if($licitacion->numero_proveedores_propuesta)
	                    <button class="accordion-button collapsed btn boton-2 btn-block text-left text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" id="propuesta">
	                        PRESENTACIÓN Y APERTURA DE PROPUESTAS<p class="text-dorado text-end">Sección <span id="seccion_propuesta">completa</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	            	@else
	            		<button class="accordion-button collapsed btn boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" id="propuesta">
                        PRESENTACIÓN Y APERTURA DE PROPUESTAS<p class="text-rojo text-end">Sección <span id="seccion_propuesta">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	            	@endif 
                    </button>
                </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                <div class="accordion-body m-2">
                	<form id="frm_licitacion_4" enctype="multipart/form-data">
                        <div class="row">
				        	<div class="col-12">
				        		<p class="text-1 mt-4">Para capturar la información deberás consultar el documento “Acta de presentación y apertura de propuesta”.</p>
                                <hr>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="fecha_propuesta" class="text-1 mx-3">Fecha</label>
									<div class="input-group date">
										<input type="text" class="form-control text-1" name="fecha_propuesta" id="fecha_propuesta" @if($licitacion->fecha_propuesta) value="{{ $licitacion->fecha_propuesta->format('d/m/Y') }}" @endif required>
										<span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row my-3">
                        	<div class="col-12 col-md-4 mz-2">
                            	<div class="form-group">
									<label class="text-1 mx-3">Proveedores que enviaron propuesta <span id="contador_proveedores_propuesta"> {{ $licitacion->numero_proveedores_propuesta }} </span></label>
								</div>
							</div>
						</div>
                		<div class="row my-3 p-3 scroll @if(count($proveedoresPropuesta) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif" id="espacio_propuesta">
							<div class="col-12 col-md-12 mz-2 p-3">
								<div class="form-group" id="proveedores_propuesta">
									@foreach($proveedoresPropuesta as $key => $proveedor)
										<div class="row">
				                           <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="rfc" class="text-1 mx-3">RFC</label>
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-3">
				                                <div class="form-group">
				                                    <input type="text" id="base_rfc" name="rfc[]" class="form-control text-1" readonly value="{{ $proveedor->rfc }}">
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="estatus[{{$key}}]" value="1" onclick="contador2(this,'propuesta', '{{ $proveedor->rfc }}' );" @if($proveedor->seleccionado == 1) checked @endif>
				                                            <span class="slider round"></span>
				                                          </label>
				                                    </div>
				                                </div>
				                            </div>
				                    	</div> 
					                    <hr>
					                @endforeach	  							
								</div>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-md-6 mz-2">
                            	<div class="form-group">
									<label class="text-1 mx-3">Proveedores descalificados en evaluación cuantitativa <span id="contador_proveedores_descalificados"> {{ $licitacion->numero_proveedores_descalificados}} </span></label>
								</div>
							</div>
						</div>
                		<div class="row my-3 p-3 scroll @if(count($proveedoresDescalificado) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif" id="espacio_descalificados">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_descalificados">
									@foreach($proveedoresDescalificado as $key => $proveedor)
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
									<label for="acta_presentacion_original" class="text-1 mx-3">Acta de presentación y apertura de propuestas</label>
									<input type="file" class="form-control text-1" id="acta_presentacion_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_presentacion_original">
									<label class="text-1 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$licitacion->archivo_acta_presentacion_original) }}" target="_blank" class="text-1">{{ $licitacion->archivo_acta_presentacion_original }}</a>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="acta_presentacion_publica" class="text-1 mx-3">Acta de presentación y apertura de propuestas (versión pública)</label>
									<input type="file" class="form-control text-1" id="acta_presentacion_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_presentacion_publica">
									<label class="text-1 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$licitacion->archivo_acta_presentacion_publico) }}" target="_blank" class="text-1">{{ $licitacion->archivo_acta_presentacion_publico }}</a>
								</div>
							</div>
						</div>	
						<input type="hidden" name="update" value="4">
						<input type="hidden" name="numero_proveedores_propuesta" id="numero_proveedores_propuesta" value="{{ $licitacion->numero_proveedores_propuesta }}">
						<input type="hidden" name="numero_proveedores_descalificados" id="numero_proveedores_descalificados" value="{{ $licitacion->numero_proveedores_descalificados }}">
                	</form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_licitacion_4" onclick="update(4)">Actualizar</button>
					</div>
                </div>
            </div>
        </div>

         <div class="accordion-item">
                <h2 class="mb-0 accordion-header" id="headingFive">
                	@if($licitacion->numero_proveedores_adjudicados > 0)
	                     <button class="accordion-button collapsed btn boton-2 btn-block text-left collapsed text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" id="fallo">
	                        FALLO<p class="text-dorado text-end">Sección <span id="seccion_fallo">completa</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	            	@else
	            		 <button class="accordion-button collapsed btn boton-1 btn-block text-left collapsed text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" id="fallo">
	                        FALLO<p class="text-rojo text-end">Sección <span id="seccion_fallo">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	            	@endif
                    </button>
                </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-parent="#accordionExample">
                <div class="accordion-body m-2">
                	<form id="frm_licitacion_5">
                        <div class="row my-3">
                            <div class="col-12">
                                <p class="text-1 mt-4">Para capturar la información deberás consultar el documento “Dictamen de análisis cualitativo” y “Acta de fallo”. El campo “Proveedores adjudicados” indicará cuáles son los que participan en este Contrato Marco.</p>
                                <hr>
                            </div>
                        </div>
                         <div class="row my-3">
                        	<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="fecha_fallo" class="text-1 mx-3">Fecha</label>
									<div class="input-group date">
										<input type="text" class="form-control text-1" name="fecha_fallo" id="fecha_fallo" @if($licitacion->fecha_fallo) value="{{ $licitacion->fecha_fallo->format('d/m/Y') }}" @endif required>
										<span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
                        </div>
                        <div class="row my-3">
                        	<div class="col-12 col-md-6 mz-2">
                            	<div class="form-group">
									<label class="text-1 mx-3">Proveedores aprobados en evaluación cualitativa <span id="contador_proveedores_aprobados"> {{$licitacion->numero_proveedores_aprobados}} </span></label>
								</div>
							</div>
						</div>
                		<div class="row my-3 p-3 scroll @if(count($proveedoresAprobados) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif" id="espacio_aprobados">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_aprobados">
									@foreach($proveedoresAprobados as $key => $proveedor)
										<div class="row">
				                           <div class="col-12 col-sm-1">
				                                <div class="form-group">
				                                    <label for="rfc" class="text-1 mx-3">RFC</label>
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-3">
				                                <div class="form-group">
				                                    <input type="text" id="base_rfc" name="rfc[]" class="form-control text-1" readonly value="{{ $proveedor->rfc }}">
				                                </div>
				                            </div>
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="estatus[{{$key}}]" value="1" onclick="contador2(this,'aprobados', '{{ $proveedor->rfc }}' );" @if($proveedor->seleccionado == 1) checked @endif>
				                                            <span class="slider round"></span>
				                                          </label>
				                                    </div>
				                                </div>
				                            </div>
				                    	</div> 
					                    <hr>
					                @endforeach								
								</div>
							</div>
						</div>
						<div class="row">&nbsp;</div>
						<div class="row my-3">
							<div class="col-12 col-md-4 mz-2">
                            	<div class="form-group">
										<label class="text-1 mx-3">Proveedores a los que se adjudicó <span id="contador_proveedores_adjudicados"> {{$licitacion->numero_proveedores_adjudicados}} </span></label>
								</div>
							</div>
						</div>
                		<div class="row my-3 p-3 scroll @if(count($proveedoresAdjudicados) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif" id="espacio_adjudicados">
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
									<label for="acta_fallo_original" class="text-1 mx-3">Acta de selección de proveedores</label>
									<input type="file" class="form-control text-1" id="acta_fallo_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_fallo_original">
									<label class="text-1 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$licitacion->archivo_acta_fallo_original) }}" target="_blank" class="text-1">{{ $licitacion->archivo_acta_fallo_original }}</a>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="acta_fallo_publica" class="text-1 mx-3">Acta de selección de proveedores (versión pública)</label>
									<input type="file" class="form-control text-1" id="acta_fallo_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_fallo_publica">
									<label class="text-1 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$licitacion->archivo_acta_fallo_publica) }}" target="_blank" class="text-1">{{ $licitacion->archivo_acta_fallo_publica }}</a>
								</div>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="oficio_adjudicacion_original" class="text-1 mx-3">Oficio de selección de proveedores</label>
									<input type="file" class="form-control text-1" id="oficio_adjudicacion_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="oficio_adjudicacion_original">
									<label class="text-1 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$licitacion->archivo_oficio_adjudicacion_original) }}" target="_blank" class="text-1">{{ $licitacion->archivo_oficio_adjudicacion_original }}</a>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="oficio_adjudicacion_publica" class="text-1 mx-3">Oficio de selección de proveedores (versión pública)</label>
									<input type="file" class="form-control text-1" id="oficio_adjudicacion_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="oficio_adjudicacion_publica">
									<label class="text-1 mx-3">Archivo actual:</label> <a href="{{ asset('storage/'.$carpeta."/".$licitacion->archivo_oficio_adjudicacion_publico) }}" target="_blank" class="text-1">{{ $licitacion->archivo_oficio_adjudicacion_publico }}</a>
								</div>
							</div>
						</div>		
						<input type="hidden" name="numero_proveedores_aprobados" id="numero_proveedores_aprobados" value="{{ $licitacion->numero_proveedores_adjudicados }}">
						<input type="hidden" name="numero_proveedores_adjudicados" id="numero_proveedores_adjudicados" value="{{ $licitacion->numero_proveedores_adjudicados }}">
						<input type="hidden" name="update" value="5">
                	</form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_licitacion_5" onclick="update(5)">Actualizar</button>
					</div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
                <h2 class="mb-0 accordion-header" id="headingSix">
                	@if($countAnexos >= 2)
                     	<button class="accordion-button collapsed btn boton-2 btn-block text-left text-dorado-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix" id="anexos">
                        	ANEXOS<p class="text-dorado text-end">Sección <span id="seccion_anexos">completa</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                    @else
                    	 <button class="accordion-button collapsed btn boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix" id="anexos">
                        ANEXOS<p class="text-rojo text-end">Sección <span id="seccion_anexos">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                    @endif
                    </button>
                </h2>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
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
		{{-- @routes(['licitacion','anexosLicitacion']); --}}
		<script src="{{ asset('asset/js/licitacion_publica.js') }}" type="text/javascript"></script>
	@endsection
