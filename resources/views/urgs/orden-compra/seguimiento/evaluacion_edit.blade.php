@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')

        <section class="row justify-content-md-center">
            <div class="col-md-5 col-sm-11 align-self-center border rounded">
                <p class="text-1 text-center mt-4">Evaluación</p>

                <hr>
                    
                <div class="col text-center mb-3">
                    <p class="text-14">Calificación general al proveedor</p>
                    <div class="col-sm-4 col-md-12 col-gl-12 mt-2">
                        @for($i = 1; $i <= 5; $i++ )
                            @if($i <= $evaluacionProveedor->general)
                                <i class="fa-solid fa-star estrella active"></i>
                            @else
                                <i class="fa-solid fa-star estrella"></i>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col ml-3">
                        <p class="text-1 ml-5">Comunicación</p>
                    </div>
                    <div class="col">
                       @for($i = 1; $i <= 5; $i++ )
                            @if($i <= $evaluacionProveedor->comunicacion)
                                <i class="fa-solid fa-star estrella active"></i>
                            @else
                                <i class="fa-solid fa-star estrella"></i>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col ml-3">
                        <p class="text-1 ml-5">Calidad/Precio</p>
                    </div>
                    <div class="col">
                       @for($i = 1; $i <= 5; $i++ )
                            @if($i <= $evaluacionProveedor->calidad)
                                <i class="fa-solid fa-star estrella active"></i>
                            @else
                                <i class="fa-solid fa-star estrella"></i>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col ml-3">
                        <p class="text-1 ml-5">Tiempo de entrega</p>
                    </div>
                    <div class="col">
                       @for($i = 1; $i <= 5; $i++ )
                            @if($i <= $evaluacionProveedor->tiempo)
                                <i class="fa-solid fa-star estrella active"></i>
                            @else
                                <i class="fa-solid fa-star estrella"></i>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col ml-3">
                        <p class="text-1 ml-5">Mercancía en buen estado</p>
                    </div>
                    <div class="col">
                      @for($i = 1; $i <= 5; $i++ )
                            @if($i <= $evaluacionProveedor->mercancia)
                                <i class="fa-solid fa-star estrella active"></i>
                            @else
                                <i class="fa-solid fa-star estrella"></i>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col ml-3">
                        <p class="text-1 ml-5">Facturas correctas</p>
                    </div>
                    <div class="col">
                        @for($i = 1; $i <= 5; $i++ )
                            @if($i <= $evaluacionProveedor->facturas)
                                <i class="fa-solid fa-star estrella active"></i>
                            @else
                                <i class="fa-solid fa-star estrella"></i>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col ml-3">
                        <p class="text-1 ml-5">Proceso de compra</p>
                      </div>
                      <div class="col">
                        @for($i = 1; $i <= 5; $i++ )
                            @if($i <= $evaluacionProveedor->proceso)
                                <i class="fa-solid fa-star estrella active"></i>
                            @else
                                <i class="fa-solid fa-star estrella"></i>
                            @endif
                        @endfor
                      </div>
                </div>
                <br>
                <div class="col mb-5">
                    <div class="form-group mx-2">
                        <label for="opinion"><p class="text-1">Opinión</p></label>
                        <textarea class="form-control" rows="3" readonly>{{ $evaluacionProveedor->opinion }}</textarea>
                    </div>
                </div>

                <div class="col mb-5">
                    <div class="form-group mx-2">
                        <label for="opinion"><p class="text-1">Comentario</p></label>
                        <textarea class="form-control" rows="3" readonly>{{ $evaluacionProveedor->comentario }}</textarea>
                    </div>
                </div>

                <hr>

                <p class="text-14 text-center mt-4">Califición al producto</p>

                @foreach($productos as $key => $producto)
                    <div class="m-4 p-2 border">
                        <div class="row mt-2">
                            <div class="col-3">
                                <img src="{{ asset('storage/img-producto-pfp/'.$producto->foto_uno) }}" class="float-right" style="width: 30%; height: auto;">
                            </div>
                            <div class="col-6 text-center">
                                <p class="text-2"><strong>{{ $producto->nombre}}</strong></p>
                                <p class="text-2">{{ $producto->marca}}, {{ $producto->tamanio }}, {{ $producto->color }}</p>
                            </div>
                        </div>
                        @for($j = 0; $j < count($productosEvaluados); $j++)
                            @if(isset($productosEvaluados[$j]) and $producto->id == $productosEvaluados[$j]->producto_id)
                                <div class="col-sm-12 col-md-12 col-gl-12 mt-2 text-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if(isset($productosEvaluados[$j]) and $producto->id == $productosEvaluados[$j]->producto_id)
                                            @if($i <= $productosEvaluados[$j]->calificacion)
                                                <i class="fa-solid fa-star estrella active"></i>
                                            @else
                                                <i class="fa-solid fa-star estrella"></i>
                                            @endif
                                        @else
                                            <i class="fa-solid fa-star estrella"></i>
                                        @endif
                                    @endfor
                                </div>
                                <div class="col mb-5">
                                    <div class="form-group mx-2">
                                        <label for="opinion"><p class="text-1">Comentario</p></label>
                                        <textarea class="form-control" rows="3" readonly> @if(isset($productosEvaluados[$j]) and $producto->id == $productosEvaluados[$j]->producto_id){{ $productosEvaluados[$j]->comentario }} @endif</textarea>
                                    </div>
                                </div>
                                @break
                            @endif
                        @endfor
                    </div>
                @endforeach
            </div>    
        </section>

    @endsection