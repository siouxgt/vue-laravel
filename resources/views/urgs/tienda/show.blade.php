@extends('layouts.urg')

@section('content')

<div class="col-12 mt-3">
    <h1 class="ml-4 nombre-prod"><strong>{{ strtoupper($producto[0]->nombre_corto) }}</strong></h1>
    <!-- -----Información------- -->
    <div class="row col-12 col-md-12 d-flex text-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-1">
                <li class="breadcrumb-item"><a href="javascript: void(0)">Inicio</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Contratos Marco</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">{{ strtoupper($producto[0]->nombre_producto) }}</a></li>
            </ol>
        </nav>
    </div>
</div>
<hr>

<!-- -----Alerta 1------- -->
@if(!$participacion->existe)
<div class="container  alert-dismissible fade show d-flex justify-content-center" role="alert">
    <div class="d-flex align-items-center alert alert-warning col-8">
        <div class="bg-amarillo mr-3">
            <i class="fa-solid fa-triangle-exclamation"></i
>        </div>
        <strong class="text-aler-amarillo">No se encontró Requisición para este producto. Sólo está disponible la función agregar a “Favoritos”</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
@endif

<input type="hidden" value="{{$producto[0]->cabms}}" id="participacion">
<!-- -----Alerta 1------- -->

<div class="row justify-content-center" style="margin: 0;">
    <div class="col-12 col-md-12 col-lg-6 mt-3 ">
        <div class="mt-3">
            <!-- -----Información------- -->
            <div class="row justify-content-end float-right mb-4 col-md-6 col-12 mt-3">
                @if ($producto[0]->nuevo)
                    <p class="badge-secondary ml-3">Nuevo</p>
                @else
                    <div class="mt-3"> </div>
                @endif
            </div>
             @php
                $fotos = [$producto[0]->foto_uno, $producto[0]->foto_dos, $producto[0]->foto_tres, $producto[0]->foto_cuatro, $producto[0]->foto_cinco, $producto[0]->foto_seis];
                $contador = 0;
                $total = 0;
                $quienClic = 0;
            @endphp
            @for($j = 0; $j < 6; $j++ )
                @if($fotos[$j] != null)
                    @php 
                        $total++; 
                    @endphp
                @endif
            @endfor
            @for($i = 0; $i < 6; $i++)
                @if($fotos[$i]  != null)
                    @php 
                        $contador++;
                    @endphp
                    <div class="mySlides mt-4">
                        <div class="numbertext">{{ $contador . '/' . $total }}</div>
                        <img src="{{ asset('storage/img-producto-pfp/'.$fotos[$i]) }}" class="zoom">
                    </div>                    
                @endif 
            @endfor

            <a class="prev-photo" onclick="plusSlides(-1)">❮</a>
            <a class="next-photo" onclick="plusSlides(1)">❯</a>

            <div class="row mt-3 d-flex justify-content-center">
               @for($k = 0; $k < 6; $k++)
                    @if($fotos[$k]  != null)
                        @php 
                            $quienClic++;
                        @endphp
                         <div class="column">
                            <img class="demo cursor" src="{{ asset('storage/img-producto-pfp/'.$fotos[$k]) }}" style="width:50%" onclick="currentSlide({{ $quienClic }})" alt="">
                        </div>                 
                    @endif 
                @endfor
            </div>
        </div>

        <div class="col-12 col-md-6 d-block d-sm-block d-md-none">
            <span class="text-1 font-weight-bold ml-2">{{ strtoupper($producto[0]->marca) }}</span>
            <p class="text-10 ml-2">{{ strtoupper($producto[0]->nombre_producto) }}</p>
            <div class="col-12 col-md-12 col-lg-auto mt-3">
                <div style="overflow-x: auto;" class="">
                    <p class="text-2"><strong>Modelo: </strong> @if($producto[0]->modelo != '' || $producto[0]->modelo != null){{ strtoupper($producto[0]->modelo) }}@else NO ESPECIFICADO @endif</p>
                    <p class="text-2"><strong>Material: </strong>{{ strtoupper($producto[0]->material) }}</p>
                    @if($producto[0]->composicion != '' || $producto[0]->composicion != null)
                    <p class="text-2"><strong>Composición:</strong> {{ strtoupper($producto[0]->composicion) }}</p>
                    @endif
                    <p class="text-2"><strong>Mínimo de venta: </strong> {{ $producto[0]->unidad_minima_venta }} {{ $producto[0]->medida }}(s)</p>
                    <input type="hidden" id="stock_disponible" value="{{ $producto[0]->stock }}">
                    <input type="hidden" id="cantidad_producto" value="{{ $producto[0]->cantidad_producto }}">
                    <p class="text-2"><strong>Stock disponible: </strong>{{ $producto[0]->stock }} {{ $producto[0]->medida }}(s)</p>
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
                <input type="hidden" id="la_cabms" value="{{ $producto[0]->cabms }}">
                @if($producto[0]->sku != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Código de barras</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ strtoupper($producto[0]->sku) }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->fabricante != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Fabricante</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ strtoupper($producto[0]->fabricante) }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->pais_origen != null)
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
                    <div class="col-5">
                        <p class="text-1"><strong>Dimensiones</strong></p>
                    </div>
                    <div class="col-7">
                        @php
                        $unidadesMedidaLongitud = [ "m.", "cm.", "mm." ];
                        $unidadesMedidaPeso = [ "t.", "kg.", "g." ];
                        $cadena_dimensiones = "";
                        @endphp
                        @if($producto[0]->dimensiones != null)
                        @php
                        $cadena_dimensiones .= "LARGO: " . $producto[0]->dimensiones[0]->largo . " " . $unidadesMedidaLongitud[$producto[0]->dimensiones[0]->unidad_largo] . ", ";
                        $cadena_dimensiones .= "ANCHO: " . $producto[0]->dimensiones[0]->ancho . " " . $unidadesMedidaLongitud[$producto[0]->dimensiones[0]->unidad_ancho] . ", ";
                        $cadena_dimensiones .= "ALTO: " . $producto[0]->dimensiones[0]->alto . " " . $unidadesMedidaLongitud[$producto[0]->dimensiones[0]->unidad_alto] . ", ";
                        $cadena_dimensiones .= "PESO: " . $producto[0]->dimensiones[0]->peso . " " . $unidadesMedidaPeso[$producto[0]->dimensiones[0]->unidad_peso];
                        @endphp
                        @endif
                        <p class="text-1">{{ $cadena_dimensiones }}</p>
                    </div>
                </div>
                @if($producto[0]->grado_integracion_nacional != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Grado de integración nacional</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ $producto[0]->grado_integracion_nacional }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->presentacion != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Presentación</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ strtoupper($producto[0]->presentacion) }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->disenio != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Diseño</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ strtoupper($producto[0]->disenio) }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->acabado != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Acabado</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ strtoupper($producto[0]->acabado) }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->forma != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Forma</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ strtoupper($producto[0]->forma) }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->aspecto != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Aspecto</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ strtoupper($producto[0]->aspecto) }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->etiqueta != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Etiqueta</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ strtoupper($producto[0]->etiqueta) }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->envase != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Envase</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ strtoupper($producto[0]->envase) }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->empaque != null)
                <div class="row">
                    <div class="col-5">
                        <p class="text-1"><strong>Empaque</strong></p>
                    </div>
                    <div class="col-7">
                        <p class="text-1">{{ strtoupper($producto[0]->empaque) }}</p>
                    </div>
                </div>
                @endif
                @if($producto[0]->documentacion_incluida != '')
                <div class="row mt-3">
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
                    <a class="p-2" target="_blank" href="{{ route('tienda_urg.ver_doc', $producto[0]->doc_ficha_tecnica ) }}">
                        <i class="fa-regular fa-file-pdf text-gold-5"></i>
                    </a>
                </div>

                <!---------------------otros 1----------------------->
                <div class="col-6">
                    <div class="col-12 text-center">
                        @if($producto[0]->doc_adicional_uno != null || $producto[0]->doc_adicional_dos != null || $producto[0]->doc_adicional_tres != null)
                        <p class="text-2">Otros</p>
                        @endif
                    </div>
                    <div class="row mt-2 ml-4 d-flex justify-content-center">
                        @if($producto[0]->doc_adicional_uno != null)
                        <div class="col-4">
                            <a target="_blank" href="{{ route('tienda_urg.ver_doc', [$producto[0]->doc_adicional_uno, 2] ) }}">
                                <i class="fa-regular fa-file-pdf text-gold-5"></i>
                            </a>
                        </div>
                        @endif
                        @if($producto[0]->doc_adicional_dos != null)
                        <div class="col-4">
                            <a target="_blank" href="{{ route('tienda_urg.ver_doc', [$producto[0]->doc_adicional_dos, 2] ) }}">
                                <i class="fa-regular fa-file-pdf text-gold-5"></i>
                            </a>
                        </div>
                        @endif
                        @if($producto[0]->doc_adicional_tres != null)
                        <div class="col-4">
                            <a target="_blank" href="{{ route('tienda_urg.ver_doc', [$producto[0]->doc_adicional_tres, 2] ) }}">
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
                        <p class="text-2"><strong>Modelo: </strong> @if($producto[0]->modelo != '' || $producto[0]->modelo != null){{ strtoupper($producto[0]->modelo) }}@else NO ESPECIFICADO @endif</p>
                        <p class="text-2"><strong>Material: </strong>{{ strtoupper($producto[0]->material) }}</p>
                        @if($producto[0]->composicion != '' || $producto[0]->composicion != null)
                        <p class="text-2"><strong>Composición:</strong> {{ strtoupper($producto[0]->composicion) }}</p>
                        @endif
                        <p class="text-2"><strong>Mínimo de venta: </strong>{{ $producto[0]->unidad_minima_venta }} {{ $producto[0]->medida }}(s)</p>
                        <p class="text-2"><strong>Stock disponible: </strong>{{ $producto[0]->stock }} {{ $producto[0]->medida }}(s)</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mt-2 d-none d-sm-none d-md-block">
                <div class="row">
                    <div class="col-5 col-lg-auto">
                        @if( $producto[0]->imagen_prove)
                        <img src="{{ env('TIANGIS_URL') }}{{ $producto[0]->imagen_prove}}" class="img-fluid border" alt="Logo">
                        @else
                        <img src="{{ asset('asset/img/sin_imag_100.png') }}" class="img-fluid border" alt="Logo">
                        @endif
                    </div>
                    <div class="vl col-auto d-flex justify-content-center"></div>
                    <div class="col-5">
                        <div class="row text-center">
                            <input type="hidden" id="nombre_empresa" value="{{ $producto[0]->nombre_prove }}">
                            <a href="javascript: void(0)" id="buscar_empresa">{{ $producto[0]->nombre_prove }}</a>
                        </div>
                        <div class="row mt-1" style="width: 85%; margin-left: auto; margin-right: auto;">
                            <a href="{{ route('tienda_urg.opinion_proveedor',['proveedor' => $producto[0]->proveedor_id_e]) }}">
                                @for($i = 1; $i <= 5; $i++ )
                                    @if($producto[0]->calificacion_proveedor)
                                        @php 
                                            $restanteProve = (($producto[0]->calificacion_proveedor / $producto[0]->total_evaluaciones_proveedor) - intval($producto[0]->calificacion_proveedor / $producto[0]->total_evaluaciones_proveedor)) *100;
                                        @endphp
                                        @if($i <= intval($producto[0]->calificacion_proveedor / $producto[0]->total_evaluaciones_proveedor))
                                            <i class='fa-solid fa-star estrella active'></i>
                                            @if($restanteProve >= 50 && $i == intval($producto[0]->calificacion_proveedor / $producto[0]->total_evaluaciones_proveedor))
                                                <i class='fa-solid fa-star-half-stroke estrella active'></i>
                                                @php $i++; @endphp
                                            @endif
                                        @else
                                            <i class="fa-solid fa-star estrella"></i>
                                        @endif
                                    @else
                                        <i class="fa-solid fa-star estrella"></i>
                                    @endif
                                @endfor
                            </a>
                        </div>
                        <div class="row mt-3 text-center">
                            <p class="text-1">{{ $opinionesProveedor }} Opiniones</p>                            
                        </div>
                        <div class="row text-center">
                            <p class="text-1">{{ $countProductos->productos }} Productos</p>
                        </div>                        
                    </div>
                </div>
                <div class="separator mt-3"></div>
                <div class="row m-3">
                    <button type="button" class="btn bg-white d-flex align-items-center" data-toggle="modal" data-target="#exampleModaPreguntas" style="border: 0;" id="saltar_a">
                        <i class="fa-solid fa-message text-10"></i>
                        <p class="text-mensaje">Enviar mensaje</p>
                    </button>
                </div>
            </div>
            <div class="separator"></div>
            <div class="col-12 col-md-6">
                <div class="row d-flex align-items-center ml-1 mt-4">
                    <div class="col-12 col-md-6 col-lg-auto">
                        <p class="text-2"><strong>Precio unitario</strong></p>
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
                        <select id="select_colores" class="form-control">
                            @if($producto[0]->color != null)
                            @foreach($producto[0]->color as $key => $item)
                            <option value="{{ $item->el_color }}">{{ strtoupper($item->el_color) }}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="row ml-1">
                        <div class="form-group col-md-10 col-sm-12">
                            <label for="inputCity" class="titel-2">Tamaño</label>
                            <input type="text" class="form-control" value="{{ strtoupper($producto[0]->tamanio) }}" disabled>
                        </div>
                    </div>

                    <div class="row ml-1">
                        <div class="form-group col-md-10 col-sm-12">
                            <label for="inputCity" class="titel-2">Cantidad</label>
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0)" id="btn_decremento">
                                    <i class="fa-solid fa-circle-minus arena mr-2"></i>
                                </a>
                                <input type="text" class="form-control text-center" id="txt_cantidad" value="1">
                                <a href="javascript:void(0)" id="btn_incremento">
                                    <i class="fa-solid fa-circle-plus arena ml-3"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 ml-1">
                        <div class="col-12">
                            <input type="hidden" id="es_favorito" value="{{$producto[0]->id_favorito ? true : false}}">
                            <input type="hidden" id="id_favorito" value="{{$producto[0]->id_favorito}}">
                            <a href="javascript: void(0)" id="btn_agregar_favoritos">
                                <i class="@if($producto[0]->id_favorito) fa-solid @else fa-regular @endif fa-heart like-gold" id="corazon_favorito"></i>
                                <span class="text-1 ml-3" id="titulo_favoritos">@if($producto[0]->id_favorito) Quitar de favoritos @else Agregar a favoritos @endif</span>
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
                            <div class="col-12 col-md-6 col-lg-auto">
                                <p class="card-text text-1" id="el_desglose"></p>
                            </div>
                            <div class="col-12 col-md-6 col-lg-auto">
                                <p class="desg-precios" id="el_precio">${{ number_format(0, 2) }}</p>
                            </div>
                        </div>

                        <p class="titel-2  mt-3">Tiempo de entrega</p>
                        @php $unidadesDias = [ "días", "semanas", "meses" ]; @endphp
                        @if($producto[0]->temporalidad != "")
                        <p class="text-1">{{ $producto[0]->tiempo_entrega }} {{ $unidadesDias[$producto[0]->temporalidad] }} hábiles</p>
                        @endif

                        @if($participacion->existe)
                        <div class="row mt-4 bac-red rounded m-2">
                            <div class="col-12 m-2 text-center">
                                <a href="javascript: void(0)" id="btn_seleccionar_requisicion" data-toggle="modal" data-target="#exampleModalSelecReq">
                                    <p class="text-carrito text-center"><i class="fa-solid fa-cart-shopping"></i>
                                        Agregar al carrito</p>
                                </a>
                            </div>
                        </div>

                        <a href="javascript:void(0)" id="btn_ver_carrito_uno">
                            <p class="text-5 mt-2 text-center">Ver carrito</p>
                        </a>
                        @else

                        <br>
                        <a href="javascript: void(0)" class="btn btn-secondary text-carrito bac-red disabled" style="width: 100%;">
                            <i class="fa-solid fa-cart-shopping"></i>Agregar al carrito
                        </a>

                        <a href="javascript:void(0)" class="" id="btn_ver_carrito_uno">
                            <p class="text-5 mt-2 text-center">Ver carrito</p>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
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
            @if($producto[0]->temporalidad != "")
            <p class="text-1">{{ $producto[0]->tiempo_entrega }} {{ $unidadesDias[$producto[0]->temporalidad] }} hábiles</p>
            @endif

            @if($participacion->existe)
            <div class="row mt-4 bac-red rounded m-2">
                <div class="col-12 m-2 text-center">
                    <a href="javascript: void(0)" data-toggle="modal" data-target="#exampleModalSelecReq">
                        <p class="text-carrito text-center"><i class="fa-solid fa-cart-shopping"></i>
                            Agregar al carrito</p>
                    </a>
                </div>
            </div>

            <a href="javascript:void(0)">
                <p class="text-5 mt-2 text-center">Ver carrito</p>
            </a>
            @else
            <br>
            <div class="row mt-4 bac-red rounded m-2">
                <div class="col-12 m-2 text-center">
                    <a href="javascript: void(0)" id="btn_seleccionar_requisicion" data-toggle="modal" data-target="#exampleModalSelecReq">
                        <p class="text-carrito text-center"><i class="fa-solid fa-cart-shopping"></i>
                            Agregar al carrito
                        </p>
                    </a>
                </div>
            </div>
            <a href="javascript:void(0)" class="disabled">
                <p class="text-5 mt-2 text-center">Ver carrito</p>
            </a>
            @endif

        </div>
    </div>
