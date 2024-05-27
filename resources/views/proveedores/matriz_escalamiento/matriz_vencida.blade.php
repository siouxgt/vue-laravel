@extends('layouts.proveedores')

@section('content')
    <div class="row">
        <div class="col-7 col-sm-9 col-md-9 col-lg-10">
            <h1 class="ml-2">Mis datos de contacto</h1>
        </div>
        <div class="col-2 col-sm-2 col-md-3 col-lg-2">
            <div class="text-center">
                <a href="{{ route('proveedor.logout') }}">
                    <img src="{{ asset('asset/images/salir_logout.png') }}" width="90px" alt="Salir" />
                </a>
            </div>            
        </div>
    </div>

    <div class="subtitulo-seccion">
        <h2>Confirma tu información</h2>
    </div>

    <!--AREA DE CONTENIDO - FORMULARIO-->
    <div class="contenedor-general">
        <div class="caja-formulario">
            <div class="cabecera-formulario">
                <h3>Datos personales validados en el Padrón de Proveedores</h3>
            </div>
            <div class="datosNoEditables">
                <p>FOLIO DEL PADRÓN DE PROVEEDORES: <strong>{{ Auth::guard('proveedor')->user()->folio_padron }}</strong>
                </p>
                <p>RFC: <strong>{{ Auth::guard('proveedor')->user()->rfc }}</strong></p>
                <p>NOMBRE:
                    <strong>{{ strtoupper(Auth::guard('proveedor')->user()->nombre_legal) . ' ' . strtoupper(Auth::guard('proveedor')->user()->primer_apellido_legal) . ' ' . strtoupper(Auth::guard('proveedor')->user()->segundo_apellido_legal) }}</strong>
                </p>
                <p>PERSONA: <strong>{{ strtoupper(Auth::guard('proveedor')->user()->persona) }}</strong></p>
                <p>NACIONALIDAD: <strong>{{ strtoupper(Auth::guard('proveedor')->user()->nacionalidad) }}</strong></p>
                <p>MIPYME: <strong>{{ strtoupper(Auth::guard('proveedor')->user()->mipyme) }}</strong></p>
                <p>TIPO DE EMPRESA: <strong>{{ strtoupper(Auth::guard('proveedor')->user()->tipo_pyme) }}</strong></p>
            </div>
            <div class="footer-formulario">
                <div class="vencida">
                    Constancia vencida
                </div>
                <form>
                    <button type="button" class="btn button-dorado" data-toggle="modal" data-target="#exampleModal">
                        Renovar
                    </button>
                </form>
            </div>
        </div>

        <div class="caja-formulario">
            <div class="cabecera-formulario">
                <h3>Datos del Representante legal</h3>
            </div>
            <div class="formulario-datos-tianguis">
                <form>
                    <div class="first-row">
                        <div class="wrap">
                            <div>
                                <input class="codigo_postal" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->codigo_postal }}" />
                                <label for="codigo_postal">Código postal</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="colonia" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->colonia }}" />
                                <label for="colonia">Colonia</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="municipio" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->alcaldia }}" />
                                <label for="municipio">Alcaldía o Municipio</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="entidad" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->entidad_federativa }}" />
                                <label for="entidad">Entidad federativa</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="pais" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->pais }}" />
                                <label for="pais">País</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="tipo_vialidad" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->tipo_vialidad }}" />
                                <label for="tipo_vialidad">Tipo vialidad</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="vialidad" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->vialidad }}" />
                                <label for="vialidad">Vialidad</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="num_ext" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->numero_exterior }}" />
                                <label for="num_ext">Número exterior</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="num_int" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->numero_interior }}" />
                                <label for="num_int">Número interior</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="formulario-datos-tianguis borde">
                <form>
                    <div class="first-row">
                        <div class="wrap">
                            <div>
                                <input class="tel_fijo" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->telefono_legal }}" />
                                <label for="tel_fijo">Número teléfono fijo</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="tel_ext" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->extension_legal }}" />
                                <label for="tel_ext">Extensión</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="tel_celular" type="text" required="required" autocomplete="off"
                                    disabled value="{{ Auth::guard('proveedor')->user()->celular_legal }}" />
                                <label for="tel_celular">Número celular</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="email" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->correo_legal }}" />
                                <label for="email">Correo electrónico</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="formulario-datos-tianguis borde">
                <form>
                    <div class="first-row">
                        <div class="wrap">
                            <div>
                                <input class="name" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->nombre_legal }}" />
                                <label for="name" required="required">Nombre(s)</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="fname" type="text" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->primer_apellido_legal }}" />
                                <label for="fname" required="required">Primer apellido</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="lname" type="text" required="required" autocomplete="off" disabled
                                    value="{{ Auth::guard('proveedor')->user()->segundo_apellido_legal }}" />
                                <label for="lname" required="required">Segundo apellido</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="caja-formulario">
            <div class="cabecera-formulario">
                <h3>Identidad legal</h3>
            </div>
            <div class="formulario-datos-tianguis">
                <form>
                    <div class="first-row">
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->acta_identidad }}" />
                                <label>Número de acta constitutiva</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="@if (Auth::guard('proveedor')->user()->fecha_constitucion_identidad){{ Auth::guard('proveedor')->user()->fecha_constitucion_identidad->format('d/m/Y') }}@endif" />
                                <label>Fecha de constitución</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->titular_identidad }}" />
                                <label>Titular de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->num_notaria_identidad }}" />
                                <label>Número de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->entidad_identidad }}" />
                                <label>Entidad federativa de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->num_reg_identidad }}" />
                                <label>No. del registro público</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="@if (Auth::guard('proveedor')->user()->fecha_reg_identidad){{ Auth::guard('proveedor')->user()->fecha_reg_identidad->format('d/m/Y') }}@endif" />
                                <label>Fecha del registro público</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->tiene_representante ? 'Si' : 'No' }}" />
                                <label class="text-truncate">Acreditación como Representante</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->num_instrumento_representante }}" />
                                <label>No. del instrumento jurídico</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->titular_representante }}" />
                                <label>Titular de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->num_notaria_representante }}" />
                                <label>Número de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->entidad_representante }}" />
                                <label>Entidad federativa de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="{{ Auth::guard('proveedor')->user()->num_reg_representante }}" />
                                <label>No. del registro público</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled
                                    value="@if (Auth::guard('proveedor')->user()->fecha_reg_representante){{ Auth::guard('proveedor')->user()->fecha_reg_representante->format('d/m/Y') }}@endif" />
                                <label>Fecha del registro público</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="caja-formulario">
            <div class="cabecera-formulario">
                <h3>Datos de Contacto</h3>
            </div>
            <div class="nota">
                <p>*Se sugiere que el o los datos de contacto que comparta pertenezca al área comercial, con niveles
                    jerárquicos diferentes.</p>
                <p>*El llenado de los tres niveles de datos de contacto será obligatorio.</p>
            </div>

            <div class="formulario-contactos">

                <form id="frm_m_escalamiento">
                    @csrf
                    <div>
                        <div class="separador-matriz-escalamiento">
                            <div class="titulo-matriz-escalamiento">
                                <h4>Tercer nivel</h4>
                            </div>
                            <div class="linea-separacion-matriz-escalamiento"></div>
                        </div>
                        <div class="row first-row">
                            <div class="wrap">
                                <div>
                                    <input class="name text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->nombre_tres }}"/>
                                    <label for="name" required="required">Nombre(s)</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="fname text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->primer_apellido_tres }}"/>
                                    <label for="fname">Primer apellido</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="lname text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->segundo_apellido_tres }}"/>
                                    <label for="lname" required="required">Segundo apellido</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="cargo text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->cargo_tres }}"/>
                                    <label for="cargo" required="required">Cargo</label>
                                </div>
                            </div>
                        </div>

                        <div class="row first-row">
                            <div class="wrap">
                                <div>
                                    <input class="num_oficina" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->telefono_tres }}"/>
                                    <label for="num_oficina" required="required">Número oficina</label>
                                </div>
                            </div>
                            <div class="wrap">

                                <div>
                                    <input class="extension" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->extension_tres }}"/>
                                    <label for="extension" required="required">Extensión</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="num_celular" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->celular_tres }}"/>
                                    <label for="num_celular" required="required">Número celular</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="email text-lowercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->correo_tres }}"/>
                                    <label for="email" required="required">Correo electrónico</label>
                                </div>
                            </div>
                        </div>

                        <div class="separador-matriz-escalamiento">
                            <div class="titulo-matriz-escalamiento">
                                <h4>Segundo nivel</h4>
                            </div>
                            <div class="linea-separacion-matriz-escalamiento"></div>
                        </div>

                        <div class="row first-row">
                            <div class="wrap">
                                <div>
                                    <input class="name text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->nombre_dos }}">
                                    <label for="name" required="required">Nombre(s)</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="fname text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->primer_apellido_dos }}"/>
                                    <label for="fname">Primer apellido</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="lname text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->segundo_apellido_dos }}"/>
                                    <label for="lname" required="required">Segundo apellido</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="cargo text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->cargo_dos }}"/>
                                    <label for="cargo" required="required">Cargo</label>
                                </div>
                            </div>
                        </div>

                        <div class="row first-row">
                            <div class="wrap">
                                <div>
                                    <input class="num_oficina" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->telefono_dos }}"/>
                                    <label for="num_oficina" required="required">Número oficina</label>
                                </div>
                            </div>
                            <div class="wrap">

                                <div>
                                    <input class="extension" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->extension_dos }}"/>
                                    <label for="extension" required="required">Extensión</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="num_celular" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->celular_dos }}"/>
                                    <label for="num_celular" required="required">Número celular</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="email text-lowercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->correo_dos }}"/>
                                    <label for="email" required="required">Correo electrónico</label>
                                </div>
                            </div>
                        </div>

                        <div class="separador-matriz-escalamiento">
                            <div class="titulo-matriz-escalamiento">
                                <h4>Primer nivel</h4>
                            </div>
                            <div class="linea-separacion-matriz-escalamiento"></div>
                        </div>

                        <div class="row first-row">
                            <div class="wrap">
                                <div>
                                    <input class="name text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->nombre_uno }}"/>
                                    <label for="name" required="required">Nombre(s)</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="fname text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->primer_apellido_uno }}"/>
                                    <label for="fname">Primer apellido</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="lname text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->segundo_apellido_uno }}"/>
                                    <label for="lname" required="required">Segundo apellido</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="cargo text-uppercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->cargo_uno }}"/>
                                    <label for="cargo" required="required">Cargo</label>
                                </div>
                            </div>
                        </div>

                        <div class="row first-row">
                            <div class="wrap">
                                <div>
                                    <input class="num_oficina" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->telefono_uno }}"/>
                                    <label for="num_oficina" required="required">Número oficina</label>
                                </div>
                            </div>
                            <div class="wrap">

                                <div>
                                    <input class="extension" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->extension_uno }}"/>
                                    <label for="extension" required="required">Extensión</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="num_celular" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->celular_uno }}"/>
                                    <label for="num_celular" required="required">Número celular</label>
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="email text-lowercase" type="text" required="required" autocomplete="off"
                                        disabled value="{{ Auth::guard('proveedor')->user()->correo_uno }}"/>
                                    <label for="email" required="required">Correo electrónico</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--  -->

        <div class="footer-formulario-pagina">
            <form>
                <button class="button-dorado-off derecha" type="button" disable>Guardar y continuar</button>
            </form>
        </div>
    </div>

    <!-- Modal V. Económica -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title text-red-precio-1" id="exampleModalLabel">Actualizar constancia vencida</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-2">
                            <img src="{{ asset('asset/img/alertaRoja.svg') }}" style="width: 100%;"
                                alt="alerta">
                        </div>
                        <div class="col-10">
                            <p class="text-1">Estas a punto de dejar esta página. Si sales no se guardará tu información
                                pero podrás capturarla después.</p>
                        </div>
                    </div>
                    <p class="text-red-precio-1 text-center mt-1">¿Confirmas que deseas salir del sitio?</p>
                </div>
                <div class="modal-footer d-flex justify-content-center ">
                    <button type="button" class="btn btn-light align-items-center mt-2" data-dismiss="modal"
                        aria-label="Close">No</button>
                    <a href="{{ route('proveedor.vencida_salir') }}" class="btn button-dorado mt-2 align-items-center"
                        style="text-decoration: none; color:white">SÍ</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal V. Económica -->

    <a href="#top" class="scroll" id="toTop" style="display: block;"> <span id="toTopHover"
            style="opacity: 1;">
        </span></a>
@endsection

@section('js')
    @routes('proveedor')
@endsection
