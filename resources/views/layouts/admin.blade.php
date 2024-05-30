<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">--}}
    <title>Contrato Marco Administrador</title>
    <link rel="icon" href="{{ asset('asset/img/favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"> --}}
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css">
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,1,200" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link href="{{ asset('asset/css/bootstrap-switch.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
    <script src="{{ asset('asset/js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/datetime-moment.js') }}" type="text/javascript"></script>
    {{-- <link href="{{ asset('asset/css/administrador.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('asset/css/styleGenerales.css') }}" rel="stylesheet">
</head>

<body>

    

{{--     <div class="container p-3">
         
        
        

    </div> --}}
    
    




    <header class="py-4 px-5">
		<div class="row contenedor d-flex justify-content-between">
			<div class="col-lg-auto col-md-12 col-sm-12">
				<img class="cdmx" src="{{ asset('asset/img/logoSAFtianguis.png') }}" alt="Logo" height="70"/>
			</div>

            <div class="col-lg-auto col-md-12 col-sm-12 col-xs-6 d-flex align-items-center">
                <div class="buscar d-flex">
                    <span>
                        <form>
                            <input type="input" class="form__field" placeholder="ID o Contrato" name="name" id="search" required />
						</form>
					</span>
                    <img class="mt-1" src="{{ asset('asset/iconos/search_off.svg') }}" alt="" />
				</div>
                <div class="Hd-alerta offset-1">
					<span>
						<div class="alerta-mensajes">
							<ul class="alerta-mensajes">
								<li class="mb-2 offset-2">

                                    <img class="Hd-alerta" src="{{ asset('asset/iconos/alert_on.svg') }}" alt="" />
									<ul>
										<li class="abre-modal" id="tareas"><i class="fa fa-check-circle alerta-icono " aria-hidden="true"></i>Tareas
											<span>12</span>
										</li>
										<li class="abre-modal" id="mensajes"><i class="fa fa-comment alerta-icono" aria-hidden="true"></i>Mensajes<span>3</span></li>
									</ul>

								</li>
							</ul>
						</div>
						<p class="offset-4 mb-2">7</p>
					</span>
                    
				</div>
                <div class="dropdown">
                    <span>
						<h2 class="perfil">{{ substr(auth()->user()->nombre,0,1) . substr(auth()->user()->primer_apellido,0,1) }}</h2>
					</span>
                    <ul class="dropdown-content alerta-mensajes" aria-labelledby="dropdownMenuButton1">
                        <li><a href="{{ route('users.logout') }}"><img src="{{ asset('asset/img/btnFlechaDer_Mesa de trabajo 1.svg') }}" alt="salir" class="abre-modal m-2" style="width:40%"></a></li>
                        <li><img src="{{ asset('asset/img/id_guinda_Mesa de trabajo 1.svg') }}" alt="ID" class="abre-modal m-2" style="width:60%"></li>
                        <li><img src="{{ asset('asset/img/saberMas_Mesa de trabajo 1.svg') }}" alt="Saber más" class="abre-modal m-2" style="width:40%"></li>
                    </ul>
                  </div>
			{{-- 	<div class="dropdown">
					<span>
						<h2 class="perfil">{{ substr(auth()->user()->nombre,0,1) . substr(auth()->user()->primer_apellido,0,1) }}</h2>
					</span>
					<div class="dropdown-content alerta-mensajes">
						<ul class="id">
							<li><a href="{{ route('users.logout') }}"><img src="{{ asset('asset/img/btnFlechaDer_Mesa de trabajo 1.svg') }}" alt="salir" class="abre-modal m-2" style="width:40%"></a></li>
							<li><img src="{{ asset('asset/img/id_guinda_Mesa de trabajo 1.svg') }}" alt="ID" class="abre-modal m-2" style="width:40%"></li>
							<li><img src="{{ asset('asset/img/saberMas_Mesa de trabajo 1.svg') }}" alt="Saber más" class="abre-modal m-2" style="width:40%"></li>
						</ul>
					</div>
				</div> --}}
			</div>
			{{-- <div class="col-3">
				<div class="Hd-buscar">
					<span>
						<form>
							<input type="input" class="form__field" placeholder="ID o Contrato" name="name" id="search" required />
						</form>
						<img class="Hd-buscar" src="{{ asset('asset/iconos/search_off.svg') }}" alt="" />
					</span>
				</div>

				<div class="Hd-alerta">
					<span>
						<div class="alerta-mensajes">
							<ul class="alerta-mensajes">
								<li><img class="Hd-alerta" src="{{ asset('asset/iconos/alert_on.svg') }}" alt="" />

									<ul>
										<li class="abre-modal" id="tareas"><i class="fa fa-check-circle alerta-icono " aria-hidden="true"></i>Tareas
											<span>12</span>
										</li>
										<li class="abre-modal" id="mensajes"><i class="fa fa-comment alerta-icono" aria-hidden="true"></i>Mensajes<span>3</span></li>
									</ul>

								</li>
							</ul>
						</div>
						<p>7</p>
					</span>
				</div>

				<div class="dropdown">
					<span>
						<h2 class="perfil">{{ substr(auth()->user()->nombre,0,1) . substr(auth()->user()->primer_apellido,0,1) }}</h2>
					</span>
					<div class="dropdown-content alerta-mensajes">
						<ul class="id">
							<li><a href="{{ route('users.logout') }}"><img src="{{ asset('asset/img/btnFlechaDer_Mesa de trabajo 1.svg') }}" alt="salir" class="abre-modal m-2" style="width:40%"></a></li>
							<li><img src="{{ asset('asset/img/id_guinda_Mesa de trabajo 1.svg') }}" alt="ID" class="abre-modal m-2" style="width:40%"></li>
							<li><img src="{{ asset('asset/img/saberMas_Mesa de trabajo 1.svg') }}" alt="Saber más" class="abre-modal m-2" style="width:40%"></li>
						</ul>
					</div>
				</div>
			</div> --}}
		</div>
	</header>


   






    {{-- -----------cambios----------------------- --}}
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse align-items-center" id="navbarSupportedContent">
                <ul class="navbar-nav ">
                    <div class="nav nav-item mt-3"><a href="{{ route('index') }}"
                            class="{{ Route::is('index') ? 'nav-active' : 'underline' }}">Inicio</a>
                    </div>
                    <div class="nav nav-item dropdown">
                        <a href="javascript: void(0)"
                        class="{{ Route::is(['cat_proveedor.*', 'cat_producto.*', 'urg.*', 'validacion.*']) ? 'nav-active' : 'underline' }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">Catálogos
                        <i class="fa fa-angle-down gris" aria-hidden="true"></i></a>
                            <div class="dropdown-content">
                                <li class="dropdown nav-item">
                                    <a href="{{ url('cat_proveedor') }}" class="dropdown">Proveedores
                                        <div class="float-end"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown nav-item">
                                    <a href="{{ url('cat_producto') }}" class="dropdown">Productos
                                        <div class="float-end"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown nav-item">
                                    <a href=" {{ url('urg') }} " class="dropdown">URGs
                                        <div class="float-end"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="dropdown nav-item">
                                    <a href=" {{ url('validacion') }} " class="dropdown">Validación técnica
                                        <div class="float-end"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </li>
                            </div>
                    </div>    
                    <div class="nav nav-item mt-3"><a href="{{ url('contrato') }}"
                            class="{{ Route::is(['contrato.*', 'expedientes_contrato.*', 'grupo_revisor.*', 'habilitar_proveedores.*', 'habilitar_productos.*', 'cm_urg.*']) ? 'nav-active' : 'underline' }}">Contrato
                            Marco</a>
                    </div>
                    <div class="nav nav-item mt-3"><a href="{{ route('orden_compra_admin.index') }}"
                            class="{{ Route::is('orden_compra_admin.*') ? 'nav-active' : 'underline' }}"><span class="text-center">Órdenes de
                                Compra</span></a>
                    </div>
                    
                    <div class="nav nav-item mt-3"><a href="{{ route('usuarios.index') }}" class="{{ Route::is('usuarios.*') ? 'nav-active': 'underline' }}">Permisos</a></div>
                    <div class="nav nav-item dropdown">
                        <a href="javascript: void(0)" class="underline" role="button" data-bs-toggle="dropdown" aria-expanded="false">Subasta<i class="fa fa-angle-down gris"
                                aria-hidden="true"></i>
                        </a>
                        <div class="dropdown-content">
                            <li class="dropdown nav-item">
                                <a href="{{ url('get_calendar') }}" class="dropdown">Calendario de subasta
                                    <div class="float-end ml-3"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                        </div>
                    </div>
                    <div class="dropdown">
                        <a href="javascript: void(0)" class="{{ Route::is(['reporte_admin.*','incidencia_admin.*']) ? 'nav-active': 'underline' }}">Reportes<i class="fa fa-angle-down gris" aria-hidden="true"></i></a>
                        <div class="dropdown-content">
                            <li class="dropdown">
                                <a href="{{ route('incidencia_admin.index') }}" class="dropdown">Incidencias
                                    <div style="float: right"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="dropdown nav-item">
                                <a href="{{ route('reporte_admin.index') }}" class="dropdown">Reportes
                                    <div style="float: right"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                    </div>
                                </a>
                            </li>
                        </div>
                    </div>
                    <div class="nav nav-item dropdown">
                        <a href="javascript: void(0)" class="underline role="button" data-bs-toggle="dropdown" aria-expanded="false">Mensajes <i class="fa fa-angle-down gris"
                                aria-hidden="true"></i></a>
                        <div class="dropdown-content">
                            <li></li>
                        </div>
                    </div>
                </ul>    
            </div>
        </div>
    </nav>

 

 

    <main class="container-fluid">
        @yield('content')
    

    </main

    <!-- footer -->
    <footer>
        <div class="row no-gutters">
            <div class="col-12 ft-leyenda">
                <ul class="ft-leyenda-list text-decoration-none">
                    <li>
                        <img src="{{ asset('asset/images/lg_cdmx_footer.svg') }}" alt="" />
                    </li>
                    <li class="text-decoration-none">
                        Diseñado y operado por la Secretaría de Administración y Finanzas
                        <br>
                        Cualquier duda y/o problema relacionado con el sitio, favor de contactarnos a través de <a
                            href="mailto:mesadeservicio@finanzas.cdmx.gob.mx">mesadeservicio@finanzas.cdmx.gob.mx</a>
                        <br>
                        Se brindará atención telefónica de Lunes a Viernes en el teléfono <strong>(55) 5723 6505
                            ext. 5026,
                            5004,
                            5070</strong><br>
                            Horario de atención de 09:00 A 17:00 hrs.
                    </li>
                </ul>
            </div>
        </div>
      <nav></nav>
    </footer>
    <!-- footer -->

    
    <script src="{{ asset('asset/js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/popper.min.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    <script src="{{ asset('asset/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/main.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    </script>
    <script type="text/javascript">
        const url = "{{ URL::asset('') }}"
    </script>
    @yield('js')
    @yield('js2')
    @yield('js3')
    <script src="{{mix('js/app.js')}}"></script>
</body>

</html>
