@extends('layouts.admin')

@section('content')    
	<main class="m-3">
		<h1 class="m-2 guinda p-3"><strong>Productos</strong></h1>
		<div class="row">
			<nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">Inicio</li>
					<li class="breadcrumb-item">Catálogos</li>
					<li class="breadcrumb-item"><a href="{{ route('cat_producto.index') }}">Productos</a></li>
					<li class="breadcrumb-item active" aria-current="page">Ver</li>
				</ol>
			</nav>
		</div>	
	</main>

	<div class="container-fluid">
		<div class="row">

			<!-- Nav tabs -->
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item reg" role="presentation">
					<button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">
						<a href="javascript: void(0);" onclick="history.back();" class="back text-decoration-none">
							<span class="dorado">Regresar</span>
						</a>
					</button>
				</li>
				<li class="nav-item text-decoration-none" role="presentation">
					<button class="nav-link active hoverTab text-decoration-none" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
						type="button" role="tab" aria-controls="profile" aria-selected="false">
						<span class="tabText">Catálogo</span>
					</button>
				</li>
				

				<li class="nav-item" role="presentation">
					<button class="nav-link hoverTab" id="other-tab" data-bs-toggle="tab" data-bs-target="#messages"
						type="button" role="tab" aria-controls="messages" aria-selected="false">
						Producto habilitado</button>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="container">
						<div class="row ">
							<div class="col-12">
								<div style="overflow-x: auto;" class="px-5 pt-4 mx-2">
									<table class="tab-cen">
										<tr>
											<th class="derecha">
												<strong>No. Ficha</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->numero_ficha }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Versión</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->version }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Estatus</strong>
											</th>
											<td class="izquierda">
												@if($catProducto->estatus) Activo @else Inactivo @endif
											</td>
										</tr>
									</table>
									<hr>
									<table>
										<tr>
											<th class="derecha">
												<strong>Capítulo</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->capitulo }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Partida</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->partida }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Clave CABMS</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->cabms }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Descripción clave CABMS</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->descripcion }}
											</td>
										</tr>
									</table>
                                    <hr>
                                    <table>
										<tr>
											<th class="derecha">
												<strong>Número de Contrato Marco</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->contratoMarco->numero_cm }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Nombre del contrato</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->contratoMarco->nombre_cm }}
											</td>
										</tr>
									</table>
                                    <hr>
                                    <table class="tab-cen-1">
										<tr>
											<th class="derecha">
												<strong>Especificaciones</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->especificaciones }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Unidad de medida</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->medida }}
											</td>
										</tr>
									</table>
                                    <hr>
                                    <table>
										<tr>
											<th class="derecha">
												<strong>Validación técnica</strong>
											</th>
											<td class="izquierda">
												@if($catProducto->validacion_tecnica) Si @else No @endif
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Tipo de prueba requerida</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->tipo_prueba }}
											</td>
										</tr>
                                        <tr>
											<th class="derecha">
												<strong>Equipo Validación técnica</strong>
											</th>
											<td class="izquierda">
												@if($catProducto->validacion_id) {{ $catProducto->validacionTecnica->siglas }} @endif
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages">
					<div class="container">
						<div class="row ">
							<div class="col-12">
								<div style="overflow-x: auto;" class="px-5 pt-4 mx-2">
									<table class="tab-cen">
										<tr>
											<th class="derecha">
												<strong>Clave CABMS</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->cabms }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Descripción clave CABMS</strong>
											</th>
											<td class="izquierda">
												{{ $catProducto->descripcion }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Convocatoria No.</strong>
											</th>
											<td class="izquierda">
												@if($habilitarProducto) {{ $habilitarProducto->convocatoria }} @endif
											</td>
										</tr>
									</table>
									<hr>
									<table class="tab-cen">
										<tr>
											<th class="derecha">
												<strong>Precio Máximo (PMR)</strong>
											</th>
											<td class="izquierda">
												@if($habilitarProducto) ${{ number_format($habilitarProducto->precio_maximo, 2, '.', ',') }} @endif
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Fecha del estudio</strong>
											</th>
											<td class="izquierda">
												@if($habilitarProducto) {{ \Carbon\Carbon::parse($habilitarProducto->fecha_estudio)->format('d/m/Y') }} @endif
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Estudio de precios</strong>
											</th>
											<td class="izquierda">
												@if($habilitarProducto) <a href="{{ asset('storage/precio-maximo/'.$habilitarProducto->archivo_estudio_original) }}" class="btn btn-cdmx" target="_blank"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a> @endif
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Estudio de precios (versión pública)</strong>
											</th>
											<td class="izquierda">
												@if($habilitarProducto) <a href="{{ asset('storage/precio-maximo/'.$habilitarProducto->archivo_estudio_publico) }}" class="btn btn-cdmx" target="_blank"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a> @endif
											</td>
										</tr>
									</table>
									<hr>
									<table class="tab-cen">
										<tr>
											<th class="derecha">
												<strong>1. Creación formulario</strong>
											</th>
											<td class="izquierda">
												@if($habilitarProducto) {{ \Carbon\Carbon::parse($habilitarProducto->fecha_formulario)->format('d/m/Y') }} @endif
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>2. Carga de producto</strong>
											</th>
											<td class="izquierda">
												@if($habilitarProducto) {{ \Carbon\Carbon::parse($habilitarProducto->fecha_carga)->format('d/m/Y') }} @endif
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>3. Validación adtva.</strong>
											</th>
											<td class="izquierda">
												@if($habilitarProducto) {{ \Carbon\Carbon::parse($habilitarProducto->fecha_administrativa)->format('d/m/Y') }} @endif
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>4. Validación técnica</strong>
											</th>
											<td class="izquierda">
												@if($habilitarProducto)  {{ \Carbon\Carbon::parse($habilitarProducto->fecha_tecnica)->format('d/m/Y') }} @endif
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>5. Publicación producto</strong>
											</th>
											<td class="izquierda">
												@if($habilitarProducto) {{ \Carbon\Carbon::parse($habilitarProducto->fecha_publicacion)->format('d/m/Y') }} @endif
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('js')
	<script>
		let anterior = document.referrer;
		anterior = anterior.split('/')
		if(anterior[anterior.length -1] == 'habilitar_productos'){
			let catalogo = document.querySelector('#profile-tab');
			let contentCatalogo = document.querySelector('#profile');
			let producto = document.querySelector('#other-tab');
			let contentProducto = document.querySelector('#messages');
			catalogo.classList.remove('active','show');
			contentCatalogo.classList.remove('active','show');
			catalogo.setAttribute('aria-selected',false);
			producto.classList.add('active','show');
			contentProducto.classList.add('active','show');
			producto.setAttribute('aria-selected',true);
		}
	</script>
@endsection