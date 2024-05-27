<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> produccion --}}
	<title>Contrato Marco URG</title>
    <link rel="icon" href="{{ asset('asset/img/favicon.ico') }}">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
	<link href="{{ asset('asset/css/bootstrap-switch.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/select2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/sweetalert2.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
	<link href="{{ asset('asset/css/tienda_urg.css') }}" rel="stylesheet">
    <script src="{{ asset('asset/js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/datetime-moment.js') }}" type="text/javascript"></script>
</head>

<body>
    <header class="top">
        <div class="row">
            <div class="logos col-12 col-sm-12 col-lg-8 justify-content-start">
                <img class="cdmx" src="{{ asset('asset/img/logoSAFtianguis.png') }}"
                    alt="Logo" />
            </div>
            <div class="iconos col-12 col-sm-12 col-lg-4 justify-content-center mt-4">

                <div class="col-md-2 col-lg-2 align-items-center">
                    <a href="javascript: void(0)"><i class="fa-solid fa-bell iconoHeader sombra text-center"></i></a>
                    <span class="badge badge-white badge-gris ml-3"></span>
                </div>
                <div class="col-md-1 col-lg-1 vl-3 "></div>
                <div class="col-md-1 col-lg-2 text-center dropdown">
                    <span>
                        <a href="javascript: void(0)">
                            <i class="fa-solid fa-user iconoHeader sombra"></i>
                        </a>
                    </span>
                    <div class="dropdown-content alerta-mensajes">
                        <ul class="id">
                            <li><a href="{{ route('users.logout') }}"><img src="{{ asset('asset/img/btnFlechaDer_Mesa de trabajo 1.svg') }}" alt="salir" class="abre-modal m-2" style="width:40%"></a></li>
                            <li><img src="{{ asset('asset/img/id_guinda_Mesa de trabajo 1.svg') }}" alt="ID" class="abre-modal m-2" style="width:40%"></li>
                            <li><img src="{{ asset('asset/img/saberMas_Mesa de trabajo 1.svg') }}" alt="Saber más" class="abre-modal m-2" style="width:40%"></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-1 col-lg-1 vl-3 "></div>

                <div class="col-md-2 col-lg-2 text-center">
                    <a href="javascript: void(0)" id="buscar_favorito"><i class="fa-solid fa-heart car-red"></i></a>
                </div>

                <div class="col-md-1 col-lg-1 vl-3 "></div>

                <div class="col-md-2 col-lg-auto text-center">
                    <a href="javascript: void(0)" id="btn_ver_carrito_compras">
                        <i class="fa-solid fa-cart-shopping car-red"></i>
                    </a>
                    <span class="badge badge-pill badge-light  badge-red" id="cantidad_carrito_compras"></span>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="nav nav-item"><a href="{{ url('tienda_urg') }}" class="{{ Route::is(['tienda_urg.index']) ? 'nav-active' : 'underline' }}">Inicio</a></div>
                <div class="nav nav-item"><a href="{{ url('requisiciones') }}"class="{{ Route::is(['requisiciones.*']) ? 'nav-active' : 'underline' }}">Requisiciones</a>
                </div>
                <div class="nav nav-item dropdown">
                    <a href="{{ url('contrato_urg') }}" class="{{ Route::is(['contrato_urg.*']) ? 'nav-active' : 'underline' }}">Contratos Marco</a>
                </div>
                <div class="dropdown">
                    <a href="{{ url('tienda_urg/ver_tienda') }}" class="{{ Route::is(['tienda_urg.ver_tienda']) ? 'nav-active' : 'underline' }}">Tiendita virtual <i class="fa fa-angle-down gris"></i></a>
                    <div class="dropdown-content" id="dr"></div>
                </div>
                <div class="nav nav-item"><a href="javascript: void(0)" class="underline">Subastas</a></div>
                <div class="dropdown">
                    <a href="javascript: void(0)" class="{{ Route::is(['orden_compra.*', 'orden_compra_urg.*','contrato_oc_urg.*']) ? 'nav-active' : 'underline' }}">Órdenes de compra <i class="fa fa-angle-down gris"></i></a>
                    <div class="dropdown-content">
                        <li class="dropdown">
                            <a href="{{ url('orden_compra') }}" class="dropdown">Órdenes de compra
                                <div style="float: right"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="{{ url('contrato_oc_urg') }}" class="dropdown">Contratos
                                <div style="float: right"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    </div>
                </div>
                 <div class="dropdown">
                    <a href="javascript: void(0)" class="{{ Route::is(['reporte_urg.*', 'incidencia_urg.*']) ? 'nav-active' : 'underline' }}">Reportes <i class="fa fa-angle-down gris"></i></a>
                    <div class="dropdown-content">
                        <li class="dropdown">
                            <a href="{{ route('reporte_urg.index') }}" class="dropdown">Reportes
                                <div style="float: right"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="{{ route('incidencia_urg.index') }}" class="dropdown">Incidentes
                                <div style="float: right"><i class="fa fa-angle-right"></i></div>
                            </a>
                        </li>
                    </div>
                </div>
                <div class="nav nav-item"><a href="{{ route('mensajes_urg.mensajes') }}" class="{{ Route::is(['mensajes_urg.*']) ? 'nav-active' : 'underline' }}">Mensajes</a></div>
            </div>
        </div>
    </nav>

    <main class="container-fluid mt-3">
        @yield('content')
    </main>

    <div class="row" id="div_carrito_compras">
    </div>

    <!-- footer -->
    <footer>
        <!-- Footer -->
        <div class="row ft-leyenda">
            <ul class="ft-leyenda-list text-decoration-none">
                <li>
                    <img src="{{ asset('asset/images/lg_cdmx_footer.svg') }}" alt="" />
                </li>
                <li>
                    Diseñado y operado por la Secretaría de Administración y Finanzas
                    <br>
                    Cualquier duda y/o problema relacionado con el sitio, favor de contactarnos a través de <a
                        href="mailto:mesadeservicio@finanzas.cdmx.gob.mx">mesadeservicio@finanzas.cdmx.gob.mx</a>
                    <br>
                    Se brindará atención telefónica de Lunes a Viernes en el teléfono <strong>(55) 5723 6505 ext. 5026, 5004, 5070</strong>
                    <br>
                    Horario de atención de 09:00 A 17:00 hrs.
                </li>
            </ul>
        </div>

        <!-- Footer legal -->
        <div class="row ft-legal">
            <ul class="ft-legal-list text-decoration-none">
                <li><a href="javascript: void(0)">Términos y condiciones</a></li>
                <li><a href="javascript: void(0)">Política de privacidad</a></li>
                <li>2022 Gobierno de la CDMX</li>
            </ul>
        </div>

    </footer>
    <!-- footer -->


    <script src="{{ asset('asset/js/jquery-3.2.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/popper.min.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="{{ asset('asset/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/select2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/bootstrap-datepicker.es.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/datetime-moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/main.js') }}" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
    <script type="text/javascript">
        const url = "{{ URL::asset('') }}";
    </script>
    <script src="{{ asset('asset/js/main_urg.js') }}" type="text/javascript"></script>

    <script>
        cargarDatosCarrito();

        function cargarDatosCarrito() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                type: "GET",
                url: url + "cc/cantidad_productos_carrito",
                success: function(response) {
                    document.getElementById("cantidad_carrito_compras").innerHTML = response.cantidad;
                },
            });

            cargarVentanaProductosCarrito();
        }

        function cargarVentanaProductosCarrito() {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            $.ajax({
                type: "GET",
                url: url + "cc/mostrar_productos_carrito",
                success: function(response) {
                    let productosCarrito = '',
                        totalCarrito = '',
                        totalCarritoNumerico = 0;

                    for (let i = 0; i < response.datos_carrito.length; i++) {
                        productosCarrito += `<li class="list-group-item border bg-white">
												<div class="row d-flex align-items-center">
													<div class="col-3">
														<img src="{{ asset('/storage/img-producto-pfp/${response.datos_carrito[i].foto_uno}') }}" class="imag-card-carrito" alt="logo">																
													</div>
													<div class="col-9">
														<p class="text-2">${ response.datos_carrito[i].marca }</p>
														<p class="text-1">${ response.datos_carrito[i].nombre_producto }</p>
														<p class="text-1 font-weight-bold">${ formatearNumero(response.datos_carrito[i].precio_unitario) } x ${response.datos_carrito[i].cantidad_producto} ${response.datos_carrito[i].medida}(s)</p>
														<p class="text-1 float-right">Subtotal: <span class="font-weight-bold">${ formatearNumero(calcularSubtotal(response.datos_carrito[i].cantidad_producto, response.datos_carrito[i].precio_unitario)) }</span></p>
													</div>
												</div>
											</li>`;

                        totalCarritoNumerico += calcularSubtotal(response.datos_carrito[i].cantidad_producto,
                            response.datos_carrito[i].precio_unitario);
                    }
                    if (totalCarritoNumerico == 0) {
                        productosCarrito =
                            `<h2 class='text-center text-rojo'>No hay productos en el carrito</h2>`;
                    } else {
                        totalCarrito = `</ul>`;
                        totalCarrito += `<div class="card-body">
											<ul class="list-group list-group-flush">
												<li class="list-group-item bg-light">
													<div class="col-12">
														<p class="titel-2 float-right">Total: <span class="text-red-precio">${ formatearNumero(totalCarritoNumerico) }</span></p>
													</div>
													<div class="col-12 m-2 mt-5 rounded bac-red">
														<a href="javascript: void(0)" id='btn_ver_carrito_desde_menu'>
															<p class="text-carrito text-center">Ver carrito</p>
														</a>
													</div>
													<div class="col-12">
														<a href="javascript: void(0)" id='btn_seguir_comprando_menu'>
															<p class="text-gold text-center">Seguir comprando</p>
														</a>
													</div>
												</li>
											</ul>
										</div>`;
                    }

                    let cabeceraCarrito = `											
												<div>
													<div class="collapse multi-collapse" id="collapse_uno">
														<div class="card card-body"> </div>
													</div>
												</div>
												<div class="col">
													<div class="collapse multi-collapse" id="multiCollapseExample2">
														<div class="card card-body carrito-compras bg-light border">
															<h5 class="card-title text-1 float-right mr-3 mt-2">
																<button type="button" id='btn_cerrar_collapse' class="close" aria-label="Close">
																	<span aria-hidden="true">&times;</span>
																</button>
															</h5>`;
                    cabeceraCarrito +=
                        `<ul class="list-group list-group-flush" style="height: 250px; overflow-y: scroll;">`;

                    let pieCarrito = `
													</div>
												</div>
											</div>`;

                    let fullCarrito = cabeceraCarrito += productosCarrito += totalCarrito += pieCarrito;
                    document.getElementById("div_carrito_compras").innerHTML = fullCarrito;
                },
            });

            function calcularSubtotal(cantidad, precioUnidad) {
                return (cantidad * precioUnidad);
            }

            function formatearNumero(valor) {
                return new Intl.NumberFormat("es-MX", {
                    style: "currency",
                    currency: "MXN"
                }).format(valor);
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            let estadoCollpase = false;

            $(document).on("click", "#btn_ver_carrito_desde_menu", function(e) {
                e.preventDefault();
                verCarrito();
            });

            function verCarrito() {
                window.location = "{{ route('carrito_compra.index')}}";
            }

            $(document).on("click", "#btn_seguir_comprando_menu", function(e) {
                e.preventDefault();
                window.location = "{{ route('tienda_urg.ver_tienda') }}";
            });

            $(document).on("click", "#btn_cerrar_collapse", function(e) {
                e.preventDefault();
                estadoCollpase = false;
                $("#multiCollapseExample2").hide();
            });

            const btnCarritoCompras = document.getElementById("btn_ver_carrito_compras");
            btnCarritoCompras.addEventListener("click", (e) => {
                console.log("No hace nada");
                if (estadoCollpase) {
                    estadoCollpase = false;
                    $("#multiCollapseExample2").hide();
                } else {
                    estadoCollpase = true;
                    $("#multiCollapseExample2").show();
                }
            });

            $(window).scroll(function() {
                if ($(window).scrollTop() > 10) {
                    estadoCollpase = false;
                    $("#multiCollapseExample2").hide();
                }
            });


            const btnBuscarFavorito = document.getElementById("buscar_favorito");
            btnBuscarFavorito.addEventListener("click", (e) => {
                clicFavoritos('true');
            });

            function clicFavoritos(elFavorito) {
                console.log("Se hizo clic: " + elFavorito);
                localStorage.setItem('favoritos', elFavorito)
                window.location = "{{ route("tienda_urg.ver_tienda") }}";
            }
        });
    </script>
    @yield('js')
    @yield('js2')
    @yield('js3')
</body>

</html>
