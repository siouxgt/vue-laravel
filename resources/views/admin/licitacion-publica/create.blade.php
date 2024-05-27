<div class="tab-content border" id="nav-tabContent">
	<div class="accordion" id="accordionExample">
		<div class="accordion-item">
	            <h2 class="mb-0 accordion-header" id="headingOne">
	                <button class="accordion-button boton-1 btn-block text-left text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" id="datos">
	                    DATOS GENERALES <p class="text-rojo float-end">Sección <span id="seccion_datos">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	                </button>
	            </h2>
	        
			<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
				<div class="accordion-body m-2">
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
                                    <input class="form-check-input" type="radio" name="tianguis" id="tianguis_si" value="true">
                                    <label class="form-check-label text-1 mx-3" for="tianguis_si">
                                        Sí
                                    </label>
                                </div>
                                <div class="form-check-inline col-3 mz-2">
                                    <input class="form-check-input" type="radio" name="tianguis" id="tianguis_no" value="false">
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
										<option value="">Selecciones una opción</option>
										<option value="Nacional">Nacional</option>
										<option value="Internacional">Internacional</option>
									</select>
								</div>
							</div>
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="tipo_contratacion" class="text-1 mx-3">Tipo de contratación por rubro de gasto</label>
									<select name="tipo_contratacion" id="tipo_contratacion" class="form-control text-1" required>
										<option value="">Selecciones una opción</option>
										<option value="Adquisición de bienes">Adquisición de bienes</option>
										<option value="Prestación de servicios">Prestación de servicios</option>
										<option value="Arrendamiento de bienes o servicios">Arrendamiento de bienes o servicios</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-md-4 mz-2">
								<div class="form-group">
									<label for="fecha_convocatoria" class="text-1 mx-3">Publicación convocatoria</label>
									<div class="input-group date hoyant">
											<input type="text" class="form-control text-1" name="fecha_convocatoria" id="fecha_convocatoria" required>
											<span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
						</div>
				    </form>
	                <div class="modal-footer">
						<button type="button" class="btn boton-1" id="store_licitacion" onclick="store()">Guardar</button>
					</div>
	            </div>
	        </div>
	    </div>

	    <div class="accordion-item">
                <h2 class="mb-0 accordion-header">
                     <button class="accordion-button collapsed boton-1 btn-block text-left collapsed text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" id="adquisicion">
                        ADQUISICIÓN DE BASES<p class="text-rojo float-end">Sección <span id="seccion_adquisicion">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                    </button>
                </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                <div class="accordion-body m-2">
                    <form id="frm_licitacion_2" enctype="multipart/form-data">
                        <div class="row my-3">
				        	<div class="col-12 mb-3">
				        		<p class="text-1 mt-4">Para esta captura requerirás el documento “Lista de asistencia”. Lo puedes solicitar al área convocante.</p>
                                <hr>
                            </div>
                        </div>
                       <div class="row my-3">
							<div class="col-12 col-md-8 mz-2 my-3">
                            	<div class="form-group">
									<label class="text-1 mx-3">Proveedores que adquirieron las bases de la Convocatoria Pública Contrato Marco <span id="contador_proveedores_base"> 0 </span></label>
								</div>
							</div>
						</div>
						<div class="row my-3 mb-3">
							<div class="col-4 mt-1 mb-2">
								<input type="text" id="buscar" onkeyup="buscador()" class="form-control text-1" placeholder="Buscar proveedor por RFC...">
							</div>
						</div>
						<div class="row my-3 mt-4 scroll @if(count($proveedores) > 3) espacio_proveedores_largo @else espacio_proveedores_corto @endif">
							<div class="col-12 col-md-12 mt-2">
								<div class="form-group p-3" id="proveedores">
									@foreach($proveedores as $key => $proveedor)
										<div class="row hr p-2">
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
				                            <div class="col-12 col-sm-2 text-align-center">
				                                <div class="form-group">
				                                    <div class="custom-control custom-switch">
				                                        <label class="switch">
				                                            <input type="checkbox" name="estatus[{{$key}}]" value="1" onclick="contador(this,'base');">
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
									<label for="base_licitacion" class="text-1 mx-3">Bases de Convocatoria Pública Contrato Marco</label>
										<input type="file" class="form-control text-1" id="base_licitacion" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="base_licitacion" required>
								</div>
							</div>
						</div>
						<input type="hidden" id="numero_proveedores_base" name="numero_proveedores_base" value="0">	
						<input type="hidden" id="id_licitacion" name="id_licitacion" class="mz-3">
						<input type="hidden" name="update" value="2">	
                    </form>
                    <div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_licitacion_2" disabled onclick="update(2)">Guardar</button>
					</div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
                <h2 class="mb-0 accordion-header" id="headingThree">
                     <button class="accordion-button collapsed boton-1 btn-block text-left collapsed text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" id="aclaraciones">
                        JUNTA DE ACLARACIONES BASES<p class="text-rojo float-end">Sección <span id="seccion_aclaracion">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                    </button>
                </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
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
									<div class="input-group date hoyant">
											<input type="text" class="form-control text-1" name="fecha_aclaracion" id="fecha_aclaracion" required>
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
										<input type="file" class="form-control text-1" id="acta_declaracion_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_declaracion_original" required>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="acta_declaracion_publica" class="text-1 mx-3">Acta de la junta de aclaraciones (versión pública)</label>
										<input type="file" class="form-control text-1" id="acta_declaracion_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_declaracion_publica" required>
								</div>
							</div>
						</div>
						<input type="hidden" name="update" value="3">		
                    </form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_licitacion_3" disabled onclick="update(3)">Guardar</button>
					</div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
                <h2 class="mb-0 accordion-header" id="headingFour">
                     <button class="accordion-button collapsed boton-1 btn-block text-left collapsed text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" id="propuesta">
                        PRESENTACIÓN Y APERTURA DE PROPUESTAS<p class="text-rojo float-end">Sección <span id="seccion_propuesta">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                    </button>
                </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                <div class="accordion-body m-2">
                	<form id="frm_licitacion_4" enctype="multipart/form-data">
                        <div class="row my-3">
				        	<div class="col-12">
				        		<p class="text-1 mt-4">Para capturar la información deberás consultar el documento “Acta de presentación y apertura de propuesta”.</p>
                                <hr>
                            </div>
                        </div>
                        <div class="row my-3">
                        	<div class="col-12 col-md-4 mz-2">
								<div class="form-group row">
									<label for="fecha_propuesta" class="text-1 mx-3">Fecha</label>
									<div class="input-group date hoyant">
										<input type="text" class="form-control text-1" name="fecha_propuesta" id="fecha_propuesta" required>
										<span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
                        </div>
                        <div class="row">&nbsp;</div>
                        <div class="row my-3">
                        	<div class="col-12 col-md-4 mz-2">
                            	<div class="form-group">
										<label class="text-1 mx-3">Proveedores que enviaron propuesta <span id="contador_proveedores_propuesta"> 0 </span></label>
								</div>
							</div>
						</div>
                		<div class="row my-3 scroll espacio_proveedores_corto" id="espacio_propuesta">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_propuesta">
									  							
								</div>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-md-6 mz-2">
                            	<div class="form-group">
										<label class="text-1 mx-3">Proveedores descalificados en evaluación cuantitativa <span id="contador_proveedores_descalificados"> 0 </span></label>
								</div>
							</div>
						</div>
                		<div class="row my-3 scroll espacio_proveedores_corto" id="espacio_descalificados">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_descalificados">
									  							
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
										<input type="file" class="form-control text-1" id="acta_presentacion_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_presentacion_original" required>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="acta_presentacion_publica" class="text-1 mx-3">Acta de presentación y apertura de propuestas (versión pública)</label>
										<input type="file" class="form-control text-1" id="acta_presentacion_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_presentacion_publica" required>
								</div>
							</div>
						</div>	
						<input type="hidden" name="update" value="4">
						<input type="hidden" name="numero_proveedores_propuesta" id="numero_proveedores_propuesta" value="0">
						<input type="hidden" name="numero_proveedores_descalificados" id="numero_proveedores_descalificados" value="0">
                	</form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_licitacion_4" disabled onclick="update(4)">Guardar</button>
					</div>
                </div>
            </div>
        </div>

	    <div class="accordion-item">
	            <h2 class="mb-0 accordion-header" id="headingFive">
	                 <button class="accordion-button collapsed boton-1 btn-block text-left collapsed text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" id="fallo">
	                    FALLO<p class="text-rojo float-end">Sección <span id="seccion_fallo">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
	                </button>
	            </h2>
	        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
	            <div class="accordion-body m-2">
	            	<form id="frm_licitacion_5">
                        <div class="row">
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
										<input type="text" class="form-control text-1" name="fecha_fallo" id="fecha_fallo" required>
										<span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
							</div>
                        </div>
                        <div class="row my-3">
                        	<div class="col-12 col-md-6 mz-2">
                            	<div class="form-group">
										<label class="text-1 mx-3">Proveedores aprobados en evaluación cualitativa <span id="contador_proveedores_aprobados"> 0 </span></label>
								</div>
							</div>
						</div>
                		<div class="row my-3 scroll espacio_proveedores_corto" id="espacio_aprobados">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_aprobados">
																
								</div>
							</div>
						</div>
						<div class="row">&nbsp;</div>
						<div class="row my-3">
							<div class="col-12 col-md-4 mz-2">
                            	<div class="form-group">
										<label class="text-1 mx-3">Proveedores a los que se adjudicó <span id="contador_proveedores_adjudicados"> 0 </span></label>
								</div>
							</div>
						</div>
                		<div class="row my-3 scroll espacio_proveedores_corto" id="espacio_adjudicados">
							<div class="col-12 col-md-12 mz-2">
								<div class="form-group" id="proveedores_adjudicados">
																
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
										<input type="file" class="form-control text-1" id="acta_fallo_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_fallo_original" required>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="acta_fallo_publica" class="text-1 mx-3">Acta de selección de proveedores (versión pública)</label>
										<input type="file" class="form-control text-1" id="acta_fallo_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="acta_fallo_publica" required>
								</div>
							</div>
						</div>
						<div class="row my-3">
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="oficio_adjudicacion_original" class="text-1 mx-3">Oficio de selección de proveedores</label>
										<input type="file" class="form-control text-1" id="oficio_adjudicacion_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="oficio_adjudicacion_original" required>
								</div>
							</div>
							<div class="col-12 col-md-6 mz-2">
								<div class="form-group">
									<label for="oficio_adjudicacion_publica" class="text-1 mx-3">Oficio de selección de proveedores (versión pública)</label>
										<input type="file" class="form-control text-1" id="oficio_adjudicacion_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="oficio_adjudicacion_publica" required>
								</div>
							</div>
						</div>		
						<input type="hidden" name="numero_proveedores_aprobados" id="numero_proveedores_aprobados" value="0">
						<input type="hidden" name="numero_proveedores_adjudicados" id="numero_proveedores_adjudicados" value="0">
						<input type="hidden" name="update" value="5">
                    </form>
                	<div class="modal-footer">
						<button type="button" class="btn boton-1" id="update_licitacion_5" disabled onclick="update(5)">Guardar</button>
					</div>
                </div>
            </div>
        </div>

        <div class="accordion-item">
                <h2 class="mb-0 accordion-header" id="headingSix">
                     <button class="accordion-button collapsed boton-1 btn-block text-left collapsed text-rojo-titulo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix" id="anexos">
                        ANEXOS<p class="text-rojo float-end">Sección <span id="seccion_anexos">incompleta</span> <i class="fa-solid fa-circle-exclamation"></i></p>
                    </button>
                </h2>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
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
                            <h4 class="text-start text-3">
                                <div class="dataTables_length" id="example1_length">
                                    <label>
                                        Documentos adjuntos 
                                    </label>
                                </div>
                            </h4>
                        </div>
                        <div class="col-12 col-md-4 justify-content-center ">
                            <button type="button" class="btn btn-white boton-1 btn-block col-lg-5 col-md-8 p-1" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="anexos_modal">
                                <i class="fa-solid fa-upload" aria-hidden="true"></i> Adjuntar
                            </button>
                        </div>
                    </div>
                    <div class="container">
                    	<table class="table justify-content-md-center text-1" id="tabla_anexos">
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
        <div class="row my-3">
            <div class="col-12 col-md-4 offset-md-8" id="liberar">
                <button class="btn m-2 boton-1" type="button" onclick="liberar()">Liberar procedimiento</button>
            </div>
        </div>

    </div>
</div>

	@section('js2')
		{{-- @routes(['licitacion','anexosLicitacion']); --}}
		<script src="{{ asset('asset/js/licitacion_publica.js') }}" type="text/javascript"></script>
	@endsection
