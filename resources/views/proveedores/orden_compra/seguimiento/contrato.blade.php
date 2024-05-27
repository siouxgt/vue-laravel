@extends('layouts.proveedores_ficha_productos')

@section('content')
    <!-------------------------Nombre----------------------->
    @include('proveedores.orden_compra.seguimiento.encabezado_interno')
    <hr>
    <!-------------------------Nombre----------------------->

    <section class="row justify-content-center">
        <div class="col-lg-6 col-md-11 col-11 align-self-center border rounded">

            @switch($quien)
                @case('contrato_pdf')
                    <div class="d-flex justify-content-center align-items-center border mt-3" style="height: 500px; width: auto;">
                        <iframe
                            src="{{ asset('storage/contrato-pedido/contrato_pedido_' . $contrato[0]->contrato_pedido . '.pdf') }}"
                            frameborder='0' style="height: 500px; width: 850px;">
                        </iframe>
                    </div>
                @break

                @case('contrato_firma')
                    <div class="col text-center">
                        <p class="text-1 mt-4 m-2">Firma el contrato usando tu eFirma y sube tu archivo de cuenta bancaria</p>
                    </div>
                    <hr>
                    <form action="{{ route('orden_compra_proveedores.efirma_save') }}" method="POST" enctype="multipart/form-data"
                        id="frm_firma">
                        @csrf
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-6 m-4 p-3 border rounded text-center">
                                <p class="text-1"><strong>Archivo cuenta bancaria</strong></p>
                                <input type="file" id="archivo_banca" name="archivo_banca" class="ocultar" accept=".pdf"
                                    required />
                                <div class="rounded punteado m-3 p-4 integrar_cursor text-1" id="drop_banca">

                                </div>
                                <p class="text-1" id="nombre_banca" required></p>
                            </div>

                            <div class="col-6 m-4 p-3 border rounded text-center">
                                <p class="text-1"><strong>Archivo .cer</strong></p>
                                <input type="file" id="archivo_cer" name="archivo_cer" class="ocultar" accept=".cer" required />
                                <div class="rounded punteado m-3 p-4 integrar_cursor text-1" id="drop_cer">

                                </div>
                                <p class="text-1" id="nombre_cer" required></p>
                            </div>

                            <div class="col-6 m-4 p-3 border rounded text-center">
                                <p class="text-1"><strong>Archivo .key</strong></p>
                                <input type="file" id="archivo_key" name="archivo_key" class="ocultar" accept=".key" required>
                                <div class="rounded punteado m-3 p-4 integrar_cursor text-1" id="drop_key">

                                </div>
                                <p class="text-1" id="nombre_key"></p>
                            </div>

                        </div>
                        <div class="row d-flex justify-content-center align-items-center">
                            <div class="col-7">
                                <div class="form-group">
                                    <label for="contrasena">
                                        <p class="text-1 ml-4">Contraseña</p>
                                    </label>
                                    <input type="password" id="contrasena" name="contrasena" class="form-control mx-sm-3" required>
                                </div>
                            </div>
                        </div>
                    </form>
                    <script src="{{ asset('asset/js/drag_drop.js') }}" type="text/javascript"></script>
                @break

                @case('contrato_resumen')
                    <div class="row">
                        <div class="col text-center">
                            <p class="text-14 mt-4 m-2">Contrato número: {{ $contrato->contrato_pedido }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <p class="text-1 mt-3">
                                    Firma Titular Dirección General de Administración y Finanzas u Homólogo:
                                    <span>
                                        <strong>
                                            @if ($firmantes[1]['fecha_firma'])
                                                {{ Carbon\Carbon::parse($firmantes[1]['fecha_firma'])->format('d/m/Y') }}
                                            @endif
                                        </strong>
                                    </span>
                                </p>
                                <p class="text-1 mt-3">Firma Titular Área de Adquisiciones o Compras:
                                    <span>
                                        <strong>
                                            @if ($firmantes[2]['fecha_firma'])
                                                {{ Carbon\Carbon::parse($firmantes[2]['fecha_firma'])->format('d/m/Y') }}
                                            @endif
                                        </strong>
                                    </span>
                                </p>
                                <p class="text-1 mt-3">Firma Representante Legal:
                                    <span>
                                        <strong>
                                            @if ($firmantes[3]['fecha_firma'])
                                                {{ Carbon\Carbon::parse($firmantes[3]['fecha_firma'])->format('d/m/Y') }}
                                            @endif
                                        </strong>
                                    </span>
                                </p>

                                @if (isset($firmantes[4]))
                                    <p class="text-1 mt-3">Firma Titular Área Financiera:
                                        <span>
                                            <strong>
                                                @if ($firmantes[4]['fecha_firma'])
                                                    {{ Carbon\Carbon::parse($firmantes[4]['fecha_firma'])->format('d/m/Y') }}
                                                @endif
                                            </strong>
                                        </span>
                                    </p>
                                @endif
                                @if (isset($firmantes[5]))
                                    <p class="text-1 mt-3">Firma Titular Área Requirente:
                                        <span>
                                            <strong>
                                                @if ($firmantes[5]['fecha_firma'])
                                                    {{ Carbon\Carbon::parse($firmantes[5]['fecha_firma'])->format('d/m/Y') }}
                                                @endif
                                            </strong>
                                        </span>
                                    </p>
                                @endif


                            </div>
                        </div>

                        <div class="col-12 my-4">
                            <div class="text-center">
                                <a href="{{ asset('storage/contrato-pedido/contrato_pedido_' . $contrato->contrato_pedido . '.pdf') }}"
                                    class="text-5 mx-4" target="_blank">
                                    <i class="fa-solid fa-file-contract text-5"></i><b>Contrato</b>
                                </a>
                                <a href="{{ asset('storage/contrato-archivo-bancario/' . $contrato->archivo_bancario) }}"
                                    class="text-5 mx-4" target="_blank">
                                    <i class="fa-solid fa-file-contract text-5"></i><b>Archivo bancario</b>
                                </a>
                            </div>
                        </div>
                    </div>
                @break
            @endswitch

            @if ($quien != 'contrato_resumen')
                <div class="row mb-4 mt-1">
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-light-v mt-3 mr-2 float-right"
                            onclick="history.back()" style="font-size: medium;">
                            <i class="fa-solid fa-arrow-left text-9"></i>Atras
                        </button>
                    </div>
                    <div class="col-6">
                        <div class="botones">
                            @if ($quien == 'contrato_pdf')
                                <a class="btn boton-2 mt-3"
                                    href="{{ route('orden_compra_proveedores.abrir_pagina', [2, 'contrato_firma']) }}"
                                    role="button" style="font-size: medium;">
                                    Firmar contrato
                                </a>
                            @else
                                <button type="button" class="btn boton-2 mt-3" style="font-size: medium;"
                                    id="btn_firmar_contrato">Firmar contrato</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection

@section('js')
    @routes(['ocp'])
    <script src="{{ asset('asset/js/orden_compra_proveedor.js') }}" type="text/javascript"></script>
@endsection
