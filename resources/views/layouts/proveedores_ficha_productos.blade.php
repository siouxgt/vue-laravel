<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests {{--  - produccion --}}
    <title>Contratos Marco Proveedor</title>
    <link rel="icon" href="{{ asset('asset/img/favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.css">
    <link href="{{ asset('asset/css/bootstrap-switch.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/datatables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/catalogos_1.css') }}" rel="stylesheet">
    <script src="{{ asset('asset/js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/datetime-moment.js') }}" type="text/javascript"></script>
</head>

<body>
    <header class="top">
        <div class="row">
            <div class="logos col-12 col-sm-12 col-lg-6 justify-content-start">
                <img class="cdmx" src="{{ asset('asset/img/logoSAFtianguis.png') }}"
                    alt="Logo" />
            </div>
            <div class="iconos col-12 col-sm-12 col-lg-6 justify-content-end">
                <div class="Hd-buscar">
                    <span>
                        <form>
                            <input type="input" class="form__field" placeholder="ID Orden de Compra" name="name"
                                id="search" required />
                        </form>
                        <img class="Hd-buscar" src="{{ asset('asset/iconos/search_off.svg') }}" alt="" />
                    </span>
                </div>

                <div class="Hd-alerta">
                    <span>
                        <div class="alerta-mensajes">
                            <ul class="alerta-mensajes">
                                <li><img class="Hd-alerta" src="{{ asset('asset/iconos/alert_on.svg') }}"
                                        alt="" />
                                    <ul>
                                        <li class="abre-modal" id="tareas"><i
                                                class="fa fa-check-circle alerta-icono " aria-hidden="true"></i>Tareas
                                            <span>12</span>
                                        </li>
                                        <li class="abre-modal" id="mensajes"><i class="fa fa-comment alerta-icono"
                                                aria-hidden="true"></i>Mensajes<span>3</span></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <p>7</p>
                    </span>
                </div>

                <div class="dropdown">
                    <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <a href="javascript: void(0)">
                            <i class="fa-solid fa-user iconoHeader sombra"></i>
                        </a>
                    </span>
                    <div class="dropdown-content alerta-mensajes">
                        <ul class="id">
                            <li>
                                <a href="{{ route('proveedor.logout') }}">
                                    <img src="{{ asset('asset/img/btnFlechaDer_Mesa de trabajo 1.svg') }}" alt="salir" class="abre-modal m-2" style="width:40%">
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('proveedor.abrir_me') }}" title="Ir a mi perfil">
                                    <img src="{{ asset('asset/img/id_guinda_Mesa de trabajo 1.svg') }}" alt="ID" class="abre-modal m-2" style="width:40%">
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('mensaje_proveedor') }}" title="Ir a mensajes">
                                    <img src="{{ asset('asset/img/saberMas_Mesa de trabajo 1.svg') }}" alt="Saber más" class="abre-modal m-2" style="width:40%">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class=" container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="dropdown"><a href="{{ url('proveedor/aip') }}" class="{{ Route::is('proveedor.aip') ? 'nav-active' : 'underline' }}">Inicio</a>
                </div>
                <div class="dropdown">
                    <a href="{{ url('proveedor_fp/') }}" class="{{ Route::is('proveedor_fp.*') ? 'nav-active' : 'underline' }}">Catálogo de productos</a>
                </div>
                <div class="dropdown">
                    <a href="{{ url('contrato_proveedor/') }}" class="{{ Route::is('contrato_proveedor.*') ? 'nav-active' : 'underline' }}">Contratos marco</a>
                </div>

                {{-- <div class="nav nav-item"><a href="#" class="underline">Subastas</a></div> --}}

                <div class="dropdown">
                    <a href="javascript: void(0)"
                        class="{{ Route::is(['orden_compra_proveedores.*']) ? 'nav-active' : 'underline' }}">Órdenes de compra <i class="fa fa-angle-down gris" aria-hidden="true"></i></a>
                    <div class="dropdown-content">
                        <li class="dropdown">
                            <a href="{{ url('orden_compra_proveedores') }}" class="dropdown">Órdenes de compra
                                <div style="float: right">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="{{ url('orden_compra_proveedores/contrato/index') }}" class="dropdown">Contratos
                                <div style="float: right"><i class="fa fa-angle-right" aria-hidden="true"></i>
                                </div>
                            </a>
                        </li>
                    </div>
                </div>

                <div class="dropdown">
                    <a href="javascript: void(0)"
                        class="{{ Route::is(['reporte_proveedor.*', 'incidencia_proveedor.*']) ? 'nav-active' : 'underline' }}">Reportes<i class="fa fa-angle-down gris" aria-hidden="true"></i></a>
                    <div class="dropdown-content">
                        <li class="dropdown">
                            <a href="{{ url('reporte_proveedor') }}" class="dropdown">Reportes
                                <div style="float: right">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown nav-item">
                            <a href="{{ url('incidencia_proveedor') }}" class="dropdown">Incidencias
                                <div style="float: right">
                                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                                </div>
                            </a>
                        </li>
                    </div>
                </div>

                <div class="dropdown">
                    <a href="{{ url('mensaje_proveedor') }}"
                        class="{{ Route::is('mensaje_proveedor.*') ? 'nav-active' : 'underline' }}">Mensajes</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="container-fluid">
        @yield('content')
    </main>

    <!-- footer -->
    <footer>
        <!-- Footer -->
        <div class="row">
            <div class="col-2">
                <img src="{{ asset('asset/images/lg_cdmx_footer.svg') }}" alt="" />
            </div>
            <div class="col-10">
                <p>
                    Diseñado y operado por la Secretaría de Administración y Finanzas
                </p>
                <p>
                    Cualquier duda y/o problema relacionado con el sitio, favor de contactarnos a través de <a
                        href="mailto:mesadeservicio@finanzas.cdmx.gob.mx">mesadeservicio@finanzas.cdmx.gob.mx</a>
                </p>
                <p>
                    Se brindará atención telefónica de Lunes a Viernes de 09:00 AM a 17:00 PM en el teléfono
                    <strong>(55) 5723 6505 ext. 5026,
                        5004, 5070</strong>
                </p>
            </div>
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
        const url = "{{ URL::asset('') }}"
    </script>
    @yield('js')
    @yield('js2')
</body>

</html>
