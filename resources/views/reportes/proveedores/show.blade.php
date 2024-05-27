@extends('layouts.proveedores_ficha_productos')

@section('content')
    <div class="row">
        <div class="nav nav-tabs mt-5" id="nav-tab" role="tablist">
            <a href="javascript: void(0)" onclick='history.back()' class="text-gold ml-5"><i
                    class="fa-solid fa-arrow-left text-gold ml-1"></i> Regresar</a>
            <a class="nav-item nav-link active ml-3 text-1" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                role="tab" aria-controls="nav-home" aria-selected="true">Orden compra</a>
        </div>

        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="row  justify-content-md-center">
                <div class="col-sm-12 col-md-12 text-center mt-3">
                    <p class="text-1">SISTEMA DE CONTRATO MARCO</p>
                    <p class="text-14">{{ session('nombreReporte') }}</p>
                </div>
                <div class="col-md-12 text-center mt-3 mb-3">
                    <a class="text-5" href="{{ route('reporte_proveedor.export') }}" title="Descargar en formato excel">Descargar<i class="fa-solid fa-file-excel text-5"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-10 mx-auto d-block">
        <div class="row ml-1">
            <div class="col col-lg-2 col-md-4 col-sm-6 bg-light">
                <p class="text-1 font-weight-bold" style="margin-top: .6rem; margin-bottom: .6rem;">PROVEEDOR</p>
            </div>
            <div class="col col-lg-9 col-md-8 col-sm-6">
                <p class="text-1" style="margin-top: .6rem; margin-bottom: .6rem;">
                    {{ Auth::guard('proveedor')->user()->nombre }}</p>
            </div>
        </div>
        <hr style="margin-top: 0%; margin-bottom: 0%;">
        <div class="row ml-1">
            <div class="col col-lg-2 col-md-4 col-sm-6 bg-light">
                <p class="text-1 font-weight-bold" style="margin-top: .6rem; margin-bottom: .6rem;">FECHA DE REPORTE</p>
            </div>
            <div class="col col-lg-9 col-md-8 col-sm-6">
                <p class="text-1" style="margin-top: .6rem; margin-bottom: .6rem;">
                    {{ Carbon\Carbon::parse(session('fechaReporte'))->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <div class="tab-content col-10 mx-auto d-block mt-4">
        <input type="hidden" id="tipo_reporte" value="{{ session('tipoReporte') }}">

        @php $columnas = []; @endphp
        @switch(session('tipoReporte'))
            @case(1){{-- Ordenes de compra general --}}
                @php $columnas = ['ID ORDEN DE COMPRA', 'ID REQUISICIÓN', 'URG (UNIDAD RESPONSABLE DE GASTO)', 'MONTO TOTAL DE LA ORDEN DE COMPRA', 'CAPÍTULO', 'ESTATUS', 'PROVEEDOR', 'RFC PROVEEDOR', 'FECHA DE ORDEN DE COMPRA']; @endphp
            @break
            @case(2){{-- Directorio unidades compradoras --}}
                @php $columnas = ['URG (UNIDAD RESPONSABLE DE GASTO)', 'CORREO ELECTRONICO', 'TELEFONO', 'FECHA DE CREACIÓN DE CUENTA']; @endphp
            @break
            @case(3){{-- Reporte de orden compra completo --}}                
                @php $columnas = ['ID ORDEN DE COMPRA', 'ID REQUISICIÓN', 'URG(UNIDAD RESPONSABLE DE GASTO)', 'CLAVE CAMBS CDMX', 'DESCRIPCIÓN DEL BIEN', 'UNIDAD DE MEDIDA', 'PRECIO UNITARIO', 'CANTIDAD', 'MONTO TOTAL DE LA ORDEN DE COMPRA CON IVA', 'MONTO TOTAL DE LA ORDEN DE COMPRA SIN IVA', 'CAPÍTULO', 'ESTATUS', 'PROVEEDOR', 'RFC PROVEEDOR', 'TIPO DE CONTRATO', 'ID CONTRATO MARCO', 'NOMBRE CONTRATO MARCO', 'FECHA DE ORDEN DE COMPRA']; @endphp
            @break;
            @case(4){{-- Reporte de incidencias de la URG --}}
                @php $columnas = ['ID DE IDENTIFICACIÓN', 'URG', 'CONTRATO MARCO', 'ID CONTRATO MARCO', 'MOTIVO', 'DESCRIPCIÓN', 'CLAVE DE LA URG', 'FECHA DE LA INCIDENCIA', 'TIPO DE LLAMADA DE ATENCIÓN', 'ETAPA']; @endphp
            @break;
            @case(5)
                @php $columnas = ['ID PARTIDA', 'CLAVE CAMBSCDMX', 'CAPÍTULO', 'FECHA DE PUBLICACIÓN', 'VALIDACIÓN ECONÓMICA', 'VALIDACIÓN TÉCNICA', 'VALIDACIÓN ADMINISTRATIVA', 'CONTRATO MARCO (NOMBRE)', 'ID CONTRATO MARCO', 'ESTATUS DEL PRODUCTO', 'PROVEEDOR', 'PRECIO UNITARIO SIN IVA', 'PRECIO UNITARIO CON IVA', 'UNIDAD DE MEDIDA', 'PRODUCTO', 'DESCRIPCIÓN DEL BIEN', 'FECHA DE MODIFICACIÓN DEL PRECIO', 'NO. FICHA', 'VERSIÓN']; @endphp
            @break;
            @case(6){{-- REPORTE DE PRODUCTOS POR CONTRATO MARCO GENERAL --}}
                @php $columnas = ['ID PARTIDA', 'CLAVE CAMBSCDMX', 'CAPÍTULO', 'PRODUCTO', 'FECHA DE PUBLICACIÓN', 'VALIDACIÓN ECONÓMICA', 'VALIDACIÓN TÉCNICA', 'VALIDACIÓN ADMINISTRATIVA', 'CONTRATO MARCO (NOMBRE)', 'ID CONTRATO MARCO', 'ESTATUS DEL PRODUCTO', 'PROVEEDOR', 'NO. FICHA', 'VERSIÓN']; @endphp
            @break
            @case(7)
                @php $columnas = ['ID ADHESIÓN', 'TRIMESTRE DE REGISTRO', 'ID CONTRATO MARCO', 'NOMBRE DE CONTRATO MARCO', 'OBJETO DE CONTRATACIÓN', 'CENTRO GESTOR ADHERIDO', 'CLAVE DEL CENTRO GESTOR', 'FECHA DE ADHESIÓN', 'FECHA DE VIGENCIA', 'ESTATUS']; @endphp
            @break
            @case(8){{-- ANALÍTICO DE CONTRATOS MARCO COMPLETO --}}
                @php $columnas = ['TRIMESTRE', 'ID CONTRATO MARCO', 'OBJETO DEL CONTRATO MARCO ', 'TIPO DE CONTRATACIÓN', 'FECHA DE CREACIÓN DEL CONTRATO MARCO', 'FECHA DE TÉRMINO DEL CONTRATO MARCO', 'FECHA DE MODIFICACIÓN DE CONTRATO MARCO', 'RESPONSABLE DEL ALTA DEL CONTRATO MARCO', 'FECHA DE INGRESO DE LA URG', 'FECHA DE INGRESO DEL PROVEEDOR', 'CAPÍTULO', 'PARTIDA', 'URG', 'ESTATUS URG', 'RFC PROVEEDOR', 'NOMBRE PROVEEDOR', 'ESTATUS PROVEEDOR', 'ESTADO DEL CONTRATO', 'ID ORDEN DE COMPRA']; @endphp
            @break
            @case(9){{-- REPORTE CLAVES CAMBS POR CONTRATO MARCO --}}
                @php $columnas = ['ID PARTIDA', 'CAPÍTULO', 'CABMS CDMX ', 'ID CONTRATO MARCO', 'NOMBRE CONTRATO', 'DESCRIPCIÓN DEL BIEN']; @endphp
            @break
            @case(10){{-- Reporte de orden compra completo por URG --}}                
                @php $columnas = ['ID ORDEN DE COMPRA', 'ID REQUISICIÓN', 'URG(UNIDAD RESPONSABLE DE GASTO)', 'CLAVE CAMBS CDMX', 'DESCRIPCIÓN DEL BIEN', 'UNIDAD DE MEDIDA', 'PRECIO UNITARIO', 'CANTIDAD', 'MONTO TOTAL DE LA ORDEN DE COMPRA CON IVA', 'MONTO TOTAL DE LA ORDEN DE COMPRA SIN IVA', 'CAPÍTULO', 'ESTATUS', 'PROVEEDOR', 'RFC PROVEEDOR', 'TIPO DE CONTRATO', 'ID CONTRATO MARCO', 'NOMBRE CONTRATO MARCO', 'FECHA DE CREACIÓN DE ORDEN DE COMPRA', 'DIRECTOR GENERAL DE ADMINISTRACIÓN U HOMÓLOGO', 'RESPONSABLE DE GENERAR LA ORDEN DE COMPRA']; @endphp
            @break
        @endswitch

        <div class="table-responsive">
            <table class="table table-hover jtable_center nowrap" style="width:100%" id="tbl_reportes_desgloce">
                <thead class="bg-light">
                    <tr>
                        <th scope="col"></th>
                        @foreach ($columnas as $columna)
                            <th scope="col" class="sortable tab-cent text-1">{{ $columna }}</th>
                        @endforeach
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('js')
    @routes(['reporte_proveedor'])
    <script src="{{ asset('asset/js/reportes_proveedor.js') }}" type="text/javascript"></script>
@endsection
