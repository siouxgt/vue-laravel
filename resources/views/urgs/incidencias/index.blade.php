@extends('layouts.urg')
@section('content')
    <div class="col-12">
            <h1 class="mt-2 px-3">Incidencias</h1>
            <div class="row col-12 col-md-12 d-flex text-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-1">
                        <li class="breadcrumb-item text-2"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item text-2"><a href="#">Reportes</a></li>
                        <li class="breadcrumb-item text-2"><a href="#">Incidencias</a></li>
                    </ol>
                </nav>
            </div>
            <div class="row col-md-12">
                <p class="text-2 ml-3">En esta página encontrarás las incidencias que has abierto en Contrato Marco.</p>
            </div>
        </div>
        <hr>


        <nav class="ml-3">
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-urg-tab" data-toggle="tab" href="#nav-urg" role="tab">Proveedores</a>
                <a class="nav-item nav-link" id="nav-administrador-tab" data-toggle="tab" href="#nav-administrador" role="tab" onclick="tableAdmin()">Administrador</a>
            </div>
        </nav>


        <div class="tab-content" id="nav-tabContent">
            <!-- ------URG--------->
            <div class="tab-pane fade show active" id="nav-urg" role="tabpanel" aria-labelledby="nav-urg-tab">
                @include('urgs.incidencias._urg')
            </div>
            <!-- ------URG--------->
            <!-- ------Administrador--------->
            <div class="tab-pane fade" id="nav-administrador" role="tabpanel" aria-labelledby="nav-administrador-tab">
                @include('urgs.incidencias._admin')
            </div>
            <!-- ------Administrador--------->
        </div>
@endsection

@section('js')
    @routes(['incidenciaUrg'])
    <script src="{{ asset('asset/js/incidencia_urg.js') }}" type="text/javascript"></script>
    <script src="{{ asset('asset/js/incidencia_urg_admin.js') }}" type="text/javascript"></script>
@endsection
