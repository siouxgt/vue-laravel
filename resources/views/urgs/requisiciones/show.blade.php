@extends('layouts.urg')

    @section('content')
        <div class="row">
            <div class="nav nav-tabs mt-5" id="nav-tab" role="tablist">
                <a href="{{ route('requisiciones.index') }}" class="text-gold ml-5"><i class="fa-solid fa-arrow-left text-gold ml-1"></i> Regresar</a>
                <a class="nav-item nav-link active ml-3" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                    aria-controls="nav-home" aria-selected="true">Requisición</a>
            </div>

            <div class="tab-content col-12">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="ml-3 mt-3 mr-3">
                         <form action="{{ route('requisiciones.export') }}" method="POST">
                            @csrf
                            <div class="row elemtos justify-content-end mb-3">
                                <div class="col-12 col-md-4 mt-2 d-flex justify-content-end mb-3">
                                   
                                        <input type="hidden" name="requisicion" value="{{ $requisicion->id_e}}">
                                        <select class="form-control col-3 text-1" name="formato">
                                            <option value="PDF">PDF</option>
                                            <option value="XLS">XLS</option>
                                        </select>

                                        <button type="submit"  class="btn bg-white ml-2 text-gold border">Exportar</button>
                                </div>
                            </div>
                        </form>

                        <div class="justify-content-center">
                            <div class="row mt-3">
                                <div class="col-3 col-md-2 bg-light border">
                                    <p class="text-1">ID Requisición</p>
                                </div>
                                <div class="col-9 col-md-10 border">
                                    <p class="text-1">{{ $requisicion->requisicion}}</p>
                                </div>
            
                                <div class="col-3 col-md-2 bg-light border">
                                    <p class="text-1">Objeto de requisición</p>
                                </div>
                                <div class="col-9 col-md-10 border ">
                                    <p class="text-1">{{ $requisicion->objeto_requisicion }}</p>
                                </div>
            
                                <div class="col-3 col-md-2 bg-light border">
                                    <p class="text-1">Fecha autorización</p>
                                </div>
                                <div class="col-9 col-md-10 border ">
                                    <p class="text-1">{{ \Carbon\Carbon::parse($requisicion->fecha_autorizacion)->format('d/m/Y') }}</p>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-3 col-md-2 bg-light border">
                                    <p class="text-1">Monto autorizado</p>
                                </div>
                                <div class="col-9 col-md-10 border">
                                    <p class="text-1"><strong>${{ number_format($requisicion->monto_autorizado,2) }}</strong></p>
                                </div>
            
                                <div class="col-3 col-md-2 bg-light border">
                                    <p class="text-1">Monto por confirmar</p>
                                </div>
                                <div class="col-9 col-md-10 border">
                                    <p class="text-1"><strong>$-{{ number_format($requisicion->monto_por_confirmar,2) }}</strong></p>
                                </div>
            
                                <div class="col-3 col-md-2 bg-light border">
                                    <p class="text-1">Monto adjudicado</p>
                                </div>
                                <div class="col-9 col-md-10 border">
                                    <p class="text-1"><strong>$-{{ number_format($requisicion->monto_adjudicado,2) }}</strong></p>
                                </div>
            
                                <div class="col-3 col-md-2 bg-light border">
                                    <p class="text-1">Monto pagado</p>
                                </div>
                                <div class="col-9 col-md-10 border">
                                    <p class="text-1"><strong>$-{{ number_format($requisicion->monto_pagado,2) }}</strong></p>
                                </div>
            
                                <div class="col-3 col-md-2 bg-light border">
                                    <p class="text-1">Monto disponible</p>
                                </div>
                                <div class="col-9 col-md-10 border">
                                    <p class="text-recha"><strong>${{ number_format($requisicion->monto_disponible,2) }}</strong></p>
                                </div>
                            </div>

                            <div class="row mt-3">
                                @php($total = 0)
                                @foreach($requisicion->clave_partida->clave_partida as $clave_partida)
                                    <div class="col-4 col-md-2 bg-light border">
                                        <p class="text-1">Claves presupuestarias </p>
                                    </div>
                                    <div class="col-8 col-md-3 border">
                                        <p class="text-1">{{ $clave_partida->clave_presupuestaria }}</p>
                                    </div>
                                    <div class="col-4 col-md-2 bg-light border">
                                        <p class="text-1">Partida presupuestal </p>
                                    </div>
                                    <div class="col-8 col-md-1 border">
                                        <p class="text-1">{{ $clave_partida->partida}}</p>
                                    </div>
                                    <div class="col-4 col-md-2 bg-light border">
                                        <p class="text-1">Valor estimado </p>
                                    </div>
                                    <div class="col-8 col-md-2 border">
                                        <p class="text-1 text-right">${{ number_format($clave_partida->valor_estimado,2) }}</p>
                                    </div>
                                    @php($total += $clave_partida->valor_estimado)
                                @endforeach
                            
                            </div>

                            <div class="row mt-3">
                                <div class="col-4 offset-9 col-md-1 bg-light border">
                                    <p class="text-1"><strong>Total</strong></p>
                                </div>
                                <div class="col-md-2 col-8 border">
                                    <p class="text-1 text-right"><strong>${{ number_format($total,2) }}</strong></p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="row d-flex justify-content-center col-12">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="ml-3 mt-3 mr-3">
                        
                       <div class="col-12">
                           <p class="text-1">
                               <strong>Los bienes y servicios disponibles de esta requisición para Contrato Marco son:</strong>
                           </p>
                       </div>
                       <div class="col-12">
                           <label class="form-check-label text-1 ml-2" for="todos">
                               Seleccionar todas las claves CABMS
                           </label>
                           <input class="form-check-input ml-2" type="checkbox" id="todos" onclick="todos()">
                       </div>

                       <div class="col-12 mt-5">
                        <input type="hidden" id="requisicion_id" value="{{ $requisicion->id_e}}">
                           <table class="table justify-content-md-center" id="tabla_requisicion_show">

                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">CABMSCDMX</th>
                                        <th scope="col">Bien y/o servicio</th>
                                        <th scope="col">Especificación</th>
                                        <th scope="col"></th>
                                        <th scope="col">Unidad de medida</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col" class="tab-cent">Cotizar</th>
                                        <th scope="col" class="tab-cent">Cotizada</th>
                                        <th scope="col">PMR</th>
                                        <th scope="col">Subtotal PMR</th>
                                        <th scope="col">IVA PMR</th>
                                        <th scope="col">Total PMR</th>
                                    </tr>
                                </thead>
                            </table>
                       </div>

                    </div>
                </div>
            </div>

            <div class="separator mb-3 mt-4"></div>
            <div class="row d-flex justify-content-end col-12">
                <button id="envia" class="btn bg-white text-9 border font-weight-bold">Cotizar</button>
                <form action="{{ route('tienda_urg.ver_tienda',['requisicion' => $requisicion->id_e ]) }}" method="GET">
                    <button type="submit" class="btn boton-2 ml-2 border" @if($requisicion->cotizado->cotizados == 0) disabled @endif id ="buscar">Buscar</button>
                </form>
            </div>
        </div>


    @endsection
    @section('js')
        @routes(['requisiciones','bienServicio', 'carritoCompra'])
        <script src="{{ asset('asset/js/requisicion.js') }}" type="text/javascript"></script>

    @endsection