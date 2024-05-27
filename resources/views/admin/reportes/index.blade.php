@extends('layouts.admin')
    @section('content')
       <div class="col-12">
            <h1 class="m-2 px-3">Reportes</h1>
            <div class="row col-12 col-md-12 d-flex text-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mt-1">
                        <li class="breadcrumb-item text-2"><a href="#">Inicio</a></li>
                        <li class="breadcrumb-item text-2"><a href="#">Reportes</a></li>
                    </ol>
                </nav>
              </div>
        </div>
        <hr>
        <div class="row justify-content-md-center">
            <div class="col-12 mt-2">
                <p class="text-center text-14">Genera reportes de tu interés.</p>
                <p class="text-center text-1 mb-4">Utiliza los filtros para seleccionar la información a visualizar y exportar.</p>
                <hr>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <form id="frm_reporte">
            <div class="row">
                 <div class="col-md-4 col-sm-12">
                    <select class="custom-select my-1 mr-sm-2" id="reporte" name="reporte" required>
                        <option selected disabled>Tipo de reporte</option>
                        <option data="1" value="1">ANALÍTICO DE CONTRATO MARCO COMPLETO</option>
                        <option data="3" value="2">DIRECTORIO DE UNIDADES COMPRADORAS</option>
                        <option data="4" value="3">REPORTE DE ADHESIÓN PROVEEDOR</option>
                        <option data="6" value="4">REPORTE DE ADHESIÓN URG</option>
                        <option data="1" value="5">REPORTE DE CATALOGO DE PRODUCTOS</option>
                        <option data="5" value="6">REPORTE DE INCIDENCIAS DE LAS URGS</option>
                        <option data="5" value="7">REPORTE DE INCIDENCIAS POR PROVEEDOR</option>
                        <option data="7" value="8">REPORTE DE ORDEN DE COMPRA COMPLETO</option>
                        <option data="2" value="9">REPORTE DE ORDEN DE COMPRA COMPLETO POR PROVEEDOR</option>
                        <option data="3" value="10">REPORTE DE ORDEN DE COMPRA COMPLETO POR URG</option>
                        <option data="5" value="11">REPORTE DE ORDEN DE COMPRA GENERAL</option>
                        <option data="4" value="12">REPORTE DE PRECIOS CLAVES CABMS POR CONTRATO MARCO</option>
                        <option data="4" value="13">REPORTE DE PRODUCTOS POR CONTRATO MARCO COMPLETO</option>
                        <option data="5" value="14">REPORTE DE SOLICITUD DE PRORROGA PROVEEDOR</option>
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                    <select class="custom-select my-1 mr-sm-2" id="contrato" name="contrato">
                        <option selected disabled>Contrato Marco</option>
                        @foreach($contratos as $contrato)
                            <option value="{{ $contrato->id_e}}">{{ $contrato->nombre_cm}} - {{ $contrato->numero_cm }}</option>
                        @endforeach 
                    </select>
                </div>
                <div class="col-md-4 col-sm-12">
                    <select class="custom-select my-1 mr-sm-2" id="urg" name="urg">
                        <option selected disabled>Unidades Responsable de Gastos</option>
                         @foreach($urgs as $urg)
                            <option value="{{ $urg->id_e}}">{{ $urg->nombre}}</option>
                        @endforeach 
                    </select>
                </div>
                
            </div>

            <div class="row">
                <div class="col-md-4 col-sm-12">
                    <select class="custom-select my-1 mr-sm-2" id="proveedor" name="proveedor">
                        <option selected disabled>Proveedor</option>
                         @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id_e}}">{{ $proveedor->nombre}}</option>
                        @endforeach 
                    </select>
                </div>
                <div class="col-md-2 col-sm-12">
                    <select class="custom-select my-1 mr-sm-2" id="anio" name="anio">
                        <option selected disabled>Año</option>
                        @for($i = date('Y') - $anio; $i <= date('Y') ; $i++)
                            <option>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 col-sm-12">
                    <select class="custom-select my-1 mr-sm-2" id="trimestre" name="trimestre" disabled>
                        <option selected disabled>Trimestre</option>
                        <option value="1">Trimestre 1</option>
                        <option value="2">Trimestre 2</option>
                        <option value="3">Trimestre 3</option>
                        <option value="4">Trimestre 4</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-12">
                    <div class="form-row text-2">
                        <div class="input-group date hoyant">
                            <label for="de" class="mr-1">De</label>
                            <input type="text" class="form-control text-1" name="de" id="de" autocomplete="off">
                            <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                        </div>
                     </div>
                </div> 
                <div class="col-md-2 col-sm-12">
                    <div class="form-row text-2">
                        <div class="input-group date hoyant">
                            <label for="hasta" class="mr-1">Hasta</label>
                            <input type="text" class="form-control text-1" name="hasta" id="hasta" autocomplete="off">
                            <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        </div>

        <div class="row justify-content-md-center">
            <div class="col-md-1 col-sm-11 rounded p-1 mt-3 ">
                <button type="button" class="btn btn-secondary bac-red text-blanco"  onclick="reporte();">Generar reporte </button>
            </div>
        </div>
        <hr>

        <div class="row justify-content-md-center">
            <div class="col-md-8 col-sm-12">
                <div class="table-responsive">
                    <table class="table" id="tabla_reportes">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="sortable text-2 font-weight-bold">Reporte</th>
                                <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Fecha de creación</th>
                                <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Estatus</th>
                                <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Ver</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    @endsection

    @section('js')
        @routes(['reporteAdmin'])
        <script src="{{ asset('asset/js/reporte_admin.js') }}" type="text/javascript"></script>
    @endsection
