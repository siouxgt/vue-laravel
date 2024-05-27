@extends('layouts.urg')
    @section('content')
        @include('urgs.orden-compra.seguimiento.encabezado_interno')

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
                        <p class="text-14">1. Revisar prefactura</p>
                        
                        <p class="text-1 mt-4">Archivo recibido</p>
                        <p class="text-1"><strong>@if($facturacion[0]->fecha_prefactura_envio){{ $facturacion[0]->fecha_prefactura_envio->format('d/m/Y') }} @endif</strong></p>
                            
                        <a href="{{ asset('storage/proveedor/orden_compra/facturas/prefactura/'.$facturacion[0]->archivo_prefactura) }}" target="_blank"><p class="text-5 mt-4 text-center"><strong><span><i class="fa-solid fa-file-invoice-dollar text-5"></i></span>Prefactura</strong></p></a>

                    </div>
                   
                   <hr>

                   <div class="col text-center mb-3">
                       <p class="text-14">2. ¿Aceptas la prefactura?</p>
                       <div class="text-center mt-3">
                           <button type="button" class="btn boton-3a" @if($facturacion[0]->estatus_prefactura != 1) onclick="aceptarFactura(1)" @else disabled @endif id="aceptar">Aceptar prefactura</button>
                       </div>
                   </div>
                   <hr>

                   <div class="col text-center mb-3">
                       <p class="text-14">¿El archivo tiene errores?</p>
                       <div class="text-center mt-3">
                           <button type="button" class="btn boton-3a" @if($facturacion[0]->estatus_prefactura != 1) onclick="solicitarCambiosModal(1)" @else disabled @endif id="cambios">Solicitar cambios</button>
                       </div>
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

                    @if($facturacionCorrecciones == '[]')
                        <div class="ocultar" id="div_cambios">
                           <div class="col text-center mb-3">
                               <p class="text-2"><strong>Tipo de corrección</strong></p>
                               <p class="text-2" id="correccion"></p>
                           </div>

                           <div class="col text-center mb-3">
                               <p class="text-2"><strong>Descripción del cambio</strong></p>
                               <p class="text-2" id="descripcion"></p>
                           </div>
                       </div>
                    @endif

                    <hr>
                @endif

                @if($facturacion != "[]" and $facturacion[0]->archivo_factura)
                    <div class="col text-center">
                        <p class="text-14">3. Revisar factura</p>
                        <p class="text-1 mt-4">Archivo recibido</p>
                        <p class="text-1"><strong>{{ $facturacion[0]->fecha_factura_envio->format('d/m/Y') }}</strong></p>

                        <a href="{{ asset('storage/proveedor/orden_compra/facturas/factura/'.$facturacion[0]->archivo_factura) }}" target="_blank"><p class="text-5 mt-4 text-center mb-2"><strong><span>
                        <i class="fa-solid fa-file-invoice-dollar ml-3 text-5"></i>
                        </span>Factura timbrada</strong></p></a>
                    </div>
                    <hr>

                    <div class="col text-center mb-3">
                        <p class="text-14">¿Ya se ingresó la factura en SAP GRP?</p>

                        <p class="text-1 mt-4">Fecha de ingreso</p>
                        <p class="text-1"><strong id="fecha">@if($facturacion[0]->fecha_sap) {{$facturacion[0]->fecha_sap->format('d/m/Y') }} @endif</strong></p>

                        <div class="text-center mt-3">
                            <button type="button" class="btn boton-3a" @if($facturacion[0]->estatus_factura != 1) onclick="facturaSapModal()" @else disabled @endif id="factura_sap">Factura en SAP GRP</button>
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
                    <p class="text-14">Reportar situación</p>
                    <p class="text-2"><strong>Si tienes problemas con esta compra puedes abrir un reporte.</strong></p>

                    <button type="button" class="btn boton-3a mt-3 mb-3" @if(count($reportes) < 3 && $facturacion != '[]' && $facturacion[0]->contador_rechazos_prefactura >= 2) onclick="reportarModal('facturacion') @else disabled @endif">Reportar</button>
                    <div id="des_reporte">
                        
                    </div>
                    @foreach($reportes as $reporte)
                        <p class="text-center text-rojo p-2"><b>ID Reporte: {{ $reporte->id_reporte}}</b></p>
                    @endforeach

                    <p class="text-14 mt-5">Abrir incidencia</p>
                    <p class="text-2"><strong>Antes de abrir una incidencia, te sugerimos contactar al
                            proveedor.</strong></p>

                    <button type="button" class="btn boton-3a mt-3 mb-3" id="incidencia"  @if(count($reportes) == 3 && count($incidencias) < 1 ) onclick="incidenciaModal('facturacion')" @else disabled @endif>Abrir incidencia</button>

                    <div id="des_incidencia">
                        @if($incidencias != "[]")
                            <p class="text-center text-rojo p-2"><b>ID Incidencia: {{ $incidencias[0]->id_incidencia }}</b></p>
                        @endif
                    </div>

                </div>

           </div>

       </section>

    @endsection
    @section('js')
    @routes(['ordenCompraUrg'])
        <script src="{{ asset('asset/js/seguimiento.js') }}" type="text/javascript"></script>
    @endsection