</div>

<!-- Termina desgloce de precios -->

<div class="col-12 col-md-6 mt-2 d-block d-sm-block d-md-none mt-3">
    <div class="row d-flex align-items-center">
        <div class="col-5">
            @if($producto[0]->foto_uno != null)
            <img src="{{ asset('storage/img-producto-pfp/'.$producto[0]->foto_uno) }}" class="img-fluid border" alt="logo">
            @endif
        </div>
        <div class="vl col-1 d-flex justify-content-center"></div>
        <div class="col-5">
            <div class="row mt-3">
                <p class="text-1">{{ strtoupper($producto[0]->marca) }}</p>
            </div>
            <div class="row mt-1">
                 @for($i = 1; $i <= 5; $i++ )
                    @if($producto[0]->calificacion)
                        @php 
                            $restante = (($producto[0]->calificacion / $producto[0]->total_evaluaciones) - intval($producto[0]->calificacion / $producto[0]->total_evaluaciones)) *100;
                        @endphp
                        @if($i <= intval($producto[0]->calificacion / $producto[0]->total_evaluaciones))
                            <i class='fa-solid fa-star estrella active'></i>
                            @if($restante >= 50 && $i == intval($producto[0]->calificacion / $producto[0]->total_evaluaciones))
                                <i class='fa-solid fa-star-half-stroke estrella active'></i>
                                @php $i++; @endphp
                            @endif
                        @else
                            <i class="fa-solid fa-star estrella"></i>
                        @endif
                    @else
                        <i class="fa-solid fa-star estrella"></i>
                    @endif
                @endfor
            </div>
            <div class="row mt-3">
                <p class="text-1">{{ count($opiniones) }} Opiniones</p>
                <p class="text-1">{{ $countProductos->productos }} Productos</p>
            </div>
        </div>
    </div>
    <hr>
