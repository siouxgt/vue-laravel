@extends('layouts.proveedores_ficha_productos')

@section('content')
    <div class="row d-flex align-items-center justify-content-center mt-4">

        <!-- Button trigger modal -->
        <button type="button" class="btn btn-transp" onclick="clickOpcionNav('inicio')">
            <div class="col-1 text-center">
                <div class="row text-center">
                    <div class="text-center">
                        <p class="indicador-count-card-6 fa-solid fa-check text-center"></p>
                    </div>
                </div>
            </div>
        </button>

        <div class="col-1 d-none d-sm-none d-md-block cont-linea">
            <hr class="linea-1">
        </div>

        <button type="button" class="btn btn-transp" onclick="clickOpcionNav('producto')">
            <div class="col-1 text-center">
                <div class="row text-center">
                    <div class="text-center">
                        <p class="indicador-count-card-6 fa-solid fa-check text-center"> </p>
                    </div>
                </div>
            </div>
        </button>

        <div class="col-1 d-none d-sm-none d-md-block cont-linea">
            <hr class="linea-1">
        </div>

        <button type="button" class="btn btn-transp" onclick="clickOpcionNav('ficha_tec')">
            <div class="col-1 text-center ">
                <div class="row text-center">
                    <div class="text-center">
                        <p class="indicador-count-card-6 fa-solid fa-check text-center"> </p>
                    </div>
                </div>
            </div>
        </button>

        <div class="col-1  d-none d-sm-none d-md-block cont-linea">
            <hr class="linea-1">
        </div>

        <button type="button" class="btn btn-transp" onclick="clickOpcionNav('caracteristicas')">
            <div class="col-1  text-center">
                <div class="row text-center">
                    <div class="text-center">
                        <p class="indicador-count-card-6 fa-solid fa-check text-center"> </p>
                    </div>
                </div>
            </div>
        </button>
        <div class="col-1 d-none d-sm-none d-md-block cont-linea">
            <hr class="linea-1">
        </div>

        <button type="button" class="btn btn-transp" onclick="clickOpcionNav('entrega')">
            <div class="col-1 text-center ">
                <div class="row text-center">
                    <div class="text-center">
                        <p class="indicador-count-card-6 fa-solid fa-check text-center"> </p>
                    </div>
                </div>
            </div>
        </button>
        <div class="col-1 d-none d-sm-none d-md-block cont-linea">
            <hr class="linea-1">
        </div>

        <button type="button" class="btn btn-transp" onclick="clickOpcionNav('precio')">
            <div class="col-1  text-center ">
                <div class="row text-center">
                    <div class="text-center">
                        <p class="indicador-count-card-6 fa-solid fa-check text-center"> </p>
                    </div>
                </div>
            </div>
        </button>

        @if ($producto[0]->validacion_tecnica)
            <div class="col-1 d-none d-sm-none d-md-block cont-linea">
                <hr class="linea-1">
            </div>

            <button type="button" class="btn btn-transp" onclick="clickOpcionNav('validacion_tec')">
                <div class="col-1  text-center ">
                    <div class="row text-center">
                        <div class="text-center">
                            <p class="indicador-count-card-6 fa-solid fa-check text-center"> </p>
                        </div>
                    </div>
                </div>
            </button>
        @endif
    </div>

    <div class="row mt-3">
        <div class="nav flex-column nav-pills border" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            <a class="nav-link bg-light active col-auto" id="v_pills_inicio_tab" data-toggle="pill" href="#v_pills_inicio"
                role="tab" aria-controls="v_pills_inicio" aria-selected="true">
                <p class="text-1 col-auto">
                    <i class="fa fa-arrow-right gris"></i> <span>Inicio</span>
                </p>
            </a>
            <a class="nav-link bg-light border col-auto" id="v_pills_producto_tab" data-toggle="pill"
                href="#v_pills_producto" role="tab" aria-controls="v_pills_producto" aria-selected="false">
                <p class="text-1 col-auto">
                    <i class="fa fa-tag gris" aria-hidden="true"></i><span>Producto</span>
                </p>
            </a>
            <a class="nav-link bg-light border col-auto" id="v_pills_ficha_tec_tab" data-toggle="pill"
                href="#v_pills_ficha_tecnica" role="tab" aria-controls="v_pills_ficha_tecnica" aria-selected="false">
                <p class="text-1 col-auto">
                    <i class="fa-solid fa-file gris"></i><span>Ficha técnica</span>
                </p>
            </a>
            <a class="nav-link bg-light border col-auto" id="v_pills_caracteristicas_tab" data-toggle="pill"
                href="#v_pills_caracteristicas" role="tab" aria-controls="v_pills_caracteristicas"
                aria-selected="false">
                <p class="text-1 col-auto">
                    <i class="fa-solid fa-list gris"></i>
                    <span>Características</span>
                </p>
            </a>
            <a class="nav-link bg-light border col-auto" id="v_pills_entrega_tab" data-toggle="pill"
                href="#v_pills_entrega" role="tab" aria-controls="v_pills_entrega" aria-selected="false">
                <p class="text-1 col-auto">
                    <i class="fa-solid fa-truck gris"></i>
                    <span>Entrega</span>
                </p>
            </a>
            <a class="nav-link bg-light border col-auto" id="v_pills_precio_tab" data-toggle="pill"
                href="#v_pills_precio" role="tab" aria-controls="v_pills_precio" aria-selected="false">
                <p class="text-1 col-auto">
                    <i class="fa-solid fa-dollar-sign gris"></i><span>Precio</span>
                </p>
            </a>
            @if ($producto[0]->validacion_tecnica)
                <a class="nav-link bg-light border col-auto" id="v_pills_validacion_tec_tab" data-toggle="pill"
                    href="#v_pills_validacion_tec" role="tab" aria-controls="v_pills_validacion_tec"
                    aria-selected="false">
                    <p class="text-1 col-auto">
                        <i class="fa-solid fa-flask gris"></i><span>Valid. técnica</span>
                    </p>
                </a>
            @endif
        </div>

        <div class="tab-content ml-3 col-8" id="v-pills-tabContent">
            <!--  Inicio -->
            <div class="tab-pane fade in active col-md-8 col-12" id="v_pills_inicio" role="tabpanel"
                aria-labelledby="v_pills_inicio_tab">
                <!-- -----Alerta 1------- -->
                <div class="alert alert-warning alert-dismissible fade show col-lg-8 col-md-8 col-12 mt-4 ml-5"
                    role="alert">
                    <div class="d-flex align-items-center">
                        <div class="bg-amarillo mr-3"></div>
                        <strong class="font-weight-bold text-aler-amarillo">Tienes hasta el
                            {{ Carbon\Carbon::parse($producto[0]->fecha_carga)->format('d-m-Y') }}
                            para completar tu ficha</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <!-- -----Alerta 1------- -->

                <h4 class="text-green-2">Inicio</h4>
                <div class="separator col-12 col-md-10 mt-1"></div>


                <form id="frm_inicio" method="POST">
                    <div class="row">
                        <div class="col-md-2 col-12">
                            <p class="text-2">NOMBRE PRODUCTO</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="nombre_producto">
                                <strong>{{ strtoupper($producto[0]->nombre_corto) }}</strong>
                            </p>
                            <input type="hidden" id="producto_id" name="producto_id" value="{{ $producto[0]->id_e }}">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-2 col-12">
                            <p class="text-2">ID PRODUCTO</p>
                        </div>
                        <div class="col-md-9 col-12">
                            <p class="text-2" id="id_producto">
                                <strong>{{ strtoupper($producto[0]->elidproducto) }}</strong>
                            </p>
                            <input type="hidden" id="id_producto" name="id_producto"
                                value="{{ $producto[0]->elidproducto }}">
                        </div>
                    </div>

                    <!-- Contrato Marco -->
                    <div class="row mt-4">
                        <div class="col-12 mb-3">
                            <p class="text-green-p">Contrato Marco:</p>
                        </div>
                        <div class="col-md-2 col-12">
                            <p class="text-2">NÚMERO</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_numero">
                                <strong>{{ strtoupper($producto[0]->numero_cm) }}</strong>
                            </p>
                        </div>
                    </div>
                    <div class="separator col-12 col-md-10 mt-1"></div>


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
                    <div class="separator col-12 col-md-10 mt-1"></div>


                    <div class="row mt-1">
                        <div class="col-md-2 col-12">
                            <p class="text-2">NÚMERO FICHA</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_numero_ficha">{{ strtoupper($producto[0]->numero_ficha) }}</p>
                        </div>
                    </div>
                    <div class="separator col-12 col-md-10 mt-1"></div>


                    <div class="row mt-1">
                        <div class="col-md-2 col-12">
                            <p class="text-2">VERSIÓN</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_version">{{ $producto[0]->version }}</p>
                            <input type="hidden" id="inicio_version" name="inicio_version"
                                value="{{ $producto[0]->version }}">
                        </div>
                    </div>
                    <div class="separator col-12 col-md-10 mt-1"></div>

                    <!-- Contrato Marco -->

                    <!-- Categoría: -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <p class="text-green-p mb-3">Categoría:</p>
                        </div>
                        <div class="col-md-2 col-12">
                            <p class="text-2">CAPÍTULO</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_capitulo">{{ strtoupper($producto[0]->capitulo) }}</p>
                        </div>
                    </div>
                    <div class="separator col-12 col-md-10 mt-1"></div>


                    <div class="row mt-2">
                        <div class="col-md-2 col-12">
                            <p class="text-2">PARTIDA</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_partida">{{ strtoupper($producto[0]->partida) }}</p>
                        </div>
                    </div>
                    <div class="separator col-12 col-md-10 mt-1"></div>


                    <div class="row mt-1">
                        <div class="col-md-2 col-12">
                            <p class="text-2">CLAVE CABMS</p>
                        </div>
                        <div class="col-md-10 col-12">
                            <p class="text-2" id="inicio_clave_cabms">{{ strtoupper($producto[0]->cabms) }} -
                                {{ strtoupper($producto[0]->descripcion) }}</p>
                        </div>
                    </div>
                    <div class="separator col-12 col-md-10 mt-1"></div>
                    <!-- Categoría: -->

                    <div class="col-10" style="padding: 0%;">
                        <p class="text-green-p mt-4 mb-3">Características:</p>
                        <div class="form-group">
                            <textarea class="form-control" id="inicio_caracteristicas" name="inicio_caracteristicas" rows="3" readonly>{{ strtoupper($producto[0]->especificaciones) }}</textarea>
                        </div>
                    </div>
                    <!-- Características:-->
                </form>

                <!-- Información requerida: -->
                <p class="text-green-p mt-4">Información requerida:</p>

                <div class="row mt-3">
                    <div class="col-md-12 col-12 d-flex">
                        <p class="text-2" id="inicio_fotografias">
                            <strong class="mr-2">FOTOGRAFÍAS.</strong>Hasta 6 en formato jpg o png y menos de
                            1MB cada una.
                        </p>
                    </div>
                    <div class="separator col-12 col-md-10 mt-1"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12 col-12 d-flex">
                        <p class="text-2" id="inicio_ficha_tecnica">
                            <strong class="mr-2">FICHA TÉCNICA.</strong>Formato .doc con Información sobre tu
                            producto.
                        </p>
                        <a class="btn btn-cdmx" target="_blank"
                            href="{{ route('proveedor_fp.ver_doc', [$producto[0]->archivo_ficha_tecnica, 3]) }}">
                            <p class="text-gold-4 ml-2">Descargar aquí.</p>
                        </a>
                    </div>
                    <div class="separator col-12 col-md-10 mt-1"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12 col-12 d-flex">
                        <p class="text-2" id="inicio_precio">
                            <strong class="mr-2">PRECIO.</strong>Este pasará por un proceso de validación.
                        </p>
                        <a target="_blank" href="{{ asset('files/precio-maximo.pdf') }}">
                            <p class="text-gold-4 ml-2">Más información.</p>
                        </a>
                    </div>
                    <div class="separator col-12 col-md-10 mt-1"></div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-12 col-12 d-flex">
                        <p class="text-2" id="inicio_resultado_pruebas">
                            <strong class="mr-2">RESULTADOS DE PRUEBAS.</strong>Si tu producto requiere
                            validación técnica.
                        </p>
                        <a target="_blank" href="{{ asset('files/validacion-tecnica.pdf') }}">
                            <p class="text-gold-4 ml-2">Más información.</p>
                        </a>
                    </div>
                    <div class="separator col-12 col-md-10 mt-1"></div>
                    <div class="separator col-12 col-md-10 mt-5"></div>
                </div>

                <div class="row d-flex justify-content-end mt-4 col-md-10 col-12">
                    <div class="botones">
                        <button class="btn m-2 boton-2 " id="btn_guardar_inicio">Empezar</button>
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
                    <form>
                        <div class="form-group">
                            <label class="text-1">Nombre de tu producto</label>
                            <input type="text" class="form-control" placeholder="Proporciona el nombre de tu producto"
                                disabled>
                        </div>
                        <p class="text-2 font-italic">
                            <i class="fa-solid fa-lightbulb amarillo"></i>
                            Este es el título de la publicación. Incluye el nombre de
                            tu producto y una característica que lo distinga.
                        </p>

                        <div class="form-group mt-3">
                            <label class="text-1">Describe tu producto</label>
                            <input type="text" class="form-control"
                                placeholder="Proporciona la descripción de tu producto" disabled>
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
                                        disabled>
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div class="card bg-white" style="width: 5rem;">
                                    <img class="card-img-top" src="{{ asset('asset/img/bac_imag_fondo.svg') }}"
                                        alt="Card image cap">
                                </div>
                            </div>
                            <div class="col-4 ml-2 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        disabled>
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div class="card bg-white" style="width: 5rem;">
                                    <img class="card-img-top" src="{{ asset('asset/img/bac_imag_fondo.svg') }}"
                                        alt="Card image cap">
                                </div>
                            </div>
                            <div class="col-4 ml-2 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        disabled>
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div class="card bg-white" style="width: 5rem;">
                                    <img class="card-img-top" src="{{ asset('asset/img/bac_imag_fondo.svg') }}"
                                        alt="Card image cap">
                                </div>
                            </div>
                            <div class="col-4 ml-2 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        disabled>
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div class="card bg-white" style="width: 5rem;">
                                    <img class="card-img-top" src="{{ asset('asset/img/bac_imag_fondo.svg') }}"
                                        alt="Card image cap">
                                </div>
                            </div>
                            <div class="col-4 ml-2 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        disabled>
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div class="card bg-white" style="width: 5rem;">
                                    <img class="card-img-top" src="{{ asset('asset/img/bac_imag_fondo.svg') }}"
                                        alt="Card image cap">
                                </div>
                            </div>
                            <div class="col-4 ml-2 col-md-2">
                                <h5 class="card-header float-right">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                        disabled>
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </h5>
                                <div class="card bg-white" style="width: 5rem;">
                                    <img class="card-img-top" src="{{ asset('asset/img/bac_imag_fondo.svg') }}"
                                        alt="Card image cap">
                                </div>
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
                        <a class="btn boton-7 mt-2" href="javascript:void(0)" onclick="clickOpcionNav('inicio')"
                            role="button">
                            <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                    </div>
                    <div class="botones ml-3">
                        <button class="btn m-2 boton-2" role="button" disabled>Guardar</button>
                    </div>
                </div>
            </div>
            <!-- Producto -->

            <!-- ficha técnica -->
            <div class="tab-pane fade col-md-7 col-12 m-3" id="v_pills_ficha_tecnica" role="tabpanel"
                aria-labelledby="v_pills_ficha_tecnica_tab">
                <h4 class="text-green-2">Ficha técnica</h1>
                    <div class="separator mb-3"></div>

                    <form>
                        <p class="text-green-p mt-4">1. Ficha técnica de tu producto</p>
                        <p class="text-2 ml-2">Descarga el documento en .doc, llénalo y adjuntalo en formato PDF de
                            hasta 3MB</p>
                        <div class="separator col-12 mb-3 mt-2"></div>

                        <div class="text-gold  mt-4">
                            <a href="{{ route('proveedor_fp.ver_doc', [$producto[0]->archivo_ficha_tecnica, 3]) }}"
                                class="text-gold" id="btn_descargar_ficha_tec">
                                <i class="fa-solid fa-download text-gold"></i>
                                Descarga la Ficha técnica
                            </a>
                        </div>
                        <div class="row d-flex mt-3">
                            <div class="input-group col-md-12 col-12 mb-3">
                                <input type="file" class="form-control-file mt-1" disabled>
                            </div>
                            <div class="separator col-12 mb-3 mt-2"></div>
                        </div>
                    </form>

                    <form>
                        <p class="text-green-p mt-4">2. ¿Quieres subir otros documentos</p>
                        <p class="text-2 ml-2">Adjunta aquí documentos adicionales en formato PDF de hasta 3MB</p>
                        <div class="separator col-12 mb-3 mt-2"></div>

                        <div class="row d-flex">
                            <div class="input-group col-md-12 col-12 mb-3">
                                <input type="file" class="form-control-file mt-1" disabled>
                            </div>
                            <div class="separator col-12 mb-3 mt-2"></div>
                        </div>

                        <div id="doc_adicional_uno_div">
                        </div>

                        <div id="doc_adicional_dos_div">
                        </div>

                        <div id="doc_adicional_tres_div">
                        </div>
                    </form>

                    <div class="row d-flex justify-content-end mt-4 col-md-12 col-12" style="padding: 0;">
                        <div class="separator mb-3 mt-2"></div>
                        <div class="botones">
                            <a class="btn boton-7 mt-2" href="javascript:void(0)" onclick="clickOpcionNav('producto')"
                                role="button">
                                <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                        </div>
                        <div class="botones ml-3">
                            <button class="btn m-2 boton-2" role="button" disabled>Guardar</button>
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
                        <p class="text-2">Los compradores necesitan esta información. Ten en cuenta que los campos
                            marcados con asterisco (<b style="color:#FF0000" ;>*</b>) son estrictamente obligatorios.</p>
                        <div class="separator col-12 mb-3 mt-2"></div>
                    </div>
                </div>

                <form>
                    <div class="row ml-1">
                        <div class="col-12 col-md-6">
                            <label for="marca" class="">Marca<b style="color:#FF0000" ;>*</b></label>
                            <input type="text" class="form-control" disabled>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="modelo" class="">Modelo</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="col-12 col-md-6">
                            <label for="material" class="">Material<b style="color:#FF0000" ;>*</b></label>
                            <input type="text" class="form-control" disabled>
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="composicion" class="">Composición</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="form-group col-12 col-md-6 col-lg-4">
                            <label class="">Tamaño<b style="color:#FF0000;">*</b></label>
                            <input type="text" class="form-control" disabled>
                        </div>

                        <div class="col-12 col-md-5 col-lg-3">
                            <div class="botones mt-3" data-toggle="modal" data-target="#staticBackdrop">
                                <a class="btn mt-3 boton-2 col-md-10" href="javascript:void(0)" role="button">Color</a>
                                <b style="color:#FF0000;">*</b>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-5">
                            <div class="botones mt-3" data-toggle="modal" data-target="#staticBackdrop">
                                <a class="btn mt-3 boton-2 col-12" href="javascript:void(0)"
                                    role="button">Dimensiones</a>
                            </div>
                        </div>
                    </div>

                    <div class="row ml-1">
                        <div class="col-md-12 col-12">
                            <p class="text-green-p mt-4">2. Otras características</p>
                            <p class="text-2">Si tu producto no cuenta con alguna de las solicitadas, deja vacío el
                                campo.
                            </p>
                            <div class="separator col-12 mb-3 mt-2"></div>
                        </div>
                    </div>

                    <div class="row ml-1">
                        <div class="col-12 col-md-6">
                            <label for="sku" class="">Código de barras</label>
                            <input type="text" class="form-control" disabled>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="fabricante" class="">Fabricante</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="col-12 col-md-6">
                            <label for="pais_origen">País de origen</label>
                            <input type="text" class="form-control" disabled>
                        </div>

                        <div class=" col-12 col-md-6">
                            <label for="grado_integracion_nacional" class="">Grado de integración nacional</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="col-12 col-md-6">
                            <label for="presentacion">Presentación</label>
                            <input type="text" class="form-control" disabled>
                        </div>

                        <div class=" col-12 col-md-6">
                            <label for="disenio">Diseño</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="col-12 col-md-6">
                            <label for="acabado">Acabado</label>
                            <input type="text" class="form-control" disabled>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="forma">Forma</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="col-12 col-md-6">
                            <label for="aspecto">Aspecto</label>
                            <input type="text" class="form-control" disabled>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="etiqueta">Etiqueta</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row ml-1 mt-3">
                        <div class="col-12 col-md-6">
                            <label for="envase">Envase</label>
                            <input type="text" class="form-control" disabled>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="empaque">Empaque</label>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>
                </form>

                <div class="row d-flex justify-content-end mt-4 col-md-12 col-12" style="padding: 0;">
                    <div class="separator mb-3 mt-2"></div>
                    <div class="botones">
                        <a class="btn boton-7 mt-2" href="javascript:void(0)" onclick="clickOpcionNav('ficha_tec')"
                            role="button">
                            <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                    </div>
                    <div class="botones ml-3">
                        <button class="btn m-2 boton-2" role="button" disabled>Guardar</button>
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
                            <p class="text-2 ml-1">Indica cuánto tiempo te lleva entregar el producto. Considera que los
                                días
                                son hábiles.</p>
                            <div class="separator col-12 mb-3 mt-2"></div>

                            <div class="row">
                                <div class="col-md-7 col-12 ">
                                    <div class="form-row d-flex align-items-end">
                                        <div class="form-group col-6">
                                            <label for="tiempo_de_entrega" class="text-2">
                                                Tiempo de entrega
                                            </label>
                                            <input type="number" min="0" class="form-control col-10 text-right"
                                                disabled>
                                        </div>
                                        <div class="form-group col-6 mt-2">
                                            <select class="form-control mt-4" style="padding: 0; height: 2rem;" disabled>
                                                <option>Días</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-green-p mt-4">2. Documentación incluida en la entrega</p>
                    <p class="text-2 ml-1">Indica qué información entregarás junto con el producto.</p>
                    <div class="separator col-12 mb-3 mt-2"></div>

                    <div class="form-inline mb-2">
                        <div class="form-check mb-2 mr-sm-2 ml-3">
                            <input class="form-check-input" type="checkbox" disabled>
                            <label class="form-check-label" for="catalogo">
                                <p class="text-2">Catálogo</p>
                            </label>
                        </div>
                        <div class="form-check mb-2 mr-sm-2 ml-3">
                            <input class="form-check-input" type="checkbox" disabled>
                            <label class="form-check-label" for="folletos">
                                <p class="text-2">Folletos</p>
                            </label>
                        </div>
                        <div class="form-check mb-2 mr-sm-2 ml-3">
                            <input class="form-check-input" type="checkbox" disabled>
                            <label class="form-check-label" for="garantia">
                                <p class="text-2">Garantía</p>
                            </label>
                        </div>
                        <div class="form-check mb-2 mr-sm-2 ml-3">
                            <input class="form-check-input" type="checkbox" disabled>
                            <label class="form-check-label" for="manuales">
                                <p class="text-2">Manuales</p>
                            </label>
                        </div>
                        <div class="form-check mb-2 mr-sm-2 ml-3">
                            <input class="form-check-input" type="checkbox" disabled>
                            <label class="form-check-label" for="otro">
                                <p class="text-2">Otro</p>
                            </label>
                        </div>
                    </div>

                </form>

                <div class="row d-flex justify-content-end mt-4 col-md-12 col-12" style="padding: 0;">
                    <div class="separator mb-3 mt-2"></div>
                    <div class="botones">
                        <a class="btn boton-7 mt-2" href="javascript:void(0)" onclick="clickOpcionNav('caracteristicas')"
                            role="button">
                            <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                    </div>
                    <div class="botones ml-3">
                        <button class="btn m-2 boton-2 " role="button" disabled>Guardar</button>
                    </div>
                </div>
            </div>
            <!-- Entrega -->

            <!-- Precio -->
            <div class="tab-pane fade col-md-8 col-12 m-3" id="v_pills_precio" role="tabpanel"
                aria-labelledby="v_pills_precio_tab">
                <h4 class="text-green-2">Precio</h4>
                <div class="separator mb-3 col-12"></div>

                <div class="row">
                    <div class="col-md-12 col-12">
                        <p class="text-green-p mt-4">1. Indica el precio de tu producto</p>
                        <p class="text-2 ml-2">El precio que indiques será sujeto a validación por parte del sistema.</p>
                        <div class="separator col-12 mb-3 mt-2"></div>
                    </div>
                </div>

                <div class="mt-4">
                    <h4 class="text-green-p ml-4">Precio por <span class="font-italic">pieza</span></h4>

                    <form>
                        <div class="row ml-1">
                            <div class="form-group col-12 col-lg-6">
                                <label for="precio_unitario" class=" text-1 mt-3">Precio unitario</label>
                                <input type="number" min="0" class="form-control text-xl-left" disabled>

                                <label for="unidad_minima_venta" class=" text-1 mt-3">Unidades mínima de venta</label>
                                <input type="number" min="0" class="form-control text-xl-left" disabled>

                                <label for="stock_disponible" class=" text-1 mt-3">Stock disponible</label>
                                <input type="number" min="0" class="form-control text-xl-left" disabled>
                            </div>
                        </div>

                        <p class=" text-green-p mt-4">2. Indica la vigencia del precio</p>
                        <p class="text-2 ml-2">El precio que indiques será sujeto a validación por parte del sistema.</p>
                        <div class="separator col-12 mb-3 mt-2"></div>

                        <p class="text-2 ml-2">Vigencia de precio (días naturales)</p>
                        <div class="form-inline ml-3 mt-3">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" checked disabled>
                                <label class="custom-control-label" for="dias_naturales_30">
                                    <p class="text-2">30 días</p>
                                </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" disabled>
                                <label class="custom-control-label" for="dias_naturales_60">
                                    <p class="text-2">60 días</p>
                                </label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" disabled>
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
                        <a class="btn boton-7 mt-2" href="javascript:void(0)" onclick="clickOpcionNav('entrega')"
                            role="button">
                            <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                    </div>
                    <div class="botones ml-3">
                        <button class="btn m-2 boton-2" role="button" disabled>
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
                                    <input type="file" class="form-control-file mt-1" disabled>
                                </div>
                            </div>
                        </form>

                        <div class="separator col-12 mb-3 mt-2"></div>
                        <div class="row" id="pintar_validacion_tec"></div>

                    </div>
                    <div class="row d-flex justify-content-end mt-4 col-md-12 col-12" style="padding: 0;">
                        <div class="separator mb-3 mt-2"></div>
                        <div class="botones">
                            <a class="btn boton-7 mt-2" href="javascript:void(0)" onclick="clickOpcionNav('precio')"
                                role="button">
                                <i class="fa-solid fa-arrow-left green"></i>Atras</a>
                        </div>
                        <div class="botones ml-3">
                            <button class="btn m-2 boton-2" role="button" disabled>Revisar</button>
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
    <script>
        (function() {
            let disponibleGuardarInicio = false,
                estatusInicio = false;

            $(document).on("click", "#btn_guardar_inicio", function(e) {
                e.preventDefault();
                if (disponibleGuardarInicio) {
                    return false;
                }
                disponibleGuardarInicio = true;

                if (estatusInicio == true) {
                    return false;
                }

                let formData = new FormData($("#frm_inicio").get(0));
                console.log(formData);

                $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: route("proveedor_fp.store"),
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(respuesta) {
                        if (respuesta.status == 400) {
                            let mensaje;
                            $.each(respuesta.errors, function(key, err_value) {
                                mensaje += "<li>" + err_value + "</li>";
                            });

                            Swal.fire({
                                title: "Existen campos faltantes",
                                html: "<ul>" + mensaje + "</ul>",
                                icon: "error",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "OK",
                            });
                        } else {
                            let btnGuardarInicio = document.getElementById('btn_guardar_inicio');
                            btnGuardarInicio.disabled = true;
                            estatusInicio = true;
                            preguntaIniciarRegistro(respuesta.message, respuesta.permiso);
                        }
                    },
                    error: function(xhr) {
                        Swal.fire("¡Alerta!", xhr, "warning");
                    },
                });
            });

            function preguntaIniciarRegistro(texto, permiso) {
                let titulo = "!Todo listo, ya puede iniciar!";

                Swal.fire({
                    title: titulo,
                    text: texto,
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK",
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = route("proveedor_fp.edit", permiso);
                    }
                });
            }
        })();

        function clickOpcionNav(opcion) {
            $("#v_pills_" + opcion + "_tab").tab("show");
        }
    </script>
@endsection
