@extends('layouts.admin')

@section('content') 
	@include('admin.contrato-marco.submenu')
	<div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                    <h4 class="text-activo">Habilitar producto </h4>
                </button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                    <h4 class="inactivo text-1">Validación de productos</h4>
                </button>
            </div>
        </nav>
	    <div class="tab-content border" id="nav-tabContent">
	        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            	<h6 class="mx-3 titl-1">1. Habilita Productos</h6>
            	<p class="mx-3">Selecciona los productos para este Contrato Marco.</p>
            	<hr>
                <table class="table justify-content-md-center" id="table_producto">
                    <thead>
                        <tr>
                            <th scope="col" class="sortable">#</th>
                            <th scope="col" class="sortable">Clave CABMS</th>
                            <th scope="col" class="sortable">Descripción clave CABMS</th>
                            <th scope="col" class="tab-cent">Productos</th>
                            <th scope="col" class="tab-cent">Habilitado</th>
                            <th scope="col" class="tab-cent">Estatus</th>
                            <th scope="col" class="tab-cent">Ver más</th>
                            <th scope="col" class="tab-cent">Editar</th>
                        </tr>
                    </thead>
                </table>
	        </div>	  
	        <!-- Validación de productos -->
	        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
	            <section>
	                <div class="row p-2">
	                    <div class="col col-sm bg-white border rounded mt-1 ml-2">
	                        <div class="row ml-1 mt-1">
	                            <div class="col-sm-12 col-md-6">
	                                <p class="text-activo">Formularios</p>
	                            </div>
                                <div class="col-sm-12 col-md-6">
                                    <p class="text-2 text-end">Por completar: {{ $formularios - $countFormulariosLleno }} </p>
                                </div>
	                        </div>
	                        <div class="row justify-content-center p-3">
	                            <div class="border rounded col-sm-12 col-md-12 col-lg-6 mt-1">
	                                <p class="text-2 text-center mt-1 mb-1">Creados</p>
	                                <p class="numValida text-center mt-2">{{ $formularios }}</p>
	                            </div>
	                            <div class="border rounded col-sm-12 col-md-12 col-lg-6 mt-1">
	                                <p class="text-2 text-center mt-1">Completados</p>
	                                <p class="numValida text-center mt-1 mb-1">{{ $countFormulariosLleno }}</p>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="col col-sm bg-white border rounded mt-1 ml-2">
	                        <div class="row ml-1 mt-1">
	                            <div class="col-12 col-md-12">
	                                <p class="text-activo">Validación</p>
	                            </div>                            
	                        </div>
	                        <div class="row justify-content-center p-3">
	                            <div class="border rounded col-sm-12 col-md-6 col-lg-3 mt-1 mb-2 ">
	                                <p class="text-2 text-center mt-1 mb-1">Económica</p>
	                                <p class="numValida text-center mt-2">{{ $countEconomica->economica }}</p>
	                                <p class="text-2 text-end">{{ $countEconomica->economica }}/{{$todos->todos }}</p>
	                            </div>
	                            <div class="border rounded col-sm-12 col-md-6 col-lg-3 mt-1 mb-2 ">
	                                <p class="text-2 text-center mt-1">Administrativa</p>
	                                <p class="numValida text-center mt-1 mb-1">{{ $countAdministrativa->administrativa }}</p>
	                                <p class="text-2 text-end">{{ $countAdministrativa->administrativa }}/{{$countEconomica->economica }}</p>
	                            </div>
	                            <div class="border rounded col-sm-12 col-md-6 col-lg-3 mt-1 mb-2 ">
	                                <p class="text-2 text-center mt-1">Sin V. Técnica</p>
	                                <p class="numValida text-center mt-1 mb-1">{{ $countSinTecnica->sintecnica }}</p>
	                            </div>
	                            <div class="border rounded col-sm-12 col-md-6 col-lg-3 mt-1 mb-2 ">
	                                <p class="text-2 text-center mt-1">Con V. Técnica</p>
	                                <p class="numValida text-center mt-1 mb-1">{{ $countTecnica->tecnica }}</p>
	                                <p class="text-2 text-end">{{ $countTecnica->tecnica }}/{{ $countAdminTec->admin }}</p>
	                            </div>
	                        </div>
	                    </div>

	                    <div class="col col-sm bg-white border rounded mt-1 ml-2">
	                        <div class="row ml-1 mt-1">
	                            <div class="col-sm-12 col-md-6">
	                                <p class="text-activo">Publicación</p>
	                            </div>
                                <div class="col-sm-12 col-md-6">
                                    <p class="text-2 text-end">Por finalizar: {{ ( $todos->todos - $countEconomica->economica ) + ($countEconomica->economica - $countAdministrativa->administrativa) + ($countAdminTec->admin - $countTecnica->tecnica ) }}</p>
                                </div>
	                        </div>
	                        <div class="row ml-2 justify-content-center p-3">
	                            <div class="border rounded col-sm-12 col-md-12 col-lg-6 mt-1">
	                                <p class="text-2 text-center mt-1 mb-1">Publicados</p>
	                                <p class="numValida text-center mt-2">{{ $countPublicados->publicados }}</p>
	                            </div>
	                            <div class="border rounded col-sm-12 col-md-12 col-lg-6 mt-1">
	                                <p class="text-2 text-center mt-1">No publicados</p>
	                                <p class="numValida-rojo text-center">{{ $countNoPublicados->nopublicado}}</p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </section>
	            <hr>
	                <form>
	                    <div class="row align-items-end mt-3">
	                        <div class="col-sm-4 text-gold ">
	                            <label for="exampleFormControlSelect1">Clave CABMS</label>
	                            <select class="form-select text-1" id="cabms">
	                                <option value="0">selecciona una opción...</option>
	                                @foreach($cabms as $value)
	                                	<option value="{{ $value->id_e }}" >{{ $value->cabms }} - {{ $value->descripcion }}</option>
	                                @endforeach
	                            </select>
	                        </div>
	                        <div class="col-sm-5 text-1">
	                            <label for="staticEmail" class="col-form-label mb-1">Descripción de la clave CABMS</label>
	                            <input class="form-control text-1 mb-1" type="text" id="descripcion" readonly>
	                        </div>
	                    </div>
	                </form>
	                <hr>
	                <div class="row mt-3 mx-1">
						<div class="col-sm-1">
							<p class="text-1 mt-3">Etapa proceso</p>
						</div>
	                    <div class="botones col">
	                        <a class="btn m-2 boton-5 rounded-pill" href="javascript: void(0)" role="button" onclick="buscar(0)">Validación económica</a>
	                        <a class="btn m-2 boton-5 rounded-pill" href="javascript: void(0)" role="button" onclick="buscar(1)">Validación administrativa</a>
	                        <a class="btn m-2 boton-5 rounded-pill" href="javascript: void(0)" role="button" onclick="buscar(2)">Validación técnica</a>
	                        <a class="btn m-2 boton-5 rounded-pill" href="javascript: void(0)" role="button" onclick="buscar(3)">Publicado</a>
	                    </div>
	                </div>
	                <hr>
	                <h2 class="titl-1" id="nombre"></h2>
	                <div class="row">
	                    <p class="text-left col-5" id="numero_ficha"></p>
	                    <p class="text-right col-3">Unidad de medida: <strong id="unidad"></strong></p>
	                    <p class="text-right col-2">Ficha: <strong id="estatus"></strong></p>
	                    <p class="text- col-2">Versión:<strong id="version"></strong></p>
	                </div>
	                <hr/>
	                <div class="row">
	                	<p class="text-left col-12" id="especificacion"></p>
	                </div>
	                <div class="separator m-3"></div>
	                <table class="table justify-content-md-center mt-3" id="habilitar_producto">
	                    <thead>
	                        <tr>
	                            <th scope="col" class="sortable">#</th>
	                            <th scope="col" class="sortable">Clave CABMS</th>
	                            <th scope="col" class="sortable">Título del producto</th>
	                            <th scope="col" class="sortable">Etapa proceso</th>
	                            <th scope="col" class="tab-cent">Validar</th>
	                        </tr>
	                    </thead>
	                </table>
	            </div>
	        </div>
	        <hr>
	        <div class="container">
	            <div class="botones">
	                <a class="btn m-2 boton-1" href="{{ route('cm_urg.index') }}" role="button">Continuar</a>
	            </div> 
	        </div>

@endsection
@section('js')
	@routes(['habilitarProductos','catProducto','submenu'])
	<script src="{{ asset('asset/js/habilitar_producto.js') }}" type="text/javascript"></script>
@endsection