</div>
<br>
<br>

<div class="section mt-3 mx-5">
    <div class="row">
        <div class="col-6">
            <p class="titel-2 ">Preguntas <span class="badge badge-light border mb-2" id="cantidad_preguntas"></span></p>
        </div>
        <div class="col-6 float-right">
            <input type="hidden" name="pfp_id" id="pfp_id" value="{{$producto[0]->id_e}}">
            <button type="button" class="btn bg-white d-flex align-items-center" id="btn_enviar_preguntas" data-toggle="modal" data-target="#exampleModaPreguntas" style="border: 0;">
                <i class="fa-solid fa-message text-10"></i>
                <p class="text-mensaje">Enviar mensaje</p>
            </button>
        </div>
    </div>
    <hr>
    <!-- </div> -->

    <section class="ml-2" id="area_preguntas_respuestas">

    </section>

    <!-- </div> -->
</div>

<div class="row" id="area_btn_ver_preguntas">
</div>

<!-- The slideshow 2-->
<div class="section mt-3 mx-5">
    <br>
    <hr>
    <p class="text-1 font-weight-bold">Productos relacionados</p>
</div>

<br>

<div class="text-center" style="width: 85%; margin-left: auto; margin-right: auto;">
    <div class="row mx-auto my-auto">
        <div id="myCarousel" class="carousel slide carousel-multi-item w-100 text-center" data-ride="carousel">
            <div class="carousel-inner w-500" role="listbox">
                {!!$contenido!!}
            </div>
            <a class="carousel-control-prev  w-auto" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next  w-auto" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>


