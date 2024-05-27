@extends('layouts.urg')

@section('content')

    <div class="row align-items-center head_home">
        <div class="col-md-1"></div>
        <div class="col-lg-2 col-md-4 col-sm-9 col-xs-9 text-center">
            <img src="{{ asset('asset/img/imageHomeURG.svg') }}" class="img-fluid imagen-1 mt-1">
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 text-center ">
            <p class="text-4 titulo_head_home" >
                Bienvenido a Contrato Marco
            </p>
            <p class="text-7 font-weight-bold">
                Espacio para buscar, subastar y comprar a proveedores participantes.
            </p>

            {{-- buscador en espera de funcionalidad
            <div class="row justify-content-center mb-3">
                <div class="input-group mt-3 col-6 "><i class="fa-solid fa-magnifying-glass text-9 mt-2" style="padding-left: 1px; position: absolute; z-index: 1;"></i>
                    <input type="search" class="form-control" style="background-color: #DDC9A3; color: #235B4E; border: none;" placeholder="     Clave CABMS, producto o Contrato Marco">
                    
                    <div class="input-group-append">
                        <button class="boton-1" style="border: none; border-radius: 0 5px 5px 0; ">
                            <span class="px-4">Buscar</span>
                        </button>
                    </div>
                </div>
            </div> --}}
            <div class="col-md-1"></div>
        </div>
    </div>

    <div class="row mt-4 ml-3 justify-content-center">
        <div class="col-lg-10 offset-lg-2">
            <h6 class="text-goldoc">
                Tienda en línea
            </h6>
        </div>

        @foreach($contratos as $contrato)
            <div class="col-lg-auto col-md-5 col-sm-12 m-4">
                <a href="javascript: void(0)" onclick="contrato('{{ $contrato->id_e }}','{{$contrato->nombre_cm}}')">
                    <p class="text-center text-gold">
                        Ver más <i class="fa-solid fa-arrow-right text-gold"></i>
                    </p>
                    @if($contrato->imagen != null)
                        <img src="{{ asset('storage/img-contrato/'.$contrato->imagen) }}" class="img-carrusel mt-3 contratos_home" >
                    @else
                        <h2 class="perfil-3 img-carrusel mt-3 contratos_home"><?php print(strtoupper(substr($contrato->nombre_cm, 0,1))); ?></h2>
                    @endif
                    <p class="text-14 text-center mt-2">
                        {{ $contrato->nombre_cm}}
                    </p>
                    <p class="text-1 text-center mb-3">
                        Partidas: {{ $contrato->capitulo_partida }}
                    </p>
                </a>
            </div>
        @endforeach

        <div class="vl m-5 d-none d-lg-block barra_home"></div>
        
        <div class="col-lg-auto col-md-5 col-sm-12 m-4">
            <p class="text-14 text-center">
                Todas mis compras
            </p>
            <p class="text-14 text-center contador_home">{{ $compras }}</p>
            <a href="{{ url('orden_compra') }}" class="mt-3">
                <p class="text-gold text-center mb-4">
                    Ver más <i class="fa-solid fa-arrow-right text-gold"></i>
                </p>
            </a>
        </div>
        <div class="col-lg-1 d-none d-lg-block d-xl-none"></div>
        <div class="col-lg-auto col-md-5 col-sm-12 m-4">
            <p class="text-14 text-center">
                Mis Contratos Marco
            </p>
            <p class="text-14 text-center contador_home">{{ $countContratos }}</p>
            <a href="{{ url('contrato_urg') }}" class="mt-3">
                <p class="text-gold text-center mb-4">
                    Ver más <i class="fa-solid fa-arrow-right text-gold"></i>
                </p>
            </a>
        </div>
    </div>

    <div class="row ml-5">
        <div class="col-auto">
            <p class="text-14 ">Productos más comprados</p>
        </div>
        <div class="col-8 d-none d-lg-block d-md-block">
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-7 ml-5 mb-5">
            <div class="row mx-auto my-auto">
                <div id="myCarousel" class="carousel slide w-100" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox">
                        @foreach($productosMasComprados as $key => $producto)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <div class="col-lg-4 col-md-6">
                                    <div class="row">
                                        <div class="col-9 text-truncate">
                                            <h5 class="text-gold-4">{{ $producto->cabms }} - {{ $producto->descripcion }}</h5>
                                        </div>
                                        <div class="col-3 mb-3 justify-content-end">
                                            <input type="hidden" id="input_favt_{{ $producto->id_e }}" value="{{ $producto->id_favorito == null ? 0 : $producto->id_favorito }}">
                                            <a href="javascript: void(0)" onclick="addFavoritos('icono_favt_{{ $producto->id_e }}', 'input_favt_{{ $producto->id_e }}', '{{ $producto->id_e }}');">
                                                <i class="@if($producto->favorito) fa-solid @else fa-regular @endif fa-heart like-gold {{ $producto->id_e }}" id="icono_favt_{{ $producto->id_e }}"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('tienda_urg.show', $producto->id_e) }}">
                                            <div class="border rounded">
                                                <div class="row p-2">
                                                    @if(\Carbon\Carbon::parse($producto->created_at)->diffInDays(now()) < 90)
                                                        <p class="porLiberar">Nuevo</p>
                                                    @endif
                                                </div>
                                                <div class="text-center">
                                                    @if($producto->foto_uno != null)
                                                        <img src="{{ asset('storage/img-producto-pfp/'.$producto->foto_uno) }}" class="imag-card text-center" alt="/">
                                                    @endif
                                                </div>
                                                <div class="p-3">
                                                    <p class="text-2">{{ $producto->marca }}</p>
                                                    <div class="text-truncate text-gold-2 mt-2">
                                                        {{ $producto->nombre_producto }}
                                                    </div>
                                                    <div class="text-2">
                                                        Tamaño: {{ $producto->tamanio }}
                                                    </div>
                                                    <div class="text-1">
                                                        <strong>${{ number_format($producto->precio_unitario, 2) }}</strong> <span class="ml-1">x 1 {{ $producto->medida }}</span>
                                                    </div>
                                                </div>
                                                <div class="separator mb-3"></div>
                                                <div class="m-1 ml-3 mb-4">
                                                    @php
                                                        $estrellas = 0;
                                                        if($producto->calificacion != null and $producto->total != 0){
                                                            $estrellas = ceil($producto->calificacion / $producto->total);
                                                        }
                                                    @endphp 
                                                     @for($i = 1; $i <= 5; $i++ )
                                                        @if($i <= $estrellas )
                                                            <i class="fa-solid fa-star estrella active"></i>
                                                        @else
                                                            <i class="fa-solid fa-star estrella"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev w-auto" href="#myCarousel" role="button" data-slide="prev">
                        <i class="fa-solid fa-angle-left text-1"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#myCarousel" role="button" data-slide="next">
                        <i class="fa-solid fa-angle-right text-1"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <div class="row mt-4 mb-5">
                <div class="col-auto">
                    <p class="text-14 ml-2">Productos recién agregados</p>
                </div>
                <div class="col-8 d-none d-lg-block d-md-block">
                    <hr>
                </div>
            </div>

            <div class="row mx-auto my-auto">
                <div id="myCarousel2" class="carousel slide w-100" data-ride="carousel">
                    <div class="carousel-inner w-100" role="listbox">
                        @foreach($productosNuevos as $key => $productoN)
                            <div class="carousel-item @if($key == 0) active @endif">
                                <div class="col-lg-4 col-md-6">
                                    <div class="row ">
                                        <div class="col-9 text-truncate">
                                              <h5 class="text-gold-4">{{ $productoN->cabms }} - {{ $productoN->descripcion }}</h5>
                                        </div>
                                        <div class="col-3 mb-3 justify-content-end">
                                            <input type="hidden" id="input_favtn_{{ $productoN->id_e }}" value="{{ $productoN->id_favorito == null ? 0 : $productoN->id_favorito }}">
                                            <a href="javascript: void(0)" onclick="addFavoritos('icono_favtn_{{ $productoN->id_e }}', 'input_favtn_{{ $productoN->id_e }}', '{{ $productoN->id_e }}');">
                                                <i class="@if($productoN->favorito) fa-solid @else fa-regular @endif fa-heart like-gold {{ $productoN->id_e }}" id="icono_favtn_{{ $productoN->id_e }}"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('tienda_urg.show', $productoN->id_e) }}">
                                            <div class="border rounded">
                                                <div class="row p-2">
                                                     @if(\Carbon\Carbon::parse($productoN->created_at)->diffInDays(now()) < 90)
                                                        <p class="porLiberar">Nuevo</p>
                                                    @endif
                                                </div>
                                                <div class="text-center">
                                                    @if($productoN->foto_uno != null)
                                                        <img src="{{ asset('storage/img-producto-pfp/'.$productoN->foto_uno) }}" class="imag-card text-center" alt="/">
                                                    @endif
                                                </div>
                                                <div class="p-3">
                                                    <p class="text-2">{{ $productoN->marca }}</p>
                                                    <div class="text-truncate text-gold-2 mt-2">
                                                        {{ $productoN->nombre_producto }}
                                                    </div>
                                                    <div class="text-2">
                                                        Tamaño: {{ $productoN->tamanio }}
                                                    </div>
                                                    <div class="text-1">
                                                         <strong>${{ number_format($productoN->precio_unitario, 2) }}</strong> <span class="ml-1">x 1 {{ $productoN->medida }}</span>
                                                    </div>
                                                </div>
                                                <div class="separator mb-3"></div>
                                                <div class="m-1 ml-3 mb-4">
                                                    @php
                                                        $estrellasN = 0;
                                                        if($productoN->calificacion != null and $productoN->total != 0){
                                                            $estrellasN = ceil($productoN->calificacion / $productoN->total);
                                                        }
                                                    @endphp 
                                                     @for($i = 1; $i <= 5; $i++ )
                                                        @if($i <= $estrellasN )
                                                            <i class="fa-solid fa-star estrella active"></i>
                                                        @else
                                                            <i class="fa-solid fa-star estrella"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev w-auto" href="#myCarousel2" role="button" data-slide="prev">
                        <i class="fa-solid fa-angle-left text-1"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next w-auto" href="#myCarousel2" role="button" data-slide="next">
                        <i class="fa-solid fa-angle-right text-1"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
         <!-- -------Productos---------->

         <!-- -------¿Necesitas ayuda?---------->
        <div class="col-lg-3 col-md-4 text-center ml-1">
            <P class="text-10">¿Necesitas ayuda?</P>
            <p class="text-1 p-4">Contacta al administrador de Contrato Marco</p>
            <button type="button" class="btn boton-12" onclick="mensajeModal()">Enviar mensaje</button>

            <div class="col-auto bg-light mt-4 p-2">
                <p class="text-15 mt-2">
                    Nuevos Proveedores en Contrato Marco
                </p>
                <hr>

                <div class="row mt-3">
                    <div class="col-8"></div>
                    <div class="col-2 mr-3">
                        <p class="text-2 text-center ml-2">Productos</p>
                    </div>
                </div>
                @foreach($proveedores as $proveedor)
                    <div class="row mt-4">
                        <div class="col-8 text-truncate">
                            <p class="float-left ml-2"><a href="javascript: void(0)" onclick="clicEmpresa('{{ $proveedor->nombre }}')" class="text-3"><strong>{{ $proveedor->nombre }}</strong></a></p>
                        </div>

                        <div class="col-2 ml-3 badge-gris-1 rounded text-center">
                            <p class="text-2 text-center">{{ $proveedor->productos }}</p>
                        </div>
                    </div>
                @endforeach
                <br>
            </div>

            <div class="row mt-4 p-3">
                <div class="col-12">
                    <p class="text-14 text-center">
                        ¿Quieres conocer tu actividad en Contrato Marco?
                    </p>
                </div>
                <div class="col-12">
                    <p class="text-1 text-center">
                        Obten datos de interés al exportar reportes prediseñados para ti.
                    </p>
                    <div class="col-12 mt-2">
                        <a href="{{ route('reporte_urg.index') }}" class="btn boton-9">Mis Reportes</a>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <p class="text-10 text-center" >
                        ¿Tienes alguna propuesta de producto?
                    </p>
                </div>
                <div class="col-12">
                    <p class="text-1 text-center">
                        Puedes solicitar el estudio para incluirlo en Contrato Marco
                    </p>
                    <div class="col-12 mt-2">
                        <button type="button" class="btn boton-2" onclick="mensajeModal()">Enviar solicitud</button>
                    </div>
                </div>
            </div>
        </div>
          <!-- -------¿Necesitas ayuda?---------->
    </div>


@endsection
@section('js')
    @routes(['tiendaUrg', 'carritoCompra','pfu'])
    <script src="{{ asset('asset/js/urg_home.js') }}" type="text/javascript"></script>
@endsection