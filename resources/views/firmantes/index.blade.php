@extends('layouts.firmante')

	@section('content')
		<h1 class="m-2 p-3">Contratos</h1>
		<p class="text-2 px-4">En esta página encontrarás los contratos de compras realizadas dentro de Contrato Marco. Para ver firmarlos sólo da clic en el botón de la columna “eFirma”</p>
		<div class="separator"></div>
	 	<div class="row mt-2 mb-3 justify-content-center">
		    <div class="col-12 col-md-12 col-lg-3 d-flex mt-1">
		        <div class="col-1">
		          	<span class="badge badge-pill badge-gris-1">{{ $totalContratos }}</span>
		        </div>
		        <div class="col-11">
		          	<p class="text-1 ml-2 font-weight-bold">Total Contratos</p>
		        </div>
		    </div>

		    <div class="col-12 col-md-12 col-lg-3 d-flex mt-1">
		        <div class="col-1">
		          	<span class="badge badge-pill badge-secondary">{{ $firmados}}</span>
		        </div>
		        <div class="col-11">
		          	<p class="text-1 ml-2 font-weight-bold">Contratos firmados</p>
		        </div>
		    </div>

		    <div class="col-12 col-md-12 col-lg-3 d-flex mt-1">
		        <div class="col-1">
		          	<span class="badge badge-pill badge-red-1">{{ $totalContratos - $firmados }}</span>
		        </div>
		        <div class="col-11">
		          	<p class="text-1 ml-2 font-weight-bold">Contratos por firmar</p>
		        </div>
		    </div>
		   
		</div>
		<div class="separator"></div>
		<div class="container-flex mt-3">
			<table class="table justify-content-md-center" id="tabla_contratos">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Id orden</th>
						<th scope="col">Alta contrato</th>
						<th scope="col">Proveedor</th>
						<th scope="col" class="tab-cent">eFirma Proveedor</th>
						<th scope="col" class="tab-cent">eFirma DGA</th>
						<th scope="col" class="tab-cent">eFirma Adq./compras</th>
						<th scope="col" class="tab-cent">eFirma Finanzas</th>
						<th scope="col" class="tab-cent">eFirma A. Requiriente</th>
						<th scope="col" class="tab-cent">eFirma</th>
						<th scope="col">Contrato</th>
						<th scope="col" class="tab-cent">Días para firmar</th>
					</tr>
				</thead>
			</table>
		</div>

	@endsection
	@section('js')
		@routes('firmante')
		<script src="{{ asset('asset/js/firmante.js') }}" type="text/javascript"></script>
	@endsection