<!-- 
<div id="elCarusel" class="carousel slide" data-ride="carousel">
</div> -->

<br>

<!-- -------opiniones---------- -->
<div class="section mt-3 mx-5">
    <hr>
    <p class="text-1 font-weight-bold">Opiniones del producto</p>
    <div class="row">
        <div class="col-md-2 col-sm-9">
            <p class="text-11 mt-2">@if($producto[0]->calificacion) {{ $producto[0]->calificacion / $producto[0]->total_evaluaciones }} @else 0 @endif / 5</p>
            <div class="col-sm-4 col-md-12 col-gl-12 mt-2 d-flex justify-content-start" style="margin-left: -20px;">
                @for($i = 1; $i <= 5; $i++ )
                    @if($producto[0]->calificacion)
                        @php 
                            $restante = (($producto[0]->calificacion / $producto[0]->total_evaluaciones) - intval($producto[0]->calificacion / $producto[0]->total_evaluaciones)) *100;
                        @endphp
                        @if($i <= intval($producto[0]->calificacion / $producto[0]->total_evaluaciones))
                            <i class='fa-solid fa-star estrella active'></i>
                            @if($restante >= 50 && $i == intval($producto[0]->calificacion / $producto[0]->total_evaluaciones))
                                <i class='fa-solid fa-star-half-stroke estrella active'></i>
                                @php $i++; @endphp
                            @endif
                        @else
                            <i class="fa-solid fa-star estrella"></i>
                        @endif
                    @else
                        <i class="fa-solid fa-star estrella"></i>
                    @endif
                @endfor
            </div>
            <div class="mt-2">
                <p class="text-2">Basado en {{ count($opiniones) }} opiniones</p>
            </div>

        </div>

        <div class="row col-md-9 col-sm-6 border-left ml-3">
            
            @forelse($opiniones as $key => $opinion)
                <div class="col-sm-9 col-md-4 col-lg-2 mt-4 d-flex justify-content-start">
                    @for($i = 1; $i <= 5; $i++ )
                        @if($opinion->calificacion)
                            @if($i <= $opinion->calificacion)
                                <i class='fa-solid fa-star estrella active'></i>
                            @else
                                <i class="fa-solid fa-star estrella"></i>
                            @endif
                        @else
                            <i class="fa-solid fa-star estrella"></i>
                        @endif
                    @endfor
                </div>
                <div class="col-sm-12 col-md-8 col-lg-10 mt-4">
                    <div>
                        <p class="text-1 mt-1">
                            {{ $opinion->comentario }}
                        </p>
                    </div>
                    <div class="mt-3">
                        <p class="text-1 font-weight-bold">
                            {{ $opinion->nombre }}
                        </p>
                        <p class="text-2">{{ $opinion->fecha_creacion }}</p>
                    </div>
                    <hr>
                </div>

                @break($key == 5)
                @empty
                    <div class="col-sm-12 col-md-12 col-lg-12 mt-2">
                        <p class="text-1">Sin Opiniones</p>
                    </div>
            @endforelse


            <div class="row">
                <div class="ml-4 mt-4 gold-3">
                    <a href="{{ route('tienda_urg.opinion_producto', ['producto' => $producto[0]->id_e]) }}">Ver todas las opiniones <i class="fa-solid fa-chevron-right ml-2 gold-3"></i> </a>
                </div>
            </div>

        </div>


    </div>
</div>
<!-- -------opiniones---------- -->

@endsection
@section('js')
@routes(['tiendaUrg', 'carritoCompra', 'productosPreguntasRespuestas', 'requisiciones', 'pfu'])
<script src="{{ asset('asset/js/tienda_urg.js') }}" type="text/javascript"></script>
<script src="{{ asset('asset/js/tienda_urg_show.js') }}" type="text/javascript"></script>
@endsection