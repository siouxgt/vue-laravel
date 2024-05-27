@extends('layouts.admin')
    @section('content')
        @include('admin.orden-compra.encabezado_interno')

       <section class="row justify-content-md-center">
           <div class="col-md-5 col-sm-11 align-self-center border rounded">

               <div class="col text-center mt-3">
                   <p class="text-1">Revisa la prefactura y solicita cambios si lo requieres. Una vez corregida, acéptala.</p>
               </div>
               <hr>

               <div class="col text-center mb-3">
                   <p class="text-1 mt-3"><strong>Días para concluir la facturación</strong></p>
                   <p class="text-11"><strong>{{ $diasRestan }}</strong></p>
               </div>

               <hr>
               @if($facturacion != '[]')

                    <div class="col text-center">
                        <p class="text-14">1. Prefactura</p>
                        
                        <p class="text-1 mt-4">Archivo recibido</p>
                        <p class="text-1"><strong>@if($facturacion[0]->fecha_prefactura_envio){{ $facturacion[0]->fecha_prefactura_envio->format('d/m/Y') }} @endif</strong></p>
                            
                        <a href="{{ asset('storage/proveedor/orden_compra/facturas/prefactura/'.$facturacion[0]->archivo_prefactura) }}" target="_blank"><p class="text-5 mt-4 text-center"><strong><span><i class="fa-solid fa-file-invoice-dollar text-5"></i></span>Prefactura</strong></p></a>

                    </div>
                   
                   <hr>

                   <div class="col text-center mb-3">
                       <p class="text-14">2. Prefactura aceptada</p>
                       <div class="text-center mt-3">
                           <p class="text-1"><strong> @if($facturacion[0]->estatus_prefactura != 1) NO @else SI @endif </strong></p>
                       </div>
                   </div>
                   <hr>

                   <div class="col text-center mb-3">
                       <p class="text-14">Error en prefacturacion</p>
                   </div>

                   @if($facturacionCorrecciones != '[]')
                       <div id="div_cambios">
                           <div class="col text-center mb-3">
                               <p class="text-2"><strong>Tipo de corrección</strong></p>
                               <p class="text-2" id="correccion">{{ $facturacionCorrecciones[0]->tipo_correccion }}</p>
                           </div>

                           <div class="col text-center mb-3">
                               <p class="text-2"><strong>Descripción del cambio</strong></p>
                               <p class="text-2" id="descripcion">{{ $facturacionCorrecciones[0]->descripcion }}</p>
                           </div>
                       </div>
                    @endif

                    <hr>
                @endif

                @if($facturacion != "[]" and $facturacion[0]->archivo_factura)
                    <div class="col text-center">
                        <p class="text-14">3. Factura</p>
                        <p class="text-1 mt-4">Archivo recibido</p>
                        <p class="text-1"><strong>{{ $facturacion[0]->fecha_factura_envio->format('d/m/Y') }}</strong></p>

                        <a href="{{ asset('storage/proveedor/orden_compra/facturas/factura/'.$facturacion[0]->archivo_factura) }}" target="_blank"><p class="text-5 mt-4 text-center mb-2"><strong><span>
                        <i class="fa-solid fa-file-invoice-dollar ml-3 text-5"></i>
                        </span>Factura timbrada</strong></p></a>
                    </div>
                    <hr>

                    <div class="col text-center mb-3">
                        <p class="text-14">Ingresó de la factura en SAP GRP</p>

                        <p class="text-1 mt-4">Fecha de ingreso</p>
                        <p class="text-1"><strong id="fecha">@if($facturacion[0]->fecha_sap) {{$facturacion[0]->fecha_sap->format('d/m/Y') }} @endif</strong></p>

                        <div class="text-center mt-3">
                            <p class="text-1"><strong> @if($facturacion[0]->estatus_factura != 1) No @else SI @endif </strong></p>
                        </div>
                    </div>
                    <hr>
                @endif

               <div class="row mb-3">
                    <div class="col-12 text-center">
                        <p class="text-14">Penalización</p>
                        <p class="text-1 px-5">El sistema registró penalización por entrega tardía. El monto será descontado de la factura (antes de IVA).</p>
                    </div>
                   <div class="col-6 text-center">
                       <p class="text-1 mt-4">Penalización envío del 1% por {{ $diasPenalizacionEnvio }} días</p>
                       <p class="text-red-precio"><strong>${{ number_format($penalizacionEnvio,2) }}</strong></p>
                    </div>
                    <div class="col-6 text-center">
                       <p class="text-1 mt-4">Penalización sustitución del 1% por {{ $diasPenalizacionSustitucion }} días</p>
                       <p class="text-red-precio"><strong>${{ number_format($penalizacionSustitucion,2) }}</strong></p>
                   </div>
                   <div class="col-12 text-center">
                       <p class="text-1 mt-4">Total</p>
                       <p class="text-red-precio"><strong>${{ number_format($penalizacionEnvio + $penalizacionSustitucion,2) }}</strong></p>
                   </div>
               </div>
               <hr>

               <div class="col text-center">
                    <p class="text-14">Reportes</p>
                    <p class="text-2"><strong>Abiertos por la URG.</strong></p>
    
                    @foreach($reportes as $reporte)
                        <p class="text-center text-rojo p-2"><b>ID Reporte: {{ $reporte->id_reporte}}</b></p>
                    @endforeach

                    <p class="text-14 mt-5">Abrir incidencia</p>
                    <p class="text-2"><strong>Abiertos por la URG.</strong></p>

                    <div id="des_incidencia">
                        @if($incidencias != "[]")
                            <p class="text-center text-rojo p-2"><b>ID Incidencia: {{ $incidencias[0]->id_incidencia }}</b></p>
                        @endif
                    </div>

                </div>

           </div>

       </section>

    @endsection
    