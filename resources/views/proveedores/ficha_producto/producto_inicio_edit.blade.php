@extends('layouts.proveedores_ficha_productos')

@section('content')
    <div class="row d-flex align-items-center justify-content-center mt-4">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-transp" id="btn_hacia_inicio">
            <div class="col-1 text-center">
                <div class="row text-center">
                    <div class="text-center">
                        <input type="hidden" id="e_inicio" value="{{ $producto[0]->estatus_inicio }}">
                        <p id="flecha_inicio"
                            class="indicador-count-card-6 fa-solid fa-check text-center @if ($producto[0]->estatus_inicio) bac-green @endif">
                        </p>
                    </div>
                </div>
            </div>
        </button>

        <div class="col-1 d-none d-sm-none d-md-block cont-linea">
            <hr class="linea-1">
        </div>

        <button type="button" class="btn btn-transp" id="btn_hacia_producto">
            <div class="col-1 text-center">
                <div class="row text-center">
                    <div class="text-center">
                        <input type="hidden" id="e_producto" value="{{ $producto[0]->estatus_producto }}">
                        <p id="flecha_producto"
                            class="indicador-count-card-6 fa-solid fa-check text-center @if ($producto[0]->estatus_producto) bac-green @endif">
                        </p>
                    </div>
                </div>
            </div>
        </button>

        <div class="col-1 d-none d-sm-none d-md-block cont-linea">
            <hr class="linea-1">
        </div>

        <button type="button" class="btn btn-transp" id="btn_hacia_ficha_tec">
            <div class="col-1 text-center ">
                <div class="row text-center">
                    <div class="text-center">
                        <input type="hidden" id="e_ficha_tec" value="{{ $producto[0]->estatus_ficha_tec }}">
                        <p id="flecha_ficha_tec"
                            class="indicador-count-card-6 fa-solid fa-check text-center @if ($producto[0]->estatus_ficha_tec) bac-green @endif">
                        </p>
                    </div>
                </div>
            </div>
        </button>

        <div class="col-1  d-none d-sm-none d-md-block cont-linea">
            <hr class="linea-1">
        </div>

        <button type="button" class="btn btn-transp" id="btn_hacia_caracteristicas">
            <div class="col-1  text-center">
                <div class="row text-center">
                    <div class="text-center">
                        <input type="hidden" id="e_caracteristicas" value="{{ $producto[0]->estatus_caracteristicas }}">
                        <p id="flecha_caracteristicas"
                            class="indicador-count-card-6 fa-solid fa-check text-center @if ($producto[0]->estatus_caracteristicas) bac-green @endif">
                        </p>
                    </div>
                </div>
            </div>
        </button>
        <div class="col-1 d-none d-sm-none d-md-block cont-linea">
            <hr class="linea-1">
        </div>

        <button type="button" class="btn btn-transp" id="btn_hacia_entrega">
            <div class="col-1 text-center ">
                <div class="row text-center">
                    <div class="text-center">
                        <input type="hidden" id="e_entrega" value="{{ $producto[0]->estatus_entrega }}">
                        <p id="flecha_entrega"
                            class="indicador-count-card-6 fa-solid fa-check text-center @if ($producto[0]->estatus_entrega) bac-green @endif">
                        </p>
                    </div>
                </div>
            </div>
        </button>
        <div class="col-1 d-none d-sm-none d-md-block cont-linea">
            <hr class="linea-1">
        </div>

        <button type="button" class="btn btn-transp" id="btn_hacia_precio">
            <div class="col-1  text-center ">
                <div class="row text-center">
                    <div class="text-center">
                        <input type="hidden" id="e_precio" value="{{ $producto[0]->estatus_precio }}">
                        <p id="flecha_precio"
                            class="indicador-count-card-6 fa-solid fa-check text-center @if ($producto[0]->estatus_precio) bac-green @endif">
                        </p>
                    </div>
                </div>
            </div>
        </button>

        @if ($producto[0]->validacion_tecnica)
            <div class="col-1 d-none d-sm-none d-md-block cont-linea">
                <hr class="linea-1">
            </div>

            <button type="button" class="btn btn-transp" id="btn_hacia_validacion_tec">
                <div class="col-1  text-center ">
                    <div class="row text-center">
                        <div class="text-center">
                            <input type="hidden" id="e_validacion_tec" value="{{ $producto[0]->estatus_validacion_tec }}">
                            <p id="flecha_validacion_tec"
                                class="indicador-count-card-6 fa-solid fa-check text-center @if ($producto[0]->estatus_validacion_tec) bac-green @endif">
                            </p>
                        </div>
                    </div>
                </div>
            </button>
        @endif
    </div>

    <div class="row mt-3">
        <div class="nav flex-column nav-pills border" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link bg-light col-auto border @if ($producto[0]->estatus_inicio) nav-verde @endif"
                id="v_pills_inicio_tab" data-toggle="pill" href="#v_pills_inicio" role="tab"
                aria-controls="v_pills_inicio" aria-selected="false">
                <p class="text-1 col-auto">
                    <i class="fa fa-arrow-right gris"></i>
                    <span>Inicio</span>
                </p>
            </a>
            <a class="nav-link bg-light col-auto border @if ($producto[0]->estatus_producto) nav-verde @endif"
                id="v_pills_producto_tab" data-toggle="pill" href="#v_pills_producto" role="tab"
                aria-controls="v_pills_producto" aria-selected="true">
                <p class="text-1 col-auto">
                    <i class="fa fa-tag gris"></i>
                    <span>Producto</span>
                </p>
            </a>
            <a class="nav-link bg-light col-auto border @if ($producto[0]->estatus_ficha_tec) nav-verde @endif"
                id="v_pills_ficha_tec_tab" data-toggle="pill" href="#v_pills_ficha_tecnica" role="tab"
                aria-controls="v_pills_ficha_tecnica" aria-selected="false">
                <p class="text-1 col-auto">
                    <i class="fa-solid fa-file gris"></i>
                    <span>Ficha técnica</span>
                </p>
            </a>
            <a class="nav-link bg-light col-auto border @if ($producto[0]->estatus_caracteristicas) nav-verde @endif"
                id="v_pills_caracteristicas_tab" data-toggle="pill" href="#v_pills_caracteristicas" role="tab"
                aria-controls="v_pills_caracteristicas" aria-selected="false">
                <p class="text-1 col-auto">
                    <i class="fa-solid fa-list gris"></i>
                    <span>Características</span>
                </p>
            </a>
            <a class="nav-link bg-light col-auto border @if ($producto[0]->estatus_entrega) nav-verde @endif"
                id="v_pills_entrega_tab" data-toggle="pill" href="#v_pills_entrega" role="tab"
                aria-controls="v_pills_entrega" aria-selected="false">
                <p class="text-1 col-auto">
                    <i class="fa-solid fa-truck gris"></i>
                    <span>Entrega</span>
                </p>
            </a>
            <a class="nav-link bg-light col-auto border @if ($producto[0]->estatus_precio) nav-verde @endif"
                id="v_pills_precio_tab" data-toggle="pill" href="#v_pills_precio" role="tab"
                aria-controls="v_pills_precio" aria-selected="false">
                <p class="text-1 col-auto">
                    <i class="fa-solid fa-dollar-sign gris"></i>
                    <span>Precio</span>
                </p>
            </a>
            @if ($producto[0]->validacion_tecnica)
                <a class="nav-link bg-light col-auto border @if ($producto[0]->estatus_validacion_tec) nav-verde @endif"
                    id="v_pills_validacion_tec_tab" data-toggle="pill" href="#v_pills_validacion_tec" role="tab"
                    aria-controls="v_pills_validacion_tec" aria-selected="false">
                    <p class="text-1 col-auto">
                        <i class="fa-solid fa-flask gris"></i>
                        <span>Valid. técnica</span>
                    </p>
                </a>
            @endif
        </div>

        <div class="tab-content ml-3 col-8" id="v-pills-tabContent">
            <!--  Inicio -->
            <div class="tab-pane fade col-md-8 col-12 m-3" id="v_pills_inicio" role="tabpanel"
                aria-labelledby="v_pills_inicio_tab">
                <!-- -----Alerta 1------- -->
                <div class="alert alert-warning alert-dismissible fade show col-lg-8 col-md-8 col-12 mt-4 ml-5"
                    role="alert">
                    <div class="d-flex align-items-center">
                        <div class="bg-amarillo mr-3"></div>
                        <strong class="text-aler-amarillo">Tienes hasta el
                            {{ Carbon\Carbon::parse($producto[0]->fecha_carga)->format('d-m-Y') }}
                            para completar tu ficha</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <!-- -----Alerta 1------- -->

                <h4 class="text-green-2">Inicio</h4>
                <div class="separator mb-3 col-md-8 col-12"></div>

                <form>
                    <div class="row">
                        <div class="col-md-2 col-12">
                            <p class="text-2">NOMBRE PRODUCTO</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="nombre_producto">
                                <strong>{{ strtoupper($producto[0]->nombre_corto) }}</strong>
                            </p>
                            <input type="hidden" id="pfp_id" name="pfp_id" value="{{ $producto[0]->id_e }}">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-2 col-12">
                            <p class="text-2">ID PRODUCTO</p>
                        </div>
                        <div class="col-md-9 col-12">
                            <p class="text-2" id="id_producto">
                                <strong>{{ strtoupper($producto[0]->id_producto) }}</strong>
                            </p>
                        </div>
                    </div>

                    <!-- Contrato Marco -->
                    <p class="text-green-p mt-4">Contrato Marco:</p>
                    <div class="row mt-3">
                        <div class="col-md-2 col-12">
                            <p class="text-2">NÚMERO</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_numero">
                                <strong>{{ strtoupper($producto[0]->numero_cm) }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="separator col-8 mt-1"></div>

                    <div class="row mt-2">
                        <div class="col-md-2 col-12">
                            <p class="text-2">NOMBRE</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_nombre">
                                <strong>{{ strtoupper($producto[0]->nombre_cm) }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="separator col-8 mt-1"></div>

                    <div class="row mt-1">
                        <div class="col-md-2 col-12">
                            <p class="text-2">NÚMERO FICHA</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_numero_ficha">{{ strtoupper($producto[0]->numero_ficha) }}</p>
                        </div>
                    </div>
                    <div class="separator col-8 mt-1"></div>

                    <div class="row mt-1">
                        <div class="col-md-2 col-12">
                            <p class="text-2">VERSIÓN</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_version">{{ $producto[0]->version }}</p>
                            {{-- <input type="hidden" id="inicio_version" name="inicio_version" value="{{ $producto[0]->version }}"> --}}
                        </div>
                    </div>
                    <div class="separator col-8 mt-1"></div>
                    <!-- Contrato Marco -->

                    <!-- Categoría: -->
                    <p class="text-green-p mt-4">Categoría:</p>
                    <div class="row mt-3">
                        <div class="col-md-2 col-12">
                            <p class="text-2">CAPÍTULO</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_capitulo">{{ strtoupper($producto[0]->capitulo) }}</p>
                        </div>
                    </div>
                    <div class="separator col-8 mt-1"></div>

                    <div class="row mt-2">
                        <div class="col-md-2 col-12">
                            <p class="text-2">PARTIDA</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_partida">{{ strtoupper($producto[0]->partida) }}</p>
                        </div>
                    </div>
                    <div class="separator col-8 mt-1"></div>

                    <div class="row mt-1">
                        <div class="col-md-2 col-12">
                            <p class="text-2">CLAVE CABMS</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_clave_cabms">{{ strtoupper($producto[0]->cabms) }} -
                                {{ strtoupper($producto[0]->descripcion) }}</p>
                        </div>
                    </div>
                    <div class="separator col-8 mt-1"></div>
                    <!-- Categoría: -->

                    <div class="col-8" style="padding: 0%;">
                        <p class="text-green-p mt-4">Características:</p>
                        <div class="form-group">
                            <textarea class="form-control" id="inicio_caracteristicas" name="inicio_caracteristicas" rows="3" disabled>{{ strtoupper($producto[0]->caracteristicas) }}</textarea>
                        </div>
                    </div>
                    <!-- Características:-->
                </form>

                <!-- Información requerida: -->
                <p class="text-green-p mt-4">Información requerida:</p>

                <div class="row mt-3">
                    <div class="col-md-7 col-12">
                        <p class="text-2" id="inicio_fotografias">
                            <strong class="mr-2">FOTOGRAFÍAS.</strong>Hasta 6 en formato jpg o png y menos de
                            1MB cada una.
                        </p>
                    </div>
                </div>
                <div class="separator col-8 mt-1"></div>

                <div class="row mt-2">
                    <div class="col-md-7 col-12 d-flex">
                        <p class="text-2" id="inicio_ficha_tecnica">
                            <strong class="mr-2">FICHA TÉCNICA.</strong>Formato .doc con Información sobre tu
                            producto.
                        </p>
                        <a class="btn btn-cdmx" target="_blank"
                            href="{{ route('proveedor_fp.ver_doc', [$producto[0]->archivo_ficha_tecnica, 3]) }}">
                            <p class="text-gold-4 ml-2">Descargar aquí.</p>
                        </a>
                    </div>
                </div>
                <div class="separator col-8 mt-1"></div>

                <div class="row mt-2">
                    <div class="col-md-9 col-12 d-flex">
                        <p class="text-2" id="inicio_precio">
                            <strong class="mr-2">PRECIO.</strong>Este pasará por un proceso de validación.
                        </p>
                        <a target="_blank" href="{{ asset('files/precio-maximo.pdf') }}">
                            <p class="text-gold-4 ml-2">Más información.</p>
                        </a>
                    </div>
                </div>
                <div class="separator col-8 mt-1"></div>

                <div class="row mt-2">
                    <div class="col-md-9 col-12 d-flex">
                        <p class="text-2" id="inicio_resultado_pruebas">
                            <strong class="mr-2">RESULTADOS DE PRUEBAS.</strong>Si tu producto requiere
                            validación técnica.
                        </p>
                        <a target="_blank" href="{{ asset('files/validacion-tecnica.pdf') }}">
                            <p class="text-gold-4 ml-2">Más información.</p>
                        </a>
                    </div>
                </div>
                <div class="separator col-8 mt-1"></div>

                <div class="row d-flex justify-content-end mt-4  col-md-9 col-12">
                    <div class="separator mb-3 mt-2 col-md-12 col-12"></div>
                    <div class="botones">
                        <button class="btn m-2 boton-2" disabled>Empezar</button>
                    </div>
                </div>
                <!-- Información requerida: -->
            </div>
            <!--  Inicio -->

            <!-- Producto -->
            <div class="tab-pane fade col-md-8 col-12 m-3" id="v_pills_producto" role="tabpanel"
                aria-labelledby="v_pills_producto_tab">
                <h4 class="text-green-2">Producto</h4>
                <div class="separator mb-3 col-10"></div>

                <p class="text-green-p mt-4">1. Describe tu producto</p>
                <p class="text-2 ml-2">Información esencial ya que aparecerá en búsquedas y en la tienda
                    virtual.</p>
                <div class="separator mb-3 mt-2 col-md-10 col-12"></div>
                <div class="col-md-10 col-12">
                    <form id="frm_producto" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="p_nombre_producto" class="text-1">Nombre de tu producto</label>
                            <input type="text" class="form-control" id="p_nombre_producto" name="p_nombre_producto"
                                placeholder="Proporciona el nombre de tu producto"
                                value="{{ strtoupper($producto[0]->nombre_producto) }}" required maxlength="200">
                        </div>
                        <p class="text-2 font-italic">
                            <i class="fa-solid fa-lightbulb amarillo"></i>
                            Este es el título de la publicación. Incluye el nombre de
                            tu producto y una característica que lo distinga.
                        </p>

                        <div class="form-group mt-3">
                            <label for="p_descripcion_producto" class="text-1">Describe tu producto</label>
                            <input type="text" class="form-control" id="p_descripcion_producto"
                                name="p_descripcion_producto" placeholder="Proporciona la descripción de tu producto"
                                value="{{ strtoupper($producto[0]->descripcion_producto) }}" required maxlength="300">
                        </div>
                        <p class="text-2 font-italic">
                            <i class="fa-solid fa-lightbulb amarillo"></i>
                            Cuentanos más sobre tu producto, ¿Qué lo hace diferente de
                            otros?, ¿Qué beneficios ofrece? ¿Cuáles son sus características principales?
                        </p>

                        <p class="text-green-p mt-4">2. Fotografías</p>
                        <p class="text-2 ml-2">Los archivos deben de ser menores a 1MB, en formato png o jpg. Se recomienda
                            que el tamaño de tus fotos sean de 1200 x 1200 pixeles.</p>
                        <div class="separator mb-3 mt-2 col-md-12 col-12"></div>

                        <div class="d-flex col-md-12 col-12">
                            <div class="col-4 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_foto_uno">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div id="foto_uno_lugar">
                                    <div class="foto_click image-upload card bg-white" name="foto_uno"
                                        style="width: 5rem;">
                                        <img class="card-img-top" id="foto_uno_imagen"
                                            src="@if ($producto[0]->foto_uno != null) {{ asset('storage/img-producto-pfp/' . $producto[0]->foto_uno) }} @else {{ asset('asset/img/bac_imag_fondo.svg') }} @endif"
                                            alt="Click aquí para subir tu foto" title="Click aquí para subir tu foto">
                                    </div>
                                </div>
                                <input type="file" class="input_foto" id="foto_uno" name="foto_uno"
                                    style="display:none" accept="image/png, image/jpeg, image/jpg" required multiple />
                            </div>
                            <div class="col-4 ml-2 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_foto_dos">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div id="foto_dos_lugar">
                                    <div class="foto_click image-upload card bg-white" name="foto_dos"
                                        style="width: 5rem;">
                                        <img class="card-img-top" id="foto_dos_imagen"
                                            src="@if ($producto[0]->foto_dos != null) {{ asset('storage/img-producto-pfp/' . $producto[0]->foto_dos) }} @else {{ asset('asset/img/bac_imag_fondo.svg') }} @endif"
                                            style="width:100%" alt="Click aquí para subir tu foto"
                                            title="Click aquí para subir tu foto">
                                    </div>
                                </div>
                                <input type="file" class="input_foto" id="foto_dos" name="foto_dos"
                                    style="display:none" accept="image/png, image/jpeg, image/jpg" required multiple />
                            </div>
                            <div class="col-4 ml-2 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_foto_tres">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div id="foto_tres_lugar">
                                    <div class="foto_click image-upload card bg-white" name="foto_tres"
                                        style="width: 5rem;">
                                        <img class="card-img-top" id="foto_tres_imagen"
                                            src="@if ($producto[0]->foto_tres != null) {{ asset('storage/img-producto-pfp/' . $producto[0]->foto_tres) }} @else {{ asset('asset/img/bac_imag_fondo.svg') }} @endif"
                                            style="width:100%" alt="Click aquí para subir tu foto"
                                            title="Click aquí para subir tu foto">
                                    </div>
                                </div>
                                <input type="file" class="input_foto" id="foto_tres" name="foto_tres"
                                    style="display:none" accept="image/png, image/jpeg, image/jpg" required multiple />
                            </div>
                            <div class="col-4 ml-2 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_foto_cuatro">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div id="foto_cuatro_lugar">
                                    <div class="foto_click image-upload card bg-white" name="foto_cuatro"
                                        style="width: 5rem;">
                                        <img class="card-img-top" id="foto_cuatro_imagen"
                                            src="@if ($producto[0]->foto_cuatro != null) {{ asset('storage/img-producto-pfp/' . $producto[0]->foto_cuatro) }} @else {{ asset('asset/img/bac_imag_fondo.svg') }} @endif"
                                            style="width:100%" alt="Click aquí para subir tu foto"
                                            title="Click aquí para subir tu foto">
                                    </div>
                                </div>
                                <input type="file" class="input_foto" id="foto_cuatro" name="foto_cuatro"
                                    style="display:none" accept="image/png, image/jpeg, image/jpg" required multiple />
                            </div>
                            <div class="col-4 ml-2 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_foto_cinco">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div id="foto_cinco_lugar">
                                    <div class="foto_click image-upload card bg-white" name="foto_cinco"
                                        style="width: 5rem;">
                                        <img class="card-img-top" id="foto_cinco_imagen"
                                            src="@if ($producto[0]->foto_cinco != null) {{ asset('storage/img-producto-pfp/' . $producto[0]->foto_cinco) }} @else {{ asset('asset/img/bac_imag_fondo.svg') }} @endif"
                                            style="width:100%" alt="Click aquí para subir tu foto"
                                            title="Click aquí para subir tu foto">
                                    </div>
                                </div>
                                <input type="file" class="input_foto" id="foto_cinco" name="foto_cinco"
                                    style="display:none" accept="image/png, image/jpeg, image/jpg" required multiple />
                            </div>
                            <div class="col-4 ml-2 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_foto_seis">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div id="foto_seis_lugar">
                                    <div class="foto_click image-upload card bg-white" name="foto_seis"
                                        style="width: 5rem;">
                                        <img class="card-img-top" id="foto_seis_imagen"
                                            src="@if ($producto[0]->foto_seis != null) {{ asset('storage/img-producto-pfp/' . $producto[0]->foto_seis) }} @else {{ asset('asset/img/bac_imag_fondo.svg') }} @endif"
                                            style="width:100%" alt="Click aquí para subir tu foto"
                                            title="Click aquí para subir tu foto">
                                    </div>
                                </div>
                                <input type="file" class="input_foto" id="foto_seis" name="foto_seis"
                                    style="display:none" accept="image/png, image/jpeg, image/jpg" required multiple />
                            </div>
                        </div>

                        <p class="text-2 font-italic mt-3">
                            <i class="fa-solid fa-lightbulb amarillo"></i>
                            No olvides agregar diferentes vistas de tu producto: frente, lateral, superior, inferior,
                            interior o detalles.
                            Esto aumenta la probabilidad de compra.
                        </p>
                    </form>
                </div>

                <div class="row d-flex justify-content-end mt-4 col-md-11 col-12">
                    <div class="separator mb-3 mt-2 col-md-12 col-12"></div>
                    <div class="botones">
                        <a class="btn boton-7 mt-2" href="javascript:void(0)" id="btn_atras_inicio" role="button">
                            <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                    </div>
                    <div class="botones ml-3">
                        <a class="btn m-2 boton-2" href="javascript:void(0)" role="button"
                            id="btn_guardar_producto">Guardar</a>
                    </div>
                </div>
            </div>
            <!-- Producto -->

            <!-- ficha técnica -->
            <div class="tab-pane fade col-md-8 col-12 m-3" id="v_pills_ficha_tecnica" role="tabpanel"
                aria-labelledby="v_pills_ficha_tecnica_tab">
                <h4 class="text-green-2">Ficha técnica</h1>
                    <div class="separator mb-3"></div>

                    <form id="frm_ficha_tec" method="POST" enctype="multipart/form-data">
                        <p class="text-green-p mt-4">1. Ficha técnica de tu producto</p>
                        <p class="text-2 ml-2">Descarga el documento en .doc, llénalo y adjuntalo en formato PDF de
                            hasta 3MB</p>
                        <div class="separator col-12 mb-3 mt-2"></div>

                        <div class="text-gold  mt-4">
                            <a class="text-gold" target="_blank"
                                href=" {{ route('proveedor_fp.ver_doc', [$producto[0]->archivo_ficha_tecnica, 3]) }} ">
                                <i class="fa-solid fa-download text-gold"></i>
                                Descarga la Ficha técnica
                            </a>
                        </div>
                        <div class="row d-flex mt-3">
                            <div class="input-group col-md-12 col-12 mb-3">
                                <input type="file" class="form-control-file mt-1" id="doc_ficha_tecnica"
                                    name="doc_ficha_tecnica" accept=".pdf" required="" multiple="">
                            </div>
                            <div class="separator col-12 mb-3 mt-2"></div>
                        </div>

                        <div id="pintar_ficha_tec">
                            @if ($producto[0]->doc_ficha_tecnica != null)
                                <div class="col-6 d-flex justify-content-start" id="doc_ficha_tecnica_pintada">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_archivo_ficha_tec">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p class="text-1 ml-3">{{ strtoupper($producto[0]->doc_ficha_tecnica) }}</p>
                                </div>
                            @endif
                        </div>
                    </form>

                    <form id="frm_otro_doc" method="POST" enctype="multipart/form-data">
                        <p class="text-green-p mt-4">2. ¿Quieres subir otros documentos</p>
                        <p class="text-2 ml-2">Adjunta aquí documentos adicionales en formato PDF de hasta 3MB</p>
                        <div class="separator col-12 mb-3 mt-2"></div>

                        <div class="row d-flex">
                            <div class="input-group col-md-12 col-12 mb-3">
                                <input type="file" class="form-control-file mt-1" id="el_doc_adicional"
                                    name="el_doc_adicional" accept=".pdf" required="" multiple="">
                            </div>
                            <div class="separator col-12 mb-3 mt-2"></div>
                        </div>

                        <div id="doc_adicional_uno_div">
                            @if ($producto[0]->doc_adicional_uno != null)
                                <div class="col-6 d-flex justify-content-start" id="doc_adicional_uno">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_archivo_doc_adicional_uno">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p class="text-1 ml-3">{{ strtoupper($producto[0]->doc_adicional_uno) }}</p>
                                </div>
                            @endif
                        </div>

                        <div id="doc_adicional_dos_div">
                            @if ($producto[0]->doc_adicional_dos != null)
                                <div class="col-6 d-flex justify-content-start" id="doc_adicional_dos">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_archivo_doc_adicional_dos">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p class="text-1 ml-3">{{ strtoupper($producto[0]->doc_adicional_dos) }}</p>
                                </div>
                            @endif
                        </div>

                        <div id="doc_adicional_tres_div">
                            @if ($producto[0]->doc_adicional_tres != null)
                                <div class="col-6 d-flex justify-content-start" id="doc_adicional_tres">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_archivo_doc_adicional_tres">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p class="text-1 ml-3">{{ strtoupper($producto[0]->doc_adicional_tres) }}</p>
                                </div>
                            @endif
                        </div>
                    </form>

                    <div class="row d-flex justify-content-end mt-4 col-md-12 col-12" style="padding: 0;">
                        <div class="separator mb-3 mt-2"></div>
                        <div class="botones">
                            <a class="btn boton-7 mt-2" href="javascript:void(0)" id="btn_atras_producto"
                                role="button">
                                <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                        </div>
                        <div class="botones ml-3">
                            <a class="btn m-2 boton-2 " href="#" role="button"
                                id="btn_guardar_ficha_tec">Guardar</a>
                        </div>
                    </div>
            </div>
            <!-- ficha técnica -->

            <!-- caracteristícas -->
            <div class="tab-pane fade col-md-8 col-12 m-3" id="v_pills_caracteristicas" role="tabpanel"
                aria-labelledby="v_pills_caracteristicas_tab">
                <h4 class="text-green-2">Características</h4>
                <div class="separator mb-3 col-12"></div>

                <div class="row ml-1">
                    <div class="col-md-12 col-12">
                        <p class="text-green-p mt-4">1. Características físicas</p>
                        <p class="text-2 ml-2">Los compradores necesitan esta información. Ten en cuenta que los campos
                            marcados con asterisco (<b style="color:#FF0000" ;>*</b>) son estrictamente obligatorios.</p>
                        <div class="separator col-12 mb-3 mt-2"></div>
                    </div>
                </div>

                <form method="POST" id="frm_caracteristicas">
                    <div class="row ml-1">
                        <div class="form-group col-12 col-md-6">
                            <label for="marca">Marca<b style="color:#FF0000" ;>*</b></label>
                            <input type="text" class="form-control" id="marca" name="marca"
                                placeholder="Proporciona la marca" required maxlength="100"
                                value="{{ strtoupper($producto[0]->marca) }}">
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="modelo">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo"
                                placeholder="Proporciona el modelo" maxlength="100"
                                value="{{ strtoupper($producto[0]->modelo) }}">
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="form-group col-12 col-md-6">
                            <label for="material">Material<b style="color:#FF0000" ;>*</b></label>
                            <input type="text" class="form-control" id="material" name="material"
                                placeholder="Proporciona el tipo de material" required maxlength="100"
                                value="{{ strtoupper($producto[0]->material) }}">
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="composicion">Composición</label>
                            <input type="text" class="form-control" id="composicion" name="composicion"
                                placeholder="Describe la composición" maxlength="100"
                                value="{{ strtoupper($producto[0]->composicion) }}">
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label for="tamanio">Tamaño<b style="color:#FF0000;">*</b></label>
                            <input type="text" class="form-control" id="tamanio" name="tamanio"
                                placeholder="Inserta el tamaño" required="" maxlength="50"
                                value="{{ strtoupper($producto[0]->tamanio) }}" data-toggle="tooltip"
                                data-placement="left"
                                title="Puede usar alguno de los siguientes ejemplos: chico, mediano, grande, hoja oficio, hoja carta, etc... Si tu producto no cuenta con un tamaño definido, puedes colocar tamaño 'Estándar'.">
                        </div>

                        <div class="col-12 col-md-5 col-lg-3">
                            <input type="hidden" id="los_colores" value="{{ is_array($producto[0]->color) }}">
                            <div class="botones mt-3" data-toggle="modal" data-target="#staticBackdrop">
                                <a class="btn mt-3 boton-2 col-md-10" id="btn_modal_agregar_color"
                                    href="javascript:void(0)" role="button" data-toggle="tooltip" data-placement="top"
                                    title="Da clic aquí para agregar los colores de tu producto.">Color</a>
                                <b style="color:#FF0000;">*</b>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-5">
                            <input type="hidden" id="las_dimensiones"
                                value="{{ is_array($producto[0]->dimensiones) }}">
                            <div class="botones mt-3" data-toggle="modal" data-target="#staticBackdrop">
                                <a id="btn_modal_agregar_dimensiones" href="javascript:void(0)"
                                    title="De clic para agregar dimensiones de su producto" role="button"
                                    class="btn mt-3 boton-2 col-12">Dimensiones</a>
                            </div>
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="col-md-12 col-12">
                            <p class="text-green-p mt-4">2. Otras características</p>
                            <p class="text-2 ml-2">Si tu producto no cuenta con alguna de las solicitadas, deja vacío el
                                campo.
                            </p>
                            <hr>
                        </div>
                    </div>

                    <div class="row ml-1">
                        <div class="form-group col-12 col-md-6">
                            <label for="sku">Código de barras</label>
                            <input type="text" class="form-control" id="sku" name="sku"
                                placeholder="Proporciona el Código de barras" required maxlength="15"
                                value="{{ strtoupper($producto[0]->sku) }}">
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="fabricante">Fabricante</label>
                            <input type="text" class="form-control" id="fabricante" name="fabricante"
                                placeholder="Menciona el fabricante" required maxlength="150"
                                value="{{ strtoupper($producto[0]->fabricante) }}">
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="form-group col-12 col-md-6">
                            <label for="pais_origen">País de origen</label>
                            <input type="text" class="form-control" id="pais_origen" name="pais_origen"
                                placeholder="Menciona el país de origen" required maxlength="150"
                                value="{{ strtoupper($producto[0]->pais_origen) }}">
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="grado_integracion_nacional">Grado de integración nacional</label>
                            <input type="text" class="form-control" id="grado_integracion_nacional"
                                name="grado_integracion_nacional" placeholder="Proporciona el grado..." required
                                maxlength="150" value="{{ strtoupper($producto[0]->grado_integracion_nacional) }}">
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="form-group col-12 col-md-6">
                            <label for="presentacion">Presentación</label>
                            <input type="text" class="form-control" id="presentacion" name="presentacion"
                                placeholder="Menciona la presentación" required maxlength="150"
                                value="{{ strtoupper($producto[0]->presentacion) }}">
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="disenio">Diseño</label>
                            <input type="text" class="form-control" id="disenio" name="disenio"
                                placeholder="Menciona el diseño" required maxlength="150"
                                value="{{ strtoupper($producto[0]->disenio) }}">
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="form-group col-12 col-md-6">
                            <label for="acabado">Acabado</label>
                            <input type="text" class="form-control" id="acabado" name="acabado"
                                placeholder="Menciona el acabado" required maxlength="150"
                                value="{{ strtoupper($producto[0]->acabado) }}">
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="forma">Forma</label>
                            <input type="text" class="form-control" id="forma" name="forma"
                                placeholder="Describe la forma" required maxlength="150"
                                value="{{ strtoupper($producto[0]->forma) }}">
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="form-group col-12 col-md-6">
                            <label for="aspecto">Aspecto</label>
                            <input type="text" class="form-control" id="aspecto" name="aspecto"
                                placeholder="Describe el aspecto" required maxlength="150"
                                value="{{ strtoupper($producto[0]->aspecto) }}">
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="etiqueta">Etiqueta</label>
                            <input type="text" class="form-control" id="etiqueta" name="etiqueta"
                                placeholder="Menciona la etiqueta" required maxlength="150"
                                value="{{ strtoupper($producto[0]->etiqueta) }}">
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="form-group col-12 col-md-6">
                            <label for="envase">Envase</label>
                            <input type="text" class="form-control" id="envase" name="envase"
                                placeholder="Menciona el tipo de envase" required maxlength="150"
                                value="{{ strtoupper($producto[0]->envase) }}">
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="empaque">Empaque</label>
                            <input type="text" class="form-control" id="empaque" name="empaque"
                                placeholder="Menciona el tipo de empaque" required maxlength="150"
                                value="{{ strtoupper($producto[0]->empaque) }}">
                        </div>
                    </div>
                </form>

                <div class="row d-flex justify-content-end mt-4 col-md-12 col-12" style="padding: 0;">
                    <div class="separator mb-3 mt-2"></div>
                    <div class="botones">
                        <a class="btn boton-7 mt-2" href="javascript:void(0)" id="btn_atras_ficha_tec" role="button">
                            <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                    </div>
                    <div class="botones ml-3">
                        <button class="btn m-2 boton-2" role="button" id="btn_guardar_caracteristicas">Guardar</button>
                    </div>
                </div>
            </div>
            <!-- caracteristícas -->

            <!-- Entrega -->
            <div class="tab-pane fade col-md-8 col-12 m-3" id="v_pills_entrega" role="tabpanel"
                aria-labelledby="v_pills_entrega_tab">
                <h4 class="text-green-2">Entrega</h4>
                <div class="separator mb-3 col-12"></div>

                <form id="frm_tiempo_entrega">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <p class="text-green-p mt-4">1. Tiempo de entrega</p>
                            <p class="text-2 ml-2">Indica cuánto tiempo te lleva entregar el producto. Considera que los
                                días
                                son hábiles.</p>
                            <div class="separator col-12 mb-3 mt-2"></div>

                            <div class="col-md-7 col-12 ">
                                <div class="form-row d-flex align-items-end">
                                    <div class="form-group col-6">
                                        <label for="tiempo_de_entrega" class="text-2">
                                            Tiempo de entrega
                                        </label>
                                        <input type="number" min="0" class="form-control col-10 text-right"
                                            id="tiempo_de_entrega" name="tiempo_de_entrega" placeholder="0" required
                                            value="{{ strtoupper($producto[0]->tiempo_entrega) }}">
                                    </div>
                                    <div class="form-group col-6 mt-2">
                                        <select id="dias_entrega" name="dias_entrega" class="form-control mt-4"
                                            style="padding: 0; height: 2rem;">
                                            @php $unidadesDias = [ "Días", "Semanas", "Meses" ]; @endphp
                                            @foreach ($unidadesDias as $key => $item)
                                                <option value="{{ $key }}"
                                                    @if ($producto[0]->temporalidad == $key) selected='selected' @endif>
                                                    {{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-green-p mt-4">2. Documentación incluida en la entrega</p>
                    <p class="text-2 ml-2">Indica qué información entregarás junto con el producto.</p>
                    <div class="separator col-12 mb-3 mt-2"></div>

                    <div class="form-inline mb-2">
                        <div class="form-check mb-2 mr-sm-2 ml-3">
                            <input class="form-check-input" type="checkbox" id="catalogo" name="catalogo"
                                @if ($producto[0]->documentacion_incluida != null) @if ($producto[0]->documentacion_incluida[0]->catalogo == true) checked @endif
                                @endif>
                            <label class="form-check-label text-2" for="catalogo">
                                Catálogo
                            </label>
                        </div>
                        <div class="form-check mb-2 mr-sm-2 ml-3">
                            <input class="form-check-input" type="checkbox" id="folletos" name="folletos"
                                @if ($producto[0]->documentacion_incluida != null) @if ($producto[0]->documentacion_incluida[0]->folletos == true) checked @endif
                                @endif>
                            <label class="form-check-label text-2" for="folletos">Folletos
                            </label>
                        </div>
                        <div class="form-check mb-2 mr-sm-2 ml-3">
                            <input class="form-check-input" type="checkbox" id="garantia" name="garantia"
                                @if ($producto[0]->documentacion_incluida != null) @if ($producto[0]->documentacion_incluida[0]->garantia == true) checked @endif
                                @endif>
                            <label class="form-check-label text-2" for="garantia">Garantía
                            </label>
                        </div>
                        <div class="form-check mb-2 mr-sm-2 ml-3">
                            <input class="form-check-input" type="checkbox" id="manuales" name="manuales"
                                @if ($producto[0]->documentacion_incluida != null) @if ($producto[0]->documentacion_incluida[0]->manuales == true) checked @endif
                                @endif>
                            <label class="form-check-label text-2" for="manuales">Manuales
                            </label>
                        </div>
                        <div class="form-check mb-2 mr-sm-2 ml-3">
                            <input class="form-check-input" type="checkbox" id="otro" name="otro"
                                @if ($producto[0]->documentacion_incluida != null) @if ($producto[0]->documentacion_incluida[0]->otro == true) checked @endif
                                @endif>
                            <label class="form-check-label text-2" for="otro">Otro
                            </label>
                        </div>
                    </div>
                </form>

                <div class="row d-flex justify-content-end mt-4 col-md-12 col-12" style="padding: 0;">
                    <div class="separator mb-3 mt-2"></div>
                    <div class="botones">
                        <a class="btn boton-7 mt-2" href="javascript:void(0)" id="btn_atras_caracteristicas"
                            role="button">
                            <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                    </div>
                    <div class="botones ml-3">
                        <button class="btn m-2 boton-2 " role="button" id="btn_guardar_entrega">Guardar</button>
                    </div>
                </div>
            </div>
            <!-- Entrega -->

            <!-- Precio -->
            <div class="tab-pane fade col-md-8 col-12 m-3" id="v_pills_precio" role="tabpanel"
                aria-labelledby="v_pills_precio_tab">
                <h4 class="text-green-2">Precio</h4>
                <div class="separator mb-3 col-12"></div>

                <div class="col-md-12 col-12">
                    <p class="text-green-p mt-4">1. Indica el precio de tu producto</p>
                    <p class="text-2 ml-2">El precio que indiques será sujeto a validación por parte del sistema.</p>
                    <div class="separator col-12 mb-3 mt-2"></div>
                </div>

                <div class="mt-4">
                    <h4 class="text-green-p ml-4">Precio por <span class="font-italic">pieza</span></h4>

                    <form id="frm_precio">
                        <div class="row ml-1">
                            <div class="form-group col-12 col-lg-6">
                                <label for="precio_unitario" class="text-1 mt-3">Precio unitario</label>
                                <input type="number" min="0" class="form-control text-xl-left"
                                    id="precio_unitario" name="precio_unitario" placeholder="0"
                                    value="{{ $producto[0]->precio_unitario }}">
                                <label for="unidad_minima_venta" class="text-1 mt-3">Unidades mínima de venta</label>

                                <input type="number" min="0" class="form-control text-xl-left"
                                    id="unidad_minima_venta" name="unidad_minima_venta" placeholder="0"
                                    value="{{ $producto[0]->unidad_minima_venta }}">

                                <label for="stock_disponible" class="text-1 mt-3">Stock disponible</label>
                                <input type="number" min="0" class="form-control text-xl-left"
                                    id="stock_disponible" name="stock_disponible" placeholder="0"
                                    value="{{ $producto[0]->stock }}">
                            </div>
                        </div>

                        <p class=" text-green-p mt-4">2. Indica la vigencia del precio</p>
                        <p class="text-2 ml-2">El precio que indiques será sujeto a validación por parte del sistema.</p>
                        <div class="separator col-12 mb-3 mt-2"></div>

                        <p class="text-2 ml-2">Vigencia de precio (días naturales)</p>
                        <div class="form-inline ml-3 mt-3">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="dias_naturales_30" name="dias_naturales"
                                    class="custom-control-input" checked value="30"
                                    @if ($producto[0]->vigencia == 30) checked @endif>
                                <label class="custom-control-label" for="dias_naturales_30">
                                    <p class="text-2">30 días</p>
                                </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="dias_naturales_60" name="dias_naturales"
                                    class="custom-control-input" value="60"
                                    @if ($producto[0]->vigencia == 60) checked @endif>
                                <label class="custom-control-label" for="dias_naturales_60">
                                    <p class="text-2">60 días</p>
                                </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="dias_naturales_90" name="dias_naturales"
                                    class="custom-control-input" value="90"
                                    @if ($producto[0]->vigencia == 90) checked @endif>
                                <label class="custom-control-label" for="dias_naturales_90">
                                    <p class="text-2">90 días</p>
                                </label>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row d-flex justify-content-end mt-4 col-md-12 col-12" style="padding: 0;">
                    <div class="separator mb-3 mt-2"></div>
                    <div class="botones">
                        <a class="btn boton-7 mt-2" href="javascript:void(0)" id="btn_atras_entrega" role="button">
                            <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                    </div>
                    <div class="botones ml-3">
                        <button class="btn m-2 boton-2" role="button" id="btn_guardar_precio">
                            @if ($producto[0]->validacion_tecnica)
                                Guardar
                            @else
                                Guardar y revisar
                            @endif
                        </button>
                    </div>
                </div>
            </div>
            <!-- Precio -->

            <!-- Valid. técnica -->
            @if ($producto[0]->validacion_tecnica)
                <div class="tab-pane fade col-md-8 col-12 m-3" id="v_pills_validacion_tec" role="tabpanel"
                    aria-labelledby="v_pills_validacion_tec_tab">
                    <h4 class="text-green-2">Validación técnica</h4>
                    <div class="separator mb-3 col-md-12 col-12"></div>

                    <div class="col-md-12 col-12">
                        <p class="text-green-p mt-4">1. Adjunta el resultado de tu prueba de laboratorio</p>
                        <p class="text-2 ml-2">Recuerda que tu documento debe ser expedido por una empresa con
                            certificación EMA.</p>
                        <div class="separator col-12 mb-3 mt-2"></div>

                        <form id="frm_validacion_tec">
                            <div class="row d-flex col-12 col-md-12">
                                <div class="input-group col-md-12 col-12 mb-3">
                                    <input type="file" class="form-control-file mt-1" id="prueba" name="prueba"
                                        accept=".pdf" required="">
                                </div>
                            </div>
                        </form>

                        <div class="separator col-12 mb-3 mt-2"></div>

                        <div class="row" id="pintar_validacion_tec">
                            @if ($producto[0]->validacion_tecnica_prueba != null)
                                <div class="col-6 d-flex justify-content-start">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        id="btn_eliminar_archivo_validacion_tec">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p class="text-1 ml-3">{{ strtoupper($producto[0]->validacion_tecnica_prueba) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row d-flex justify-content-end mt-4 col-md-12 col-12" style="padding: 0;">
                        <div class="separator mb-3 mt-2"></div>
                        <div class="botones">
                            <a class="btn boton-7 mt-2" href="javascript:void(0)" id="btn_atras_precio"
                                role="button">
                                <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                        </div>
                        <div class="botones ml-3">
                            <button class="btn m-2 boton-2" role="button" id="btn_revisar">Revisar</button>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Valid. técnica -->
        </div>
    </div>
@endsection
@section('js')
    @routes(['proveedor_fichap'])
    <script src="{{ asset('asset/js/proveedor_fp.js') }}" type="text/javascript"></script>
@endsection
