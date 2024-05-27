@extends('layouts.proveedores_ficha_productos')

@section('content')
    <div class="row badge-light mt-3 pt-3 pb-3">
        <div class="col-md-9 col-sm-12">
            <h4 class="text-green-2 float-right">Ya estas por concluir, ¿Qué quieres hacer?</h4>
        </div>
        <div class="col-md-1 col-sm-2 text-center">
            <a class="btn boton-7 border" href="{{ route('proveedor_fp.edit', $producto[0]->id_e) }}" role="button">Editar</a>
        </div>
        <div class="col-md-2 col-sm-2 text-center">
            <input type="hidden" value="{{ $producto[0]->id_e }}" id="id_o">
            <input type="hidden" value="{{ $catProductoId }}" id="cat_producto_id">
            @if (!$edicion)
                <a class="btn boton-2" href="javascript:void(0)" role="button" id="btn_enviar_revision">Enviar a
                    revisión</a>
            @else
                <input type="hidden" value="{{ $edicion }}" id="estado_edicion">
                <button class="btn boton-2" disabled>Enviar a revisión</button>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-sm-12 col-md-5 text-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-1">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{ strtoupper($producto[0]->numero_cm) }}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{ strtoupper($producto[0]->id_producto) }}</a>
                    </li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Versión: {{ $producto[0]->version }}</a></li>
                </ol>
            </nav>
        </div>

        <div class="col-sm-12 col-md-6 text-2">
            <p class="text-2 float-right mr-5">Última edición: {{ $producto[0]->updated_at }}</p>
        </div>

        <div class="col-md-1 col-sm-1"></div>
    </div>
    <hr>

    <div class="row justify-content-center" style="margin: 0;">
        <div class="col-12 col-md-12 col-lg-5 mt-3 ">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <h1 class="ml-4 nombre-prod"><strong>{{ strtoupper($producto[0]->nombre_corto) }}</strong></h1>
                    <!-- -----Información------- -->
                    <div class="row col-12 col-md-12 d-flex text-2">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-1">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="#">Contratos Marco</a></li>
                                <li class="breadcrumb-item"><a
                                        href="#">{{ strtoupper($producto[0]->nombre_producto) }}</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div class="row justify-content-end float-right mb-4 col-md-6 col-12 mt-3">
                    <p class="porLiberar">Nuevo</p>
                </div>
                @php
                    $nombreFotos = ['foto_uno', 'foto_dos', 'foto_tres', 'foto_cuatro', 'foto_cinco', 'foto_seis'];
                    $totalFotos = $i = $j = 0;
                @endphp

                @foreach ($nombreFotos as $nombre)
                    @if ($producto[0]->$nombre != null)
                        @php $totalFotos++; @endphp
                    @endif
                @endforeach

                @foreach ($nombreFotos as $nombre)
                    @if ($producto[0]->$nombre != null)
                        @php $i++; @endphp
                        <div class="mySlides">
                            <div class="numbertext">{{ $i }} / {{ $totalFotos }}</div>
                            <img src="{{ asset('storage/img-producto-pfp/' . $producto[0]->$nombre) }}" class="zoom">
                        </div>
                    @endif
                @endforeach

                <div class="row mt-3 d-flex justify-content-center">
                    @foreach ($nombreFotos as $nombre)
                        @if ($producto[0]->$nombre != null)
                            @php $j++; @endphp
                            <div class="column">
                                <img class="demo cursor"
                                    src="{{ asset('storage/img-producto-pfp/' . $producto[0]->$nombre) }}"
                                    style="width:50%" onclick="currentSlide({{ $j }})" alt="">
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="col-12 col-md-6 d-block d-sm-block d-md-none">
                <span class="text-1 font-weight-bold ml-2">{{ strtoupper($producto[0]->marca) }}</span>
                <p class="text-10 ml-2">{{ strtoupper($producto[0]->nombre_producto) }}</p>
                <div class="col-12 col-md-12 col-lg-12 mt-3">
                    <div style="overflow-x: auto;" class="">
                        <p class="text-2"><strong>Modelo: </strong>
                            @if ($producto[0]->modelo != '' || $producto[0]->modelo != null)
                                {{ strtoupper($producto[0]->modelo) }}
                            @else
                                NO ESPECIFICADO
                            @endif
                        </p>
                        <p class="text-2"><strong>Material: </strong>{{ strtoupper($producto[0]->material) }}</p>
                        @if ($producto[0]->composicion != '' || $producto[0]->composicion != null)
                            <p class="text-2"><strong>Composición:</strong> {{ strtoupper($producto[0]->composicion) }}
                            </p>
                        @endif
                        <p class="text-2"><strong>Mínimo de venta: </strong> {{ $producto[0]->unidad_minima_venta }}
                            {{ $producto[0]->medida }}(s)</p>
                        <p class="text-2"><strong>Stock disponible: </strong>{{ $producto[0]->stock }}
                            {{ $producto[0]->medida }}(s)</p>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3">
                <p class="titel-2">Descripción</p>
            </div>
            <div class="separator col-12 col-md-8"></div>
            <div class="col-12 col-md-8 mt-3">
                <p class="text-1">{{ strtoupper($producto[0]->descripcion_producto) }}</p>
            </div>
            <br>
            <div class="col-12 mt-3">
                <p class="titel-2">Otras características</p>
            </div>
            <div class="separator col-12 col-md-8"></div>
            <div class="col-12 col-md-12 col-lg-8">
                <div class="mt-3">
                    @if ($producto[0]->sku != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Código de barras</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->sku) }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->fabricante != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Fabricante</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->fabricante) }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->pais_origen != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Pais de origen</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->pais_origen) }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-5 mb-3">
                            <p class="text-1"><strong>Dimensiones</strong></p>
                        </div>
                        <div class="col-7">
                            @php
                                $unidadesMedidaLongitud = ['m.', 'cm.', 'mm.'];
                                $unidadesMedidaPeso = ['t.', 'kg.', 'g.'];
                                $cadena_dimensiones = '';
                            @endphp
                            @if ($producto[0]->dimensiones != null)
                                @php
                                    $cadena_dimensiones .=
                                        'LARGO: ' .
                                        $producto[0]->dimensiones[0]->largo .
                                        ' ' .
                                        $unidadesMedidaLongitud[$producto[0]->dimensiones[0]->unidad_largo] .
                                        ', ';
                                    $cadena_dimensiones .=
                                        'ANCHO: ' .
                                        $producto[0]->dimensiones[0]->ancho .
                                        ' ' .
                                        $unidadesMedidaLongitud[$producto[0]->dimensiones[0]->unidad_ancho] .
                                        ', ';
                                    $cadena_dimensiones .=
                                        'ALTO: ' .
                                        $producto[0]->dimensiones[0]->alto .
                                        ' ' .
                                        $unidadesMedidaLongitud[$producto[0]->dimensiones[0]->unidad_alto] .
                                        ', ';
                                    $cadena_dimensiones .=
                                        'PESO: ' .
                                        $producto[0]->dimensiones[0]->peso .
                                        ' ' .
                                        $unidadesMedidaPeso[$producto[0]->dimensiones[0]->unidad_peso];
                                @endphp
                            @endif
                            <p class="text-1">{{ $cadena_dimensiones }}</p>
                        </div>
                    </div>
                    @if ($producto[0]->grado_integracion_nacional != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Grado de integración nacional</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ $producto[0]->grado_integracion_nacional }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->presentacion != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Presentación</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->presentacion) }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->disenio != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Diseño</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->disenio) }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->acabado != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Acabado</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->acabado) }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->forma != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Forma</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->forma) }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->aspecto != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Aspecto</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->aspecto) }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->etiqueta != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Etiqueta</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->etiqueta) }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->envase != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Envase</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->envase) }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->empaque != null)
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Empaque</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->empaque) }}</p>
                            </div>
                        </div>
                    @endif
                    @if ($producto[0]->documentacion_incluida != '')
                        <div class="row">
                            <div class="col-5">
                                <p class="text-1"><strong>Documentación incluida a la entrega</strong></p>
                            </div>
                            <div class="col-7">
                                <p class="text-1">{{ strtoupper($producto[0]->documentacion_incluida) }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-8">
                <div class="row col-12 mt-3">
                    <p class="titel-2">Información complementaria</p>
                </div>
                <hr>

                <div class="row col-12 d-flex align-items-stretch justify-content-center mt-4">
                    <div class="col-6 text-center">
                        <p class="text-2 mb-2">Ficha técnica</p>
                        <a class="p-2" target="_blank"
                            href="{{ route('proveedor_fp.ver_doc', $producto[0]->doc_ficha_tecnica) }}">
                            <i class="fa-regular fa-file-pdf text-gold-5"></i>
                        </a>
                    </div>

                    <!---------------------otros 1----------------------->
                    <div class="col-6">
                        <div class="col-12 text-center">
                            @if (
                                $producto[0]->doc_adicional_uno != null ||
                                    $producto[0]->doc_adicional_dos != null ||
                                    $producto[0]->doc_adicional_tres != null)
                                <p class="text-2">Otros</p>
                            @endif
                        </div>
                        <div class="row mt-2 ml-4 d-flex justify-content-center">
                            @if ($producto[0]->doc_adicional_uno != null)
                                <div class="col-4">
                                    <a target="_blank"
                                        href="{{ route('proveedor_fp.ver_doc', [$producto[0]->doc_adicional_uno, 2]) }}">
                                        <i class="fa-regular fa-file-pdf text-gold-5"></i>
                                    </a>
                                </div>
                            @endif
                            @if ($producto[0]->doc_adicional_dos != null)
                                <div class="col-4">
                                    <a target="_blank"
                                        href="{{ route('proveedor_fp.ver_doc', [$producto[0]->doc_adicional_dos, 2]) }}">
                                        <i class="fa-regular fa-file-pdf text-gold-5"></i>
                                    </a>
                                </div>
                            @endif
                            @if ($producto[0]->doc_adicional_tres != null)
                                <div class="col-4">
                                    <a target="_blank"
                                        href="{{ route('proveedor_fp.ver_doc', [$producto[0]->doc_adicional_tres, 2]) }}">
                                        <i class="fa-regular fa-file-pdf text-gold-5"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!---------------------otros 1----------------------->
                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-5 mt-3">
            <div class="row">
                <div class="col-12 col-md-6 d-none d-sm-none d-md-block">
                    <span class="text-1 font-weight-bold ml-2">{{ strtoupper($producto[0]->marca) }}</span>
                    <p class="text-10 ml-2">{{ strtoupper($producto[0]->nombre_producto) }}</p>
                    <div class="col-12 col-md-12 col-lg-12 mt-3">
                        <div style="overflow-x: auto;" class="">
                            <p class="text-2"><strong>Modelo: </strong>
                                @if ($producto[0]->modelo != '' || $producto[0]->modelo != null)
                                    {{ strtoupper($producto[0]->modelo) }}
                                @else
                                    NO ESPECIFICADO
                                @endif
                            </p>
                            <p class="text-2"><strong>Material: </strong>{{ strtoupper($producto[0]->material) }}</p>
                            @if ($producto[0]->composicion != '' || $producto[0]->composicion != null)
                                <p class="text-2"><strong>Composición:</strong>
                                    {{ strtoupper($producto[0]->composicion) }}</p>
                            @endif
                            <p class="text-2"><strong>Mínimo de venta: </strong>{{ $producto[0]->unidad_minima_venta }}
                                {{ $producto[0]->medida }}(s)</p>
                            <p class="text-2"><strong>Stock disponible: </strong>{{ $producto[0]->stock }}
                                {{ $producto[0]->medida }}(s)</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 mt-2 d-none d-sm-none d-md-block">
                    <div class="row">
                        <div class="col-5 col-md-3">
                            @if (strlen($producto[0]->imagen) > 44)
                                {{-- Si el nombre de la imagen mide mas de 44 caracteres entonces imagen --}}
                                <img src="{{ $producto[0]->imagen }}" class="img-fluid border" alt="Logo">
                            @else
                                <h2 class="perfil-3">{{ strtoupper(substr($producto[0]->nombre, 0, 1)) }}</h2>
                            @endif
                        </div>
                        <div class="vl col-1 d-flex justify-content-center"></div>
                        <div class="col-5 col-md-12 col-lg-7">
                            <div class="row">
                                <a href="javascript: void(0)">{{ $producto[0]->nombre }}</a>
                            </div>
                            <div class="row mt-1">
                                <a href="javascript: void(0)">
                                    <i class="fa-solid fa-star estrellaCrrito-yellow text-center col-2"></i></a>
                                <a href="javascript: void(0)">
                                    <i class="fa-solid fa-star estrellaCrrito-yellow text-center col-2"></i></a>
                                <a href="javascript: void(0)">
                                    <i class="fa-solid fa-star estrellaCrrito-yellow text-center col-2"></i></a>
                                <a href="javascript: void(0)">
                                    <i class="fa-solid fa-star estrellaCrrito-yellow text-center col-2"></i></a>
                                <a href="javascript: void(0)">
                                    <i class="fa-solid fa-star estrellaCrrito-yellow text-center col-2"></i></a>
                            </div>
                            <div class="row">
                                <p class="text-1">(0) Opiniones</p>
                                <p class="text-1">(0) Productos</p>
                            </div>
                        </div>
                    </div>
                    <div class="separator mt-3"></div>
                    <div class="row m-3">
                        <button type="button" class="btn bg-white d-flex align-items-center" data-toggle="modal"
                            data-target="#exampleModaPreguntas" style="border: 0;" id="btn-ver-preguntas">
                            <i class="fa-solid fa-message text-10"></i>
                            <span class="text-mensaje">Ver preguntas</span>
                        </button>
                    </div>
                </div>
                <div class="separator"></div>
                <div class="col-12 col-md-6">
                    <div class="row d-flex align-items-center ml-1 mt-4">
                        <div class="col-12 col-md-6 ">
                            <p class="text-2">Precio unitario</p>
                            <input type="hidden" id="el_precio_unitario" value="{{ $producto[0]->precio_unitario }}">
                            <p class="text-precio-mayoreo-gold">${{ number_format($producto[0]->precio_unitario, 2) }}</p>
                            <input type="hidden" id="unidad_medida" value="{{ $producto[0]->medida }}">
                            <p class="text-2">x 1 {{ $producto[0]->medida }}</p>
                        </div>
                    </div>
                    <div class="row mt-2 ml-3">
                        <p class="text-2"><strong>Vigencia del precio: </strong>{{ $producto[0]->vigencia }} días</p>
                    </div>
                    <div class="row ml-1">
                        <div class="form-group col-md-7 col-lg-8 mt-3">
                            <label for="inputState" class="titel-2">Color</label>
                            <select id="inputState" class="form-control">
                                @if ($producto[0]->color != null)
                                    @foreach ($producto[0]->color as $key => $item)
                                        <option value="{{ $key }}">{{ strtoupper($item->el_color) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="row ml-1">
                            <div class="form-group col-md-10 col-sm-12">
                                <label for="inputCity" class="titel-2">Tamaño</label>
                                <input type="text" class="form-control"
                                    value="{{ strtoupper($producto[0]->tamanio) }}" disabled>
                            </div>
                        </div>

                        <div class="row ml-1">
                            <div class="form-group col-md-10 col-sm-12">
                                <label for="inputCity" class="titel-2">Cantidad</label>
                                <div class="d-flex align-items-center">
                                    <a href="javascript:void(0)" id="btn_decremento">
                                        <i class="fa-solid fa-circle-minus arena mr-2"></i>
                                    </a>
                                    <input type="text" class="form-control text-center" id="txt_cantidad"
                                        value="1" readonly>
                                    <a href="javascript:void(0)" id="btn_incremento">
                                        <i class="fa-solid fa-circle-plus arena ml-3"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2 ml-1">
                            <div class="col-12">
                                <a href="javascript: void(0)">
                                    <i class="fa-regular fa-heart like-gold"></i>
                                    <span class="text-1 ml-3">Agregar a favoritos</span>
                                </a>
                            </div>
                            <div class="col-12 mt-2">
                                <a href="javascript: void(0)">
                                    <i class="fa-solid fa-share-nodes text-gold"></i>
                                    <span class="text-1 ml-3">Compartir</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección carrito -->
                <div class="col-12 col-md-6 mt-3 d-none d-sm-none d-md-block">
                    <div class="card bg-light">
                        <div class="card-body">
                            <p class="titel-2 ">Desglose de precios</p>
                            <div class="row mt-3">
                                <div class="col-12 col-md-6">
                                    <p class="card-text text-1" id="el_desglose"></p>
                                </div>
                                <div class="col-12 col-md-6">
                                    <p class="desg-precios" id="el_precio">${{ number_format(0, 2) }}</p>
                                </div>
                            </div>

                            <p class="titel-2  mt-3">Tiempo de entrega</p>
                            @php $unidadesDias = [ "días", "semanas", "meses" ]; @endphp
                            @if ($producto[0]->temporalidad != '')
                                <p class="text-1">{{ $producto[0]->tiempo_entrega }}
                                    {{ $unidadesDias[$producto[0]->temporalidad] }} hábiles</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 mx-5" id="punto-encuentro-preguntas">
        <div class="col-5">
            <p class="titel-2 ">Preguntas <span class="badge badge-light border mb-2" id="cantidad_preguntas">2</span>
            </p>
        </div>
        <hr>
    </div>

    <div class="row mt-3 mx-5 justify-content-center">
        <div class="col-12" style="height: 500px; overflow-y: scroll;" id="area_preguntas_respuestas">
        </div>
    </div>

    <!-- Aqui termina ver carrito -->

    <div class="col-12 col-md-6 mt-3 d-sm-block d-md-none mt-3 fixed-bottom">
        <div class="card bg-light">
            <div class="card-body">
                <p class="titel-2 ">Desglose de precios</p>
                <div class="row mt-3">
                    <div class="col-12 col-md-6">
                        <p class="card-text text-1" id="el_desglose_abajo"></p>
                    </div>
                    <div class="col-12 col-md-6">
                        <p class="desg-precios" id="el_precio_abajo">${{ number_format(0, 2) }}</p>
                    </div>
                </div>

                <p class="titel-2  mt-3">Tiempo de entrega</p>
                @php $unidadesDias = [ "días", "semanas", "meses" ]; @endphp
                @if ($producto[0]->temporalidad != '')
                    <p class="text-1">{{ $producto[0]->tiempo_entrega }} {{ $unidadesDias[$producto[0]->temporalidad] }}
                        hábiles</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Termina desgloce de precios -->

    <div class="col-12 col-md-6 mt-2 d-block d-sm-block d-md-none mt-3">
        <div class="row d-flex align-items-center">
            <div class="col-5">
                @php $fotoMini = ''; @endphp
                @foreach ($nombreFotos as $nombre)
                    @if ($producto[0]->$nombre != null)
                        @php
                            $fotoMini = $producto[0]->$nombre;
                            break;
                        @endphp
                    @endif
                @endforeach

                <img src="{{ asset('storage/img-producto-pfp/' . $fotoMini) }}" class="img-fluid border" alt="logo">
            </div>
            <div class="vl col-1 d-flex justify-content-center"></div>
            <div class="col-5">
                <div class="row mt-3">
                    <p class="text-1">{{ strtoupper($producto[0]->marca) }}</p>
                </div>
                <div class="row mt-1">
                    <a href="#"><i class="fa-solid fa-star estrellaCrrito-yellow text-center col-2"></i></a>
                    <a href="#"><i class="fa-solid fa-star estrellaCrrito-yellow text-center col-2"></i></a>
                    <a href="#"><i class="fa-solid fa-star estrellaCrrito-yellow text-center col-2"></i></a>
                    <a href="#"><i class="fa-solid fa-star estrellaCrrito-yellow text-center col-2"></i></a>
                    <a href="#"><i class="fa-solid fa-star estrellaCrrito-yellow text-center col-2"></i></a>
                </div>
                <div class="row mt-3">
                    <p class="text-1">(0) Opiniones</p>
                    <p class="text-1">(30) Productos</p>
                </div>
            </div>
        </div>
        <hr>
    </div>
@endsection
@routes(['proveedor_fichap'])
<script src="{{ asset('asset/js/proveedor_fp_show.js') }}" type="text/javascript" defer></script>
