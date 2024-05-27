@extends('layouts.proveedores')

@section('content')
    <!-- <div class="cabecera-contenido"> -->
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
                <p>FOLIO DEL PADRÓN DE PROVEEDORES: <strong>{{ Auth::guard('proveedor')->user()->folio_padron }}</strong></p>
                <p>RFC: <strong>{{ Auth::guard('proveedor')->user()->rfc }}</strong></p>
                <p>NOMBRE: <strong>{{ strtoupper(Auth::guard('proveedor')->user()->nombre_legal) . ' ' . strtoupper(Auth::guard('proveedor')->user()->primer_apellido_legal) . ' ' . strtoupper(Auth::guard('proveedor')->user()->segundo_apellido_legal) }}</strong></p>
                <p>PERSONA: <strong>{{ strtoupper(Auth::guard('proveedor')->user()->persona) }}</strong></p>
                <p>NACIONALIDAD: <strong>{{ strtoupper(Auth::guard('proveedor')->user()->nacionalidad) }}</strong></p>
                <p>MIPYME: <strong>{{ strtoupper(Auth::guard('proveedor')->user()->mipyme) }}</strong></p>
                <p>TIPO DE PYME: <strong>{{ strtoupper(Auth::guard('proveedor')->user()->tipo_pyme) }}</strong></p>
            </div>
            <div class="footer-formulario">
                <div class="vigente">Constancia vigente</div>
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
                                <input class="codigo_postal" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->codigo_postal }}" />
                                <label for="codigo_postal">Código postal</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="colonia" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->colonia }}" />
                                <label for="colonia">Colonia</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="municipio" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->alcaldia }}" />
                                <label for="municipio">Alcaldía o Municipio</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="entidad" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->entidad_federativa }}" />
                                <label for="entidad">Entidad federativa</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="pais" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->pais }}" />
                                <label for="pais">País</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="tipo_vialidad" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->tipo_vialidad }}" />
                                <label for="tipo_vialidad">Tipo vialidad</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="vialidad" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->vialidad }}" />
                                <label for="vialidad">Vialidad</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="num_ext" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->numero_exterior }}" />
                                <label for="num_ext">Número exterior</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="num_int" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->numero_interior }}" />
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
                                <input class="tel_fijo" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->telefono_legal }}" />
                                <label for="tel_fijo">Número teléfono fijo</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="tel_ext" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->extension_legal }}" />
                                <label for="tel_ext">Extensión</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="tel_celular" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->celular_legal }}" />
                                <label for="tel_celular">Número celular</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="email" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->correo_legal }}" />
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
                                <input class="name" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->nombre_legal }}" />
                                <label for="name" required="required">Nombre(s)</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="fname" type="text" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->primer_apellido_legal }}" />
                                <label for="fname" required="required">Primer apellido</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input class="lname" type="text" required="required" autocomplete="off" disabled value="{{ Auth::guard('proveedor')->user()->segundo_apellido_legal }}" />
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
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->acta_identidad }}" />
                                <label>Número de acta constitutiva</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="@if (Auth::guard('proveedor')->user()->fecha_constitucion_identidad) {{ Auth::guard('proveedor')->user()->fecha_constitucion_identidad->format('d/m/Y') }} @endif" />
                                <label>Fecha de constitución</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->titular_identidad }}" />
                                <label>Titular de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->num_notaria_identidad }}" />
                                <label>Número de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->entidad_identidad }}" />
                                <label>Entidad federativa de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->num_reg_identidad }}" />
                                <label>No. del registro público</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="@if (Auth::guard('proveedor')->user()->fecha_reg_identidad) {{ Auth::guard('proveedor')->user()->fecha_reg_identidad->format('d/m/Y') }} @endif" />
                                <label>Fecha del registro público</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->tiene_representante ? 'Si' : 'No' }}" />
                                <label class="text-truncate">Acreditación como Representante</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->num_instrumento_representante }}" />
                                <label>No. del instrumento jurídico</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->titular_representante }}" />
                                <label>Titular de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->num_notaria_representante }}" />
                                <label>Número de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->entidad_representante }}" />
                                <label>Entidad federativa de la notaría</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="{{ Auth::guard('proveedor')->user()->num_reg_representante }}" />
                                <label>No. del registro público</label>
                            </div>
                        </div>
                        <div class="wrap">
                            <div>
                                <input type="text" disabled value="@if (Auth::guard('proveedor')->user()->fecha_reg_representante) {{ Auth::guard('proveedor')->user()->fecha_reg_representante->format('d/m/Y') }} @endif" />
                                <label>Fecha del registro público</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="caja-formulario">
            <div class="cabecera-formulario">
                <h3 id="me">Datos de Contacto</h3>
            </div>
            <div class="nota">
                <p>Se sugiere que el o los datos de contacto que comparta pertenezca al área comercial, con niveles jerárquicos diferentes.</p>
                {{-- <p>*El llenado de los tres niveles de datos de contacto son obligatorios.</p> --}}
                <p>Los campos marcados con asterisco (*) son obligatorios.</p>
            </div>

            <div class="formulario-contactos">

                <form id="frm_m_escalamiento">
                    @csrf
                    <input type="hidden" id="celda" value="1">
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
                                    <input class="name text-uppercase" type="text" required="required" name="nombre_tres" id="nombre_3" autocomplete="off" value="@if (old('nombre_tres') != null){{ old('nombre_tres') }}@else{{ Auth::guard('proveedor')->user()->nombre_tres }}@endif" title="Proporciona un nombre(s)"/>
                                    <label for="nombre_tres">Nombre(s)<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_nombre_3">
                                    @if ($errors->first('nombre_tres'))
                                        <p class="text-danger">{{ $errors->first('nombre_tres') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="fname text-uppercase" type="text" required="required" name="primer_apellido_tres" id="primer_apellido_3" autocomplete="off" value="@if (old('segundo_apellido_tres') != null){{ old('primer_apellido_tres') }}@else{{ Auth::guard('proveedor')->user()->primer_apellido_tres }}@endif" title="Proporciona el primer apellido"/>
                                    <label for="primer_apellido_tres">Primer apellido<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_primer_apellido_3">
                                    @if ($errors->first('primer_apellido_tres'))
                                        <p class="text-danger">{{ $errors->first('primer_apellido_tres') }}</p>
                                    @endif
                                </div>
                            </div>                            
                            <div class="wrap">
                                <div>
                                    <input class="lname text-uppercase" type="text" required="required" name="segundo_apellido_tres" id="segundo_apellido_3" autocomplete="off" value="@if (old('segundo_apellido_tres') != null){{ old('segundo_apellido_tres') }}@else{{ Auth::guard('proveedor')->user()->segundo_apellido_tres }}@endif" title="Proporciona el segundo apellido"/>
                                    <label for="segundo_apellido_tres">Segundo apellido</label>
                                </div>
                                <div id="div_alerta_segundo_apellido_3">
                                    @if ($errors->first('segundo_apellido_tres'))
                                        <p class="text-danger">{{ $errors->first('segundo_apellido_tres') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="cargo text-uppercase" type="text" required="required" name="cargo_tres" id="cargo_3" autocomplete="off" value="@if (old('cargo_tres') != null){{ old('cargo_tres') }}@else{{ Auth::guard('proveedor')->user()->cargo_tres }}@endif" title="Proporciona el cargo"/>
                                    <label for="cargo_tres">Cargo<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_cargo_3">
                                    @if ($errors->first('cargo_tres'))
                                        <p class="text-danger">{{ $errors->first('cargo_tres') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row first-row">
                            <div class="wrap">
                                <div>
                                    <input class="num_oficina" type="text" required="required" name="telefono_3" id="telefono_3" autocomplete="off" value="@if (old('telefono_3') != null){{ old('telefono_3') }}@else{{ Auth::guard('proveedor')->user()->telefono_tres }}@endif" title="Proporciona un número telefonico." />
                                    <label for="telefono_3">Número oficina</label>
                                </div>
                                <div id="div_alerta_telefono_3">
                                    @if ($errors->first('telefono_3'))
                                        <p class="text-danger">{{ $errors->first('telefono_3') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="extension" type="text" required="required" name="extension_3" id="extension_3" autocomplete="off" value="@if (old('extension_3') != null){{ old('extension_3') }}@else{{ Auth::guard('proveedor')->user()->extension_tres }}@endif" title="Proporciona una extensión telefonica"/>
                                    <label for="extension_3">Extensión</label>
                                </div>
                                <div id="div_alerta_extension_3">
                                    @if ($errors->first('extension_3'))
                                        <p class="text-danger">{{ $errors->first('extension_3') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">                               
                                <div>
                                    <input class="num_celular" type="text" required="required" name="celular_3" id="celular_3" autocomplete="off" value="@if (old('celular_3') != null){{ old('celular_3') }}@else{{ Auth::guard('proveedor')->user()->celular_tres }}@endif" title="Proporciona un número de celular." />
                                    <label for="celular_3">Número celular<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_celular_3">
                                    @if ($errors->first('celular_3'))
                                        <p class="text-danger">{{ $errors->first('celular_3') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="email text-lowercase" type="text" required="required" name="correo_tres" id="correo_3" autocomplete="off" value="@if (old('correo_tres') != null){{ old('correo_tres') }}@else{{ Auth::guard('proveedor')->user()->correo_tres }}@endif" title="Proporciona un correo electrónico válido"/>
                                    <label for="correo_tres">Correo electrónico<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_correo_3">
                                    @if ($errors->first('correo_tres'))
                                        <p class="text-danger">{{ $errors->first('correo_tres') }}</p>
                                    @endif
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
                                    <input class="name text-uppercase" type="text" name="nombre_dos" id="nombre_2" required="required" autocomplete="off" value="@if (old('nombre_dos') != null){{ old('nombre_dos') }}@else{{ Auth::guard('proveedor')->user()->nombre_dos }}@endif" />
                                    <label for="nombre_dos">Nombre(s)<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_nombre_2">
                                    @if ($errors->first('nombre_dos'))
                                        <p class="text-danger">{{ $errors->first('nombre_dos') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="fname text-uppercase" type="text" required="required" name="primer_apellido_dos" id="primer_apellido_2" autocomplete="off" value="@if (old('primer_apellido_dos') != null){{ old('primer_apellido_dos') }}@else{{ Auth::guard('proveedor')->user()->primer_apellido_dos }}@endif" />
                                    <label for="primer_apellido_dos">Primer apellido<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_primer_apellido_2">
                                    @if ($errors->first('primer_apellido_dos'))
                                        <p class="text-danger">{{ $errors->first('primer_apellido_dos') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="lname text-uppercase" type="text" required="required" name="segundo_apellido_dos" id="segundo_apellido_2" autocomplete="off" value="@if (old('segundo_apellido_dos') != null){{ old('segundo_apellido_dos') }}@else{{ Auth::guard('proveedor')->user()->segundo_apellido_dos }}@endif" />
                                    <label for="segundo_apellido_dos">Segundo apellido</label>
                                </div>
                                <div id="div_alerta_segundo_apellido_2">
                                    @if ($errors->first('segundo_apellido_dos'))
                                        <p class="text-danger">{{ $errors->first('segundo_apellido_dos') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="cargo text-uppercase" type="text" name="cargo_dos" id="cargo_2" required="required" minlength="3" maxlength="50" autocomplete="off" value="@if (old('cargo_dos') != null){{ old('cargo_dos') }}@else{{ Auth::guard('proveedor')->user()->cargo_dos }}@endif" />
                                    <label for="cargo_dos">Cargo<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_cargo_2">
                                    @if ($errors->first('cargo_dos'))
                                        <p class="text-danger">{{ $errors->first('cargo_dos') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row first-row">
                            <div class="wrap">
                                <div>
                                    <input class="num_oficina" type="text" required="required" name="telefono_2" id="telefono_2" autocomplete="off" value="@if (old('telefono_2') != null){{ old('telefono_2') }}@else{{ Auth::guard('proveedor')->user()->telefono_dos }}@endif"
                                        title="Proporciona un número telefonico." />
                                    <label for="telefono_2">Número oficina</label>
                                </div>
                                <div id="div_alerta_telefono_2">
                                    @if ($errors->first('telefono_2'))
                                        <p class="text-danger">{{ $errors->first('telefono_2') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="extension" type="text" required="required" name="extension_2" id="extension_2" autocomplete="off" value="@if (old('extension_2') != null){{ old('extension_2') }}@else{{ Auth::guard('proveedor')->user()->extension_dos }}@endif" />
                                    <label for="extension_2">Extensión</label>
                                </div>
                                <div id="div_alerta_extension_2">
                                    @if ($errors->first('extension_2'))
                                        <p class="text-danger">{{ $errors->first('extension_2') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="num_celular" type="text" name="celular_2" id="celular_2" required="required" autocomplete="off" value="@if (old('celular_2') != null){{ old('celular_2') }}@else{{ Auth::guard('proveedor')->user()->celular_dos }}@endif" title="Proporciona un número de celular." />
                                    <label for="celular_2">Número celular<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_celular_2">
                                    @if ($errors->first('celular_2'))
                                        <p class="text-danger">{{ $errors->first('celular_2') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="email text-lowercase" type="text" name="correo_dos" id="correo_2" required="required" autocomplete="off" value="@if (old('correo_dos') != null){{ old('correo_dos') }}@else{{ Auth::guard('proveedor')->user()->correo_dos }}@endif" />
                                    <label for="correo_dos">Correo electrónico<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_correo_2">
                                    @if ($errors->first('correo_dos'))
                                        <p class="text-danger">{{ $errors->first('correo_dos') }}</p>
                                    @endif
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
                                    <input class="name text-uppercase" type="text" name="nombre_uno" id="nombre_1" required="required" autocomplete="off" value="@if (old('nombre_uno') != null){{ old('nombre_uno') }}@else{{ Auth::guard('proveedor')->user()->nombre_uno }}@endif" />
                                    <label for="nombre_uno">Nombre(s)<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_nombre_1">
                                    @if ($errors->first('nombre_uno'))
                                        <p class="text-danger">{{ $errors->first('nombre_uno') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="fname text-uppercase" type="text" required="required" name="primer_apellido_uno" id="primer_apellido_1" autocomplete="off" value="@if (old('primer_apellido_uno') != null){{ old('primer_apellido_uno') }}@else{{ Auth::guard('proveedor')->user()->primer_apellido_uno }}@endif"/>
                                    <label for="primer_apellido_uno">Primer apellido<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_primer_apellido_1">
                                    @if ($errors->first('primer_apellido_uno'))
                                        <p class="text-danger">{{ $errors->first('primer_apellido_uno') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="lname text-uppercase" type="text" required="required" name="segundo_apellido_uno" id="segundo_apellido_1" autocomplete="off" value="@if (old('segundo_apellido_uno') != null){{ old('segundo_apellido_uno') }}@else{{ Auth::guard('proveedor')->user()->segundo_apellido_uno }}@endif" />
                                    <label for="segundo_apellido_uno" required="required">Segundo apellido</label>
                                </div>
                                <div id="div_alerta_segundo_apellido_1">
                                    @if ($errors->first('segundo_apellido_uno'))
                                        <p class="text-danger">{{ $errors->first('segundo_apellido_uno') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="cargo text-uppercase" type="text" name="cargo_uno" id="cargo_1" required="required" autocomplete="off" value="@if (old('cargo_uno') != null){{ old('cargo_uno') }}@else{{ Auth::guard('proveedor')->user()->cargo_uno }}@endif" />
                                    <label for="cargo_uno" required="required">Cargo<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_cargo_1">
                                    @if ($errors->first('cargo_uno'))
                                        <p class="text-danger">{{ $errors->first('cargo_uno') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row first-row">
                            <div class="wrap">
                                <div>
                                    <input class="num_oficina" type="text" required="required" name="telefono_1" id="telefono_1" autocomplete="off" value="@if (old('telefono_1') != null){{ old('telefono_1') }}@else{{ Auth::guard('proveedor')->user()->telefono_uno }}@endif" title="Proporciona un número telefonico." />
                                    <label for="telefono_1">Número oficina</label>
                                </div>
                                <div id="div_alerta_telefono_1">
                                    @if ($errors->first('telefono_1'))
                                        <p class="text-danger">{{ $errors->first('telefono_1') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="extension" type="text" required="required" name="extension_1" id="extension_1" autocomplete="off" value="@if (old('extension_1') != null){{ old('extension_1') }}@else{{ Auth::guard('proveedor')->user()->extension_uno }}@endif" />
                                    <label for="extension_1">Extensión</label>
                                </div>
                                <div id="div_alerta_extension_1">
                                    @if ($errors->first('extension_1'))
                                        <p class="text-danger">{{ $errors->first('extension_1') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="num_celular" type="text" name="celular_1" id="celular_1" required="required" autocomplete="off" value="@if (old('celular_1') != null){{ old('celular_1') }}@else{{ Auth::guard('proveedor')->user()->celular_uno }}@endif" title="Proporciona un número de celular." />
                                    <label for="celular_1">Número celular<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_celular_1">
                                    @if ($errors->first('celular_1'))
                                        <p class="text-danger">{{ $errors->first('celular_1') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="wrap">
                                <div>
                                    <input class="email text-lowercase" type="text" name="correo_uno" id="correo_1" required="required" autocomplete="off" value="@if (old('correo_uno') != null){{ old('correo_uno') }}@else{{ Auth::guard('proveedor')->user()->correo_uno }}@endif" />
                                    <label for="correo_uno">Correo electrónico<span class="asterisco_obligatorio">*</span></label>
                                </div>
                                <div id="div_alerta_correo_1">
                                    @if ($errors->first('correo_uno'))
                                        <p class="text-danger">{{ $errors->first('correo_uno') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="button-dorado derecha" type="submit" id="btnOcular">Actualizar y continuar</button>
                </form>
            </div>
        </div>
        <!--  -->
        <div class="footer-formulario-pagina">

            <form action="{{ route('proveedor.aip') }}">
                @if (session('success'))
                    <div class="alert alert-danger">
                        {!! session('success') !!}
                    </div>
                @endif
                <div class="row justify-content-end">
                    <div class="col-auto">
                        <button class="btn button-dorado " type="submit"><i class="fa-solid fa-arrow-left gold"></i>
                            Regresar</button>
                    </div>
                    <div class="col-auto">
                        <button class="button-dorado" type="button" id="btnGuardarME">Actualizar y continuar</button>
                    </div>
                </div>
            </form>


        </div>
    </div>

    <a href="#top" class="scroll" id="toTop" style="display: block;"> <span id="toTopHover"
        style="opacity: 1;">
    </span></a>
@endsection
@section('js')
    @routes('proveedor')
    <script src="{{ asset('asset/js/matriz_escalamiento.js') }}" type="text/javascript"></script>
@endsection
