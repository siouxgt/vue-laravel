@extends('layouts.admin')

	@section('content')

	<h1 class="m-2 guinda fw-bold p-3"><strong>Proveedores</strong></h1>
	<div class="row">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="#">Inicio</a></li>
				<li class="breadcrumb-item">Catálogos</li>
				<li class="breadcrumb-item"><a href="{{ url('cat_proveedor') }}">Proveedores</a></li>
				<li class="breadcrumb-item active" aria-current="page">Ver</li>
			</ol>
		</nav>
		<div class="separator"></div>
		
		<div class="container-fluid">
		<div class="row">

			<!-- Nav tabs -->
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item reg" role="presentation">
					<button class="nav-link" id="home-tab" type="button">
						<a href="javascript: void(0);" onclick="history.back();" class="back">
							<span>Regresar</span>
						</a>
					</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link active hoverTab" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
						<span class="tabText gris1">Catálogo</span>
					</button>
				</li>
				

				<li class="nav-item" role="presentation">
					<button class="nav-link hoverTab" id="other-tab" data-bs-toggle="tab" data-bs-target="#messages" type="button" role="tab" aria-controls="messages" aria-selected="false">
						<span class="gris1 text-decoration-none">Matriz de escalamiento</span></button>
				</li>
			</ul>

			<!-- Tab panes -->
			<div class="tab-content justify-content-center">
				<div class="tab-pane active nav-link active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="container">
						<div class="row">
							<div class="col-12">
								<div style="overflow-x: auto;" class="px-5 pt-4 mx-2">
									<table>
										<tr>
											<th class="derecha">
												<strong>RFC</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->rfc }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Folio Padrón Proveedores</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->folio_padron }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Nombre</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->nombre }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Persona</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->persona }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Nacionalidad</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->nacionalidad }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>MIPYME</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->mipyme }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Tipo MIPYME</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->tipo_pyme }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Estatus</strong>
											</th>
											<td class="izquierda">
												@if( $proveedor->estatus ) Activo @else Inactivo @endif
											</td>
										</tr>
									</table>
									<hr>
									<table>
										<tr>
											<th class="derecha">
												<strong>Representante legal</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->nombre_legal ." ". $proveedor->primer_apellido_legal ." ". $proveedor->segundo_apellido_legal }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Domicilio</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->tipo_vialidad ." ". $proveedor->vialidad ." ". $proveedor->numero_exterior ." ". $proveedor->numero_interior .", ". $proveedor->codigo_postal .", ".$proveedor->colonia .", ". $proveedor->alcaldia .", ". $proveedor->entidad_federativa .", ". $proveedor->pais }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Número fíjo</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->telefono_legal }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Extensión</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->extension_legal }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Número celular</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->celular_legal }}
											</td>
										</tr>
										<tr>
											<th class="derecha">
												<strong>Correo electrónico</strong>
											</th>
											<td class="izquierda">
												{{ $proveedor->correo_legal }}
											</td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane justify-content-md-center nav-link" id="messages" role="tabpanel" aria-labelledby="messages">
					<div class="row justify-content-center">
						<table class="table col-8">
							<thead>
								<tr>
									<th scope="col" class="tab-cent">RFC</th>
									<th scope="col" class="tab-cent">Procedimiento</th>
									<th scope="col" class="tab-cent">Fecha adhesión</th>
									<th scope="col" class="tab-cent">Contrato</th>
									<th scope="col" class="tab-cent">Perfil</th>
									<th scope="col" class="tab-cent">Alta</th>
								</tr>
							</thead>
							<tbody>
								@foreach($proveedorHabilitado as $proveedorH) 
									<tr>
										<td class="tab-cent">{{ $proveedorH->rfc }}</td>
										<td class="tab-cent">{{ $proveedorH->num_procedimiento }}</td>
										<td class="tab-cent">@if($proveedorH->fecha_adhesion) {{ \Carbon\Carbon::parse($proveedorH->fecha_adhesion)->format('d/m/Y') }} @endif</td>
										<td class="tab-cent">
											@if($proveedorH->archivo_adhesion)
												<a class="btn btn-cdmx" target="_blank" href="{{ asset('storage/contrato-adhesion/'.$proveedorH->archivo_adhesion) }}"><i class="fa-solid fa-file-pdf fa-lg dorado"></i></a>
											@endif
										</td>
										<td class="tab-cent">
											@if($proveedorH->perfil_completo) <i class="gris fa-solid fa-check fa-lg"></i> @else <i class="gris fa-solid fa-xmark fa-lg"></i> @endif
										</td>
										<td class="tab-cent">
											@if($proveedorH->habilitado) <i class="gris fa-solid fa-check fa-lg"></i> @else <i class="gris fa-solid fa-xmark fa-lg"></i> @endif
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
						<div class="separator"></div>
						<div class="row col-12 col-md-8">
							<div class="col-12 col-md-12 col-lg-4">
								<div style="overflow-x: auto;" class="px-5 pt-4 mx-2">
									<p class="text-2"><strong>Nivel:</strong>Tercero</p>
										<p class="text-2"><strong>Nombre completo:</strong>{{ $proveedor->nombre_tres ." ". $proveedor->primer_apellido_tres ." ". $proveedor->segundo_apellido_tres }}</p>
										<p class="text-2"><strong>Cargo:</strong>{{ $proveedor->cargo_tres }}</p>
										<p class="text-2"><strong>Número oficina:</strong>{{ $proveedor->telefono_tres }}</p>
										<p class="text-2"><strong>Extensión:</strong>{{ $proveedor->extension_tres }}</p>
										<p class="text-2"><strong>Núm. celular:</strong>{{ $proveedor->celular_tres }}</p>
										<p class="text-2"><strong>Correo electrónico:</strong>{{ $proveedor->correo_tres }}</p>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-4">
								<div style="overflow-x: auto;" class="px-5 pt-4 mx-2">
									<p class="text-2"><strong>Nivel:</strong>Segundo</p>
										<p class="text-2"><strong>Nombre completo:</strong>{{ $proveedor->nombre_dos ." ". $proveedor->primer_apellido_dos ." ". $proveedor->segundo_apellido_dos }}</p>
										<p class="text-2"><strong>Cargo:</strong>{{ $proveedor->cargo_dos }}</p>
										<p class="text-2"><strong>Número oficina:</strong>{{ $proveedor->telefono_dos }}</p>
										<p class="text-2"><strong>Extensión:</strong>{{ $proveedor->extension_dos }}</p>
										<p class="text-2"><strong>Núm. celular:</strong>{{ $proveedor->celular_dos }}</p>
										<p class="text-2"><strong>Correo electrónico:</strong>{{ $proveedor->correo_dos }}</p>
								</div>
							</div>
							<div class="col-12 col-md-12 col-lg-4">
								<div style="overflow-x: auto;" class="px-5 pt-4 mx-2">
									<p class="text-2"><strong>Nivel:</strong>Primero</p>
										<p class="text-2"><strong>Nombre completo:</strong>{{ $proveedor->nombre_uno ." ". $proveedor->primer_apellido_uno ." ". $proveedor->segundo_apellido_uno }}</p>
										<p class="text-2"><strong>Cargo:</strong>{{ $proveedor->cargo_uno }}</p>
										<p class="text-2"><strong>Número oficina:</strong>{{ $proveedor->telefono_uno }}</p>
										<p class="text-2"><strong>Extensión:</strong>{{ $proveedor->extension_uno }}</p>
										<p class="text-2"><strong>Núm. celular:</strong>{{ $proveedor->celular_uno }}</p>
										<p class="text-2"><strong>Correo electrónico:</strong>{{ $proveedor->correo_uno }}</p>
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
			if(anterior[anterior.length -1] == 'habilitar_proveedores'){
				let catalogo = document.querySelector('#profile-tab');
				let contentCatalogo = document.querySelector('#profile');
				let matriz = document.querySelector('#other-tab');
				let contentMatriz = document.querySelector('#messages');
				catalogo.classList.remove('active','show');
				contentCatalogo.classList.remove('active','show');
				catalogo.setAttribute('aria-selected',false);
				matriz.classList.add('active','show');
				contentMatriz.classList.add('active','show');
				matriz.setAttribute('aria-selected',true);
			}
		</script>
	@endsection