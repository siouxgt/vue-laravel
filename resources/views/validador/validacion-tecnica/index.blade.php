@extends('layouts.validador')

	@section('content')
		<h1 class="m-2 p-3">Validación técnica</h1>
		<nav aria-label="breadcrumb">
		    <ol class="breadcrumb">
		        <li class="breadcrumb-item"><a href="{{ route('validador_tecnico.index') }}">Inicio</a></li>
		        <li class="breadcrumb-item"><a href="javascript: void(0)">Validación técnica</a></li>
		    </ol>
		</nav>
		<div class="separator"></div>
		<div class="container">
			<table class="table justify-content-md-center" id="tabla_producto">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Contrato Marco</th>
						<th scope="col"> Proveedor</th>
						<th scope="col">Producto</th>
						<th scope="col">Área técnica</th>
						<th scope="col">Tipo prueba</th>
						<th scope="col" class="tab-cent">Resultados</th>
						<th scope="col" class="tab-cent">Validar</th>
						<th scope="col">Aprobación</th>
						<th scope="col" class="tab-cent">Ficha</th>
					</tr>
				</thead>
			</table>
		</div>

	@endsection
	@section('js')
		@routes('validadorTecnico');
		<script src="{{ asset('asset/js/validador_tecnico.js') }}" type="text/javascript"></script>
	@endsection