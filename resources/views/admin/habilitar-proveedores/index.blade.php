@extends('layouts.admin')
@section('content')
	@include('admin.contrato-marco.submenu')
	<div class="container">
		<nav>
			<div class="nav nav-tabs" id="nav-tab" role="tablist">
				<button class="nav-link mz-2 active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
					<h4 class="text-activo">Proveedores</h4>
				</button>
			</div>
		</nav>
		<div class="tab-content border" id="nav-tabContent mt-3">
			<!-- datos generales -->
			<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
				<h2 class="titl-1">1. Habilitar proveedores</h2>
				<p class="text-1">En este espacio habilitarás a los proveedores que participarán en el Contratos Marco.</p>
				<div class="separator"></div>
			</div>
			<div class="container">
		
				<table class="table justify-content-md-center" id="tabla_adhesion">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">RFC</th>
							<th scope="col"># Procedimiento</th>
							<th scope="col">Fecha adhesión</th>
							<th scope="col">Contrato</th>
							<th scope="col" class="tab-cent">Perfil</th>
							<th scope="col" class="tab-cent">Habilitado</th>
							<th scope="col" class="tab-cent">Ver más</th>
							<th scope="col" class="tab-cent">Editar</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<hr>
	<div class="container">
		<a href="{{ route('habilitar_productos.index') }}" class="btn boton-1">Continuar</a>
	</div>
@endsection
@section('js')
	@routes(['habilitarProveedor','catProveedor','submenu'])
    <script src="{{ asset('asset/js/habilitar_proveedor.js') }}" type="text/javascript"></script>
@endsection