@extends('layouts.admin')

@section('content')

    <div class="row d-flex align-items-center">
        <div class="col-6 mt-4 d-flex">
            <a href="{{ route('producto_admin.index') }}" class="back">
                <span class="text-gold-1 float-right">Regresar</span>
            </a>
        </div>
    </div>
    
    <div class="separator"></div>    
    <!-- -----Información------- -->
    <div class="row">
        <div class="col-12 col-md-8 d-flex">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mt-1">
                    <li class="gris">{{ strtoupper($producto->numero_ficha) }}</li>
                    <li class="gris">&nbsp;&nbsp;-&nbsp;&nbsp;{{ strtoupper($producto->cabms) }} | {{ strtoupper($producto->descripcion) }}</li>
                    <li class="gris">&nbsp;&nbsp;-&nbsp;&nbsp; Versión {{ $producto->version }}</li>
                </ol>
            </nav>
        </div>
        <div class="col-12 col-md-4  mt-1">
            <span class="gris">Última edición: {{ \Carbon\Carbon::parse($producto->updated_at)->format('d/m/Y') }}</span>
        </div>
    </div>
    <!-- -----Información------- -->

    <div class="row justify-content-center">
        <input type="hidden" id="producto" value="{{ $producto->id_e}}">
    <div class="col-12 col-md-12 col-lg-5 ">

        <div class="mt-3">
            <div class="row justify-content-end float-right mb-4 col-md-6 col-12 mt-3">
                @if(\Carbon\Carbon::parse($producto->created_at)->diffInDays(now()) < 90)
                    <p class="porLiberar">Nuevo</p>
                @endif
            </div>
            @php
                $fotos = [$producto->foto_uno, $producto->foto_dos, $producto->foto_tres, $producto->foto_cuatro, $producto->foto_cinco, $producto->foto_seis];
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

            <div class="row mt-3">
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
        <div class="col-12 mt-3">
            <p class="titel-2">Descripción</p>
        </div>
        <div class="separator col-12 col-md-8"></div>
        <div class="col-12 col-md-8 mt-3">
            <p class="text-1">{{ strtoupper($producto->descripcion_producto) }}</p>
        </div>
        <br>
        <div class="col-12 mt-3">
            <p class="titel-2">Otras características</p>
        </div>
        <div class="separator col-12 col-md-8"></div>
        <div class="col-12 col-md-12 col-lg-8">
            <div style="overflow-x: auto;">
                <p class="text-2 mt-2"><strong>Código de barras</strong> {{ strtoupper($producto->sku) }}</p>
                <p class="text-2 mt-2"><strong>Fabricante</strong> {{ strtoupper($producto->fabricante) }}</p>
                @php
                    $unidadesMedidaLongitud = [ "m.", "cm.", "mm." ];
                    $unidadesMedidaPeso = [ "t.", "kg.", "g." ];
                    $cadena_dimensiones = '';
                @endphp
                @if($producto->dimensiones != null)
                    @php
                        $cadena_dimensiones = "Largo: " . $producto->dimensiones[0]->largo . " " . $unidadesMedidaLongitud[$producto->dimensiones[0]->unidad_largo] . ", ";
                        $cadena_dimensiones .= " Ancho: " . $producto->dimensiones[0]->ancho . " " . $unidadesMedidaLongitud[$producto->dimensiones[0]->unidad_ancho] . ", ";
                        $cadena_dimensiones .= " Alto: " . $producto->dimensiones[0]->alto . " " . $unidadesMedidaLongitud[$producto->dimensiones[0]->unidad_alto] . ", ";
                        $cadena_dimensiones .= " Peso: " . $producto->dimensiones[0]->peso . " " . $unidadesMedidaPeso[$producto->dimensiones[0]->unidad_peso];
                    @endphp
                @endif
                <p class="text-2 mt-2"><strong>Dimensiones</strong> {{ $cadena_dimensiones }}</p>
                <p class="text-2 mt-2"><strong>Empaque</strong> {{ $producto->empaque }}</p>
                <p class="text-2 mt-2"><strong> Grado de integración nacional</strong> {{ $producto->grado_integracion_nacional }}</p>
                <p class="text-2 mt-2"><strong> Documentación incluida a la entrega</strong> 
                    @foreach($producto->documentacion_incluida[0] as $key => $value) 
                        @if($value == 1)
                            {{ $key }},
                        @endif
                    @endforeach
                </p>
            </div>
        </div>
        <div class="col-12 mt-3">
            <p class="titel-2">Información complementaria</p>
        </div>
        <div class="separator col-12 col-md-8"></div>
        <div class="row m-3 col-ms-3">
            <div class="col-3 text-center">
                <p class="text-2">Ficha técnica</p>
                <a class="btn btn-cdmx" target="_blank" href="{{ route('proveedor_fp.ver_doc', $producto->doc_ficha_tecnica ) }}">
                    <i class="fa-regular fa-file-pdf text-gold-5"></i>
                </a>
            </div>
            <div class="col-6 text-center">
                @if($producto->doc_adicional_uno != null || $producto->doc_adicional_dos != null || $producto->doc_adicional_tres != null)
                    <p class="text-2">Otros</p>
                @endif
                @if($producto->doc_adicional_uno != null)
                    <a class="btn btn-cdmx" target="_blank" href="{{ route('proveedor_fp.ver_doc', [$producto->doc_adicional_uno, 1] ) }}">
                        <i class="fa-regular fa-file-pdf text-gold-5"></i>
                    </a>
                @endif
                @if($producto->doc_adicional_dos != null)
                    <a class="btn btn-cdmx" target="_blank" href="{{ route('proveedor_fp.ver_doc', [$producto->doc_adicional_dos, 2] ) }}">
                        <i class="fa-regular fa-file-pdf text-gold-5"></i>
                    </a>
                @endif
                @if($producto->doc_adicional_tres != null)
                    <a class="btn btn-cdmx" target="_blank" href="{{ route('proveedor_fp.ver_doc', [$producto->doc_adicional_tres, 4] ) }}">
                        <i class="fa-regular fa-file-pdf text-gold-5"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-5">
        <div class="row">
            <div class="col-12 col-md-6">
                <span class="text-gold ml-2">{{ strtoupper($producto->marca) }}</span>
                <p class="text-rojo-titulo ml-2">{{ strtoupper($producto->nombre_producto) }}</p>
                <div class="col-12 col-md-12 col-lg-12 mt-3 mb-2">
                    <div style="overflow-x: auto;" class="">
                        <p class="text-2"><strong>Modelo:</strong> {{ strtoupper($producto->modelo) }}</p>
                        <p class="text-2"><strong>Material:</strong> {{ strtoupper($producto->material) }}</p>
                        <p class="text-2"><strong>Mínimo de venta:</strong> {{ $producto->unidad_minima_venta }} {{ $producto->medida }}(s)</p>
                        <p class="text-2"><strong>Stock disponible:</strong> {{ $producto->stock }} {{ $producto->medida }}(s)</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mt-2">
                <div class="row">
                    <div class="col-5">
                        
                        @if($producto->imagen_prove != null)
                            <img src="{{ $producto->imagen_prove }}" class="img-fluid border" alt="logo">
                        @endif
                    </div>
                    <div class="vl col-1 d-flex justify-content-center"></div>
                    <div class="col-5">
                        <div class="row mt-3">
                            <p class="text-gold">{{ strtoupper($producto->nombre_prove) }}</p>
                        </div>
                        <div class="row mt-3">
                             <a href="{{ route('producto_admin.opinion_proveedor',['proveedor' => $producto->proveedor_id_e]) }}">
                                @for($i = 1; $i <= 5; $i++ )
                                    @if($producto->calificacion_proveedor)
                                        @php 
                                            $restanteProve = (($producto->calificacion_proveedor / $producto->total_evaluaciones_proveedor) - intval($producto->calificacion_proveedor / $producto->total_evaluaciones_proveedor)) *100;
                                        @endphp
                                        @if($i <= intval($producto->calificacion_proveedor / $producto->total_evaluaciones_proveedor))
                                            <i class='fa-solid fa-star estrella active'></i>
                                            @if($restanteProve >= 50 && $i == intval($producto->calificacion_proveedor / $producto->total_evaluaciones_proveedor))
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
                {{-- <div class="separator mt-3"></div> --}}
            </div>
            <div class="separator"></div>
            <div class="col-12 col-md-6">
                <div class="row d-flex align-items-center ml-1 mt-4">
                    <div class="col-12 col-md-6 ">
                        <p class="text-2">Precio unitario</p>
                        <input type="hidden" id="el_precio_unitario" value="{{ $producto->precio_unitario }}">
                        <p class="text-precio-mayoreo-gold">${{ number_format($producto->precio_unitario, 2) }}</p>
                        <input type="hidden" id="unidad_medida" value="{{ $producto->medida }}">
                        <p class="text-2">x 1 {{ $producto->medida }}</p>
                    </div>
                </div>
                <div class="row mt-2 ml-3">
                    <p class="text-2"><strong>Vigencia del precio:</strong> {{ $producto->vigencia }} días</p>
                </div>
                <div class="row ml-1">
                    <div class="form-group col-md-7 col-lg-8 mt-3">
                        <label for="inputState" class="titel-2">Color</label>
                        <select id="inputState" class="form-control">
                            @if($producto->color != null)
                                @foreach($producto->color as $key => $item)
                                    <option value="{{ ($key) }}">{{ strtoupper($item->el_color) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>


                <div class="row ml-1">
                    <div class="form-group col-md-7 col-lg-8 col-sm-12">
                        <label for="inputCity" class="titel-2">Tamaño</label>
                        <input type="text" class="form-control" value="{{ strtoupper($producto->tamanio) }}" disabled>
                    </div>
                </div>

                <div class="row ml-1">
                    <div class="form-group col-md-10 col-sm-12">
                        <label for="inputCity" class="titel-2">Cantidad</label>
                        <div class="d-flex align-items-center">
                            <a href="javascript:void(0)" onclick="cantidad(0)">
                                <i class="fa-solid fa-circle-minus arena mr-2"></i>
                            </a>
                            <input type="text" class="form-control col-3" id="txt_cantidad" value="1">
                            <a href="javascript:void(0)" onclick="cantidad(1)">
                                <i class="fa-solid fa-circle-plus arena ml-3"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row mt-2 ml-1">
                    <div class="col-12">
                        <a href="javascript:void(0)">
                            <i class="fa-regular fa-heart dorado"></i>
                            <span class="text-1">Agregar a favoritos</span>
                        </a>
                    </div>
                    <div class="col-12 mt-2">
                        <a href="javascript:void(0)">
                            <img src="{{ asset('asset/img/compartir.svg') }}" style="width: 5%;" alt="Agregar a favoritos">
                            <span class="text-1 ml-3">Compartir</span>
                        </a>
                    </div>
                </div>

               
            </div>

            <!-- Sección carrito -->
            <div class="col-12 col-md-6 mt-3">

                <div class="card bg-light">
                    <div class="card-body">
                        <p class="titel-2 ">Desglose de precios</p>
                        <div class="row mt-3">
                            <div class="col-12 col-md-6">
                                <p class="text-1" id="el_desglose"></p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="desg-precios" id="el_precio">${{ number_format(0, 2) }}</p>
                            </div>
                        </div>

                        <p class="titel-2  mt-3">Tiempo de entrega</p>
                        @php $unidadesDias = [ "días", "semanas", "meses" ]; @endphp
                        @if($producto->temporalidad != "")
                            <p class="text-1">{{ $producto->tiempo_entrega }} {{ $unidadesDias[$producto->temporalidad] }} hábiles</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>




    </div>
</div>
<div class="section mt-3 mx-5">
    <div class="row">
        <div class="col-6">
            <p class="titel-2 ">Preguntas <span class="badge badge-light border mb-2" id="cantidad_preguntas"></span></p>
        </div>
    </div>
    <hr>
    <section class="ml-2" id="area_preguntas_respuestas">
        <div class="row">
        </div>
    </section>
</div>

<div class="row" id="area_btn_ver_preguntas">
</div>

<div class="section mt-3 mx-5">
    <hr>
    <p class="text-1 font-weight-bold">Opiniones del producto</p>
    <div class="row">
        <div class="col-md-2 col-sm-9">
            <p class="text-11 mt-2">@if($producto->calificacion) {{ $producto->calificacion / $producto->total_evaluaciones }} @else 0 @endif / 5</p>
            <div class="col-sm-4 col-md-12 col-gl-12 mt-2 d-flex justify-content-start" style="margin-left: -20px;">
                @for($i = 1; $i <= 5; $i++ )
                    @if($producto->calificacion)
                        @php 
                            $restante = (($producto->calificacion / $producto->total_evaluaciones) - intval($producto->calificacion / $producto->total_evaluaciones)) *100;
                        @endphp
                        @if($i <= intval($producto->calificacion / $producto->total_evaluaciones))
                            <i class='fa-solid fa-star estrella active'></i>
                            @if($restante >= 50 && $i == intval($producto->calificacion / $producto->total_evaluaciones))
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
                    <a href="{{ route('producto_admin.opinion_producto', ['producto' => $producto->id_e]) }}">Ver todas las opiniones <i class="fa-solid fa-chevron-right ml-2 gold-3"></i> </a>
                </div>
            </div>

        </div>


    </div>
</div>
@endsection
@section('js')
    @routes(['productosPreguntasRespuestas','pro_pre'])
    <script src="{{ asset('asset/js/admin_producto_show.js') }}" type="text/javascript"></script>
@endsection