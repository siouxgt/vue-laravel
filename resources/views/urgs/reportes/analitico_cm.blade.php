@extends('layouts.urg')
    @section('content')

        <div class="row">
            <div class="nav nav-tabs mt-5" id="nav-tab" role="tablist">
                <a href="{{ route('reporte_urg.index') }}" class="text-gold ml-5"><i class="fa-solid fa-arrow-left text-gold ml-1"></i> Regresar</a>
                <a class="nav-item nav-link active ml-3 text-1" aria-selected="true">{{ $reporte->nombre_reporte }}</a>
            </div>

            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="row  justify-content-md-center">
                    <div class="col-sm-12 col-md-12 text-center mt-3">
                        <p class="text-1">SISTEMA DE CONTRATO MARCO</p>
                        <p class="text-14">{{ $reporte->nombre_reporte }}</p>
                    </div>
                    <div class="col-md-12 text-center mt-3 mb-3">
                         <form action="{{ route('reporte_urg.descarga') }}" method="POST" id="frm_reporte">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-12 mt-2 d-flex justify-content-center mb-3">
                                    <input type="hidden" name="reporte" value="{{ $reporte->id_e}}">
                                    <a href="javascript: void(0)" onclick="document.forms['frm_reporte'].submit()"><i class="fa-solid fa-file-excel text-22"></i></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-10 mx-auto d-block">
                <div class="row ml-1">
                    <div class="col col-lg-2 col-md-4 col-sm-6 bg-light">
                      <p class="text-1 font-weight-bold">UNIDAD COMPRADORA</p>
                    </div>
                    <div class="col col-lg-9 col-md-8 col-sm-6">
                      <p class="text-1">{{ $reporte->urg->nombre}}</p>
                    </div>
                </div>
                <hr>
                <div class="row ml-1">
                    <div class="col col-lg-2 col-md-4 col-sm-6 bg-light">
                      <p class="text-1 font-weight-bold">FECHA DE REPORTE</p>
                    </div>
                    <div class="col col-lg-9 col-md-8 col-sm-6">
                      <p class="text-1">{{ $reporte->created_at  }}</p>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <div class="tab-content col-10 mx-auto d-block mt-4" id="nav-tabContent">
            <div class="table-responsive">
                <table class="table" id="table_reporte">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col"class="tab-cent">#</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">ID CONTRATO MARCO</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">OBJETO DEL CONTRATO MARCO</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">TIPO DE CONTRATACIÓN</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">FECHA DE CREACIÓN DEL CONTRATO MARCO</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">FECHA DE MODIFICACIÓN DE CONTRATO MARCO DATOS GENERALES</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">RESPONSABLE DEL ALTA DEL CONTRATO MARCO</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">FECHA DE INGRESO DE LA URG</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">FECHA DE INGRESO DEL PROVEEDOR</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">CAPÍTULO</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">PARTIDA</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">TOTAL DE URG</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">TOTAL DE  PROVEEDORES</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">ESTADO DEL CONTRATO</th>
                            <th scope="col" class="tab-cent text-2 font-weight-bold">TOTAL DE ORDEN DE COMPRA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $value)
                            <tr>
                                <td class="tab-cent text-2 font-weight-bold">{{ $key+1 }}</td>
                                <td class="tab-cent text-2">{{ $value->objetivo }}</td>
                                <td class="tab-cent text-2">{{ $value->tipo_contratacion }}</td>
                                <td class="tab-cent text-2">{{ $value->fecha_creacion }}</td>
                                <td class="tab-cent text-2">{{ $value->fecha_fin }}</td>
                                <td class="tab-cent text-2">{{ $value->fecha_modificacion }}</td>
                                <td class="tab-cent text-2">{{ $value->responsable }}</td>
                                <td class="tab-cent text-2">{{ $value->fecha_urg }}</td>
                                <td class="tab-cent text-2">{{ $value->fecha_proveedor }}</td>
                                <td class="tab-cent text-2">{{ $value->capitulo }}</td>
                                <td class="tab-cent text-2">{{ $value->partida }}</td>
                                <td class="tab-cent text-2">{{ $value->total_urg }}</td>
                                <td class="tab-cent text-2">{{ $value->total_proveedor }}</td>
                                <td class="tab-cent text-2">{{ $value->estatus }}</td>
                                <td class="tab-cent text-2">{{ $value->orden_compra }}</td>
                            </tr>
                        @endforeach 
                    </tbody>
                </table>
            </div>
        </div>

    @endsection
    @section('js')
        <script src="{{ asset('asset/js/reporte_urg_show.js') }}" type="text/javascript"></script>
    @endsection