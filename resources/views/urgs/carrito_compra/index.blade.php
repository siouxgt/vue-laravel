@extends('layouts.urg')

    @section('content')
        <input type="hidden" @if (session()->has('error')) value="{{ session('error') }}" @endif id="mensaje">
        <div class="row my-3">
            <h1 class="m-2 p-3 mt-1 ml-5">CARRITO DE COMPRAS</h1>
        </div>

        <div class="row ml-5">
            <div class="col-md-8 col-12 mr-3">
                <!-- ---------ID -1 ---------- -->
                <input type="hidden" id="cantidad_req" value="{{count($datos_carrito)}}">

                @php
                    $numeracion = 0;
                @endphp
                <!----> @for($i = 0; $i < count($datos_carrito); $i++)<!---->
                    <form action="" id="frm_requisicion_{{$i}}">
                        <div class="row bg-light border rounded ">
                            <div class="col-12 col-sm-1 col-md-1 col-lg-1 mt-2 ">
                                @if($i == 0)
                                    <button class="btn btn-red-collap " type="button" data-toggle="collapse" data-target="#collapseExample_{{$i}}" aria-expanded="false" aria-controls="collapseExample_{{$i}}">
                                @else
                                    <button class="btn btn-red-collap " type="button" data-toggle="collapse" data-target="#multiCollapseExample_{{$i}}" aria-expanded="false" aria-controls="multiCollapseExample_{{$i}}">
                                @endif
                                    <p>
                                        <i class="fa-solid fa-minus text-4"></i>
                                    </p>
                                    </button>
                            </div>
                            <div class="col-12 col-sm-5 col-md-7 col-lg-7 mt-2">
                                <p class="text-recha font-weight-bold">ID REQUISICIÓN: {{$datos_carrito[$i]["numero_requisicion"]}}</p>
                            </div>
                            <input type="hidden" id="numero_requisicion_{{$i}}" value="{{$datos_carrito[$i]['numero_requisicion']}}">

                            <div class="col-10 col-sm-5 col-md-3 col-lg-3 form-group mt-2">
                                <p class="text-recha text-right">Comprar toda la Requisición</p>
                            </div>
                            <div class="col-2 col-sm-1 col-md-1 col-lg-1 mt-2">
                                <input class="form-check-input text-center" type="checkbox" id="check_{{$i}}">
                            </div>
                        </div>
                
                        @if($i == 0)
                            <div class="collapse mb-3 mt-3" id="collapseExample_{{$i}}">
                        @else
                            <div class="collapse multi-collapse mb-3" id="multiCollapseExample_{{$i}}">
                        @endif
                        <!---->
                        @for($j = 0; $j < count($datos_carrito[$i]['proveedores']); $j++)<!---->
                            <div class="card bg-white card-body border rounded @if($j != 0) mt-1 @endif">
                            
                                <p class="text-1 font-weight-bold">{{$datos_carrito[$i]['proveedores'][$j]['nombre_proveedor']}}</p>
                                <input type="hidden" id="proveedores_cantidad_producto{{$j}}" value="{{count($datos_carrito[$i]['proveedores'][$j]['datos'])}}">
                                <input type="hidden" id="nombre_proveedor{{$j}}" name="nombre_proveedor" value="{{ $datos_carrito[$i]['numero_requisicion'] }}__{{ $datos_carrito[$i]['proveedores'][$j]['nombre_proveedor'] }}">
                                <!---->
                                @for($k = 0; $k < count($datos_carrito[$i]['proveedores'][$j]['datos']); $k++)<!---->
                                    <input type="hidden" id="id_de_producto_{{$numeracion}}" value="{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['carrito_compra_id']}}">
                                    <input type="hidden" id="existencia_{{$numeracion}}" value="{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['existencia']}}">
                                    <div id="div_contenedor_producto_{{$numeracion}}">
                                        <div class="separator mb-3"></div>
                                        <div class="row">
                                            <div class="col-12 d-flex align-items-center">
                                                <div class="col-8">
                                                    <p class="text-2">{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['cabms']}} - {{ strtoupper($datos_carrito[$i]['proveedores'][$j]['datos'][$k]['nombre_corto']) }}</p>
                                                </div>
                                                <div class="col-4 @if($i != 0) mr-4 @endif">
                                                    <a href="javascript: void(0)" class="float-right mr-4" id="btn_eliminar_{{$numeracion}}">
                                                        <p><i class="fa-sharp fa-solid fa-circle-xmark red"></i></p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-sm-6 col-lg-2 text-center mb-2">
                                                <input class="form-check-input" type="checkbox" value="{{$i}}" id="chk_producto_{{ $numeracion }}" name="{{ $datos_carrito[$i]['numero_requisicion'] }}__{{ $datos_carrito[$i]['proveedores'][$j]['nombre_proveedor'] }}">
                                                <img src="{{ asset('storage/img-producto-pfp/'. $datos_carrito[$i]['proveedores'][$j]['datos'][$k]['foto_uno']) }}" class="imag-carrito ml-3" alt="/">
                                            </div>
                                            <div class="col-sm-6 col-lg-4">
                                                <p class="text-2">{{ strtoupper($datos_carrito[$i]['proveedores'][$j]['datos'][$k]['marca']) }}</p>
                                                <p class="text-1 font-weight-bold">{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['nombre_producto']}}</p>
                                                <p class="text-2">Tamaño: {{ strtoupper($datos_carrito[$i]['proveedores'][$j]['datos'][$k]['tamanio']) }}</p>
                                                <p class="text-2 mt-3">Color: {{ strtoupper($datos_carrito[$i]['proveedores'][$j]['datos'][$k]['color']) }}</p>
                                            </div>
                                            <div class="col-sm-12 offset-sm-6 col-md-6 offset-md-6 col-lg-4 offset-lg-7 car-comp-izq mt-2">
                                                <div class="d-flex align-items-center">
                                                    <a href="javascript: void(0)" id="btn_menos_{{$numeracion}}"><i class="fa-solid fa-circle-minus arena mr-2"></i></a>
                                                    <input type="text" class="form-control col-9 col-sm-4 col-md-8 col-lg-4 text-center" placeholder="0" value="{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['cantidad_producto']}}" name="cantidad_producto_{{$numeracion}}" id="cantidad_producto_{{$numeracion}}">
                                                    <a href="javascript: void(0)" id="btn_mas_{{$numeracion}}"><i class="fa-solid fa-circle-plus arena ml-3"></i></a>
                                                </div>
                                                <div class="col-sm-12 col-lg-8 d-xl-none mb-2">
                                                    <p class="text-1 mt-2">${{ number_format($datos_carrito[$i]['proveedores'][$j]['datos'][$k]['precio_unitario'], 2) }} x 1 {{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['medida']}}}</p>
                                                </div>
                                                <div class="col-sm-12 col-lg-8 col-lg-6 offset-lg-8 d-none d-xl-block" style="top: -1.5rem;">
                                                    <input type="hidden" id="precio_unitario_{{$numeracion}}" value="{{ $datos_carrito[$i]['proveedores'][$j]['datos'][$k]['precio_unitario'] }}">
                                                    <p class="text-1">${{ number_format($datos_carrito[$i]['proveedores'][$j]['datos'][$k]['precio_unitario'], 2) }} x 1 {{{$datos_carrito[$i]['proveedores'][$j]['datos'][$k]['medida']}}}</p>
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $numeracion++;
                                    @endphp
                                @endfor
                                <!---->
                            </div>
                        @endfor
                    </div>
                    </form>
                @endfor
                <input type="hidden" id="cantidad_elementos" value="{{$numeracion}}">
            </div>

            <div class="card bg-white col-md-3 col-12" style="margin: 0; padding: 0; width: auto; height: auto">
                <div class="card-header border bg-light" style="padding: .6rem;">
                    <p class="text-1 font-weight-bold m-2">Desglose de precios</p>
                </div>
                <div class="card-body-4 border">
                    <div id="div_desgloce_precios">                

                    </div>
                </div>
                <div class="col-12 mt-4 mb-2">
                    <div class="row mt-7 rounded m-2 bac-red">
                        <div class="col-12 text-center mt-2 mb-2">
                            <a href="javascript: void(0)" id='btn_comprar' data-toggle="modal" data-target="#exampleModal-1">
                                <p class="text-carrito text-center">Comprar</p>
                            </a>
                        </div>
                    </div>

                    <a href="javascript: void(0)" id="btn_seguir_comprando">
                        <p class="mt-2 text-gold text-center">Seguir comprando</p>
                    </a>
                </div>
            </div>

            <form action="{{route('carrito_compra.confirmar_orden_compra')}}" id="frm_requisicion" method="POST">
                @csrf
                <input type="hidden" name="productos" value="" id="productos">
            </form>

        </div>

    @endsection
    @section('js')
    @routes(['carritoCompra', 'tiendaUrg'])
    <script src="{{ asset('asset/js/carrito_compra.js') }}" type="text/javascript"></script>
    @endsection