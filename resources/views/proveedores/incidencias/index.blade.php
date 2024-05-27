@extends('layouts.proveedores_ficha_productos')
@section('content')
    <div class="col-12">
        <h1 class="mt-2 px-3">Incidencias</h1>
        <div class="row col-12 col-md-12 d-flex text-2">
            <p class="text-2 ml-3">En esta página encontrarás las incidencias que has abierto en Contrato Marco.</p>
        </div>
    </div>
    <hr>

    <nav class="ml-3">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-urg-tab" data-toggle="tab" href="#nav-proveedores1" role="tab"
                aria-controls="nav-urg" aria-selected="true">URG</a>
            <a class="nav-item nav-link" id="nav-proveedores-tab" data-toggle="tab" href="#nav-administrador" role="tab"
                aria-controls="nav-proveedores" aria-selected="false">Administrador</a>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <!-- ------Proveedores--------->
        <div class="tab-pane fade show active" id="nav-proveedores1" role="tabpanel" aria-labelledby="nav-proveedores1-tab">
            <div class="row justify-content-md-center">
                <div class="col-12 mt-2">
                    <p class="text-center text-14 mb-4">URG con incidencias: {{ $totalesProveedor->total_urgs }}</p>

                    <div class="row justify-content-md-center">
                        <div class="col-2"></div>
                        <div class="col-12 col-md-2 text-center">
                            <p class="text-1"><span class="text-15">{{ $totalesProveedor->total_incidencias }}</span> -
                                Todas</p>
                        </div>
                        <div class="col-12 col-md-2 text-center">
                            <p class="text-1"><span class="text-15">{{ $totalesProveedor->total_abiertas }}</span> -
                                Abiertas</p>
                        </div>
                        <div class="col-12 col-md-2 text-center">
                            <p class="text-1"><span class="text-15">{{ $totalesProveedor->total_respuestas }}</span> -
                                Respuestas</p>
                        </div>
                        <div class="col-12 col-md-2 text-center">
                            <p class="text-1"><span class="text-15">{{ $totalesProveedor->total_cerradas }}</span> -
                                Cerradas</p>
                        </div>
                        <div class="col-2"></div>
                    </div>
                    <hr>

                    <div class="row justify-content-center ml-3">
                        <div class="d-flex justify-content-center">
                            <form class="form-inline">
                                <div class="col-md-auto col-sm-12 mt-1">
                                    <select class="custom-select mr-sm-2 text-2" id="urgs">
                                        <option selected value="" disabled>Unidades Responsables de Gasto</option>
                                        <option value="">Todos</option>
                                        @foreach ($urgs as $urg)
                                            <option value="{{ $urg->nombre }}"> {{ $urg->nombre }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-auto col-sm-12 mt-1">
                                    <select class="custom-select mr-sm-2 text-2 " id="estatus">
                                        <option selected value="" disabled>Estatus</option>
                                        <option value="">Todos</option>
                                        <option value="Abierta">Abierta</option>
                                        <option value="Respuesta">Respuesta</option>
                                        <option value="Cerrada">Cerrada</option>
                                    </select>
                                </div>
                                <div class="col-auto mt-1">
                                    <div class="form-row text-2">
                                        <label for="fecha_inicio_proveedor" class="mr-2">De</label>
                                        <input type="date" id="fecha_inicio_proveedor" name="fecha_inicio_proveedor">
                                    </div>
                                </div>
                                <div class="col-auto mt-1">
                                    <div class="form-row text-2">
                                        <label for="fecha_fin_proveedor" class="mr-2">Hasta</label>
                                        <input type="date" id="fecha_fin_proveedor" name="fecha_fin_proveedor">
                                    </div>
                                </div>
                            </form>
                        </div>

                        <style>
                            .incidencia-titulo {
                                background-color: #f2f1f1;
                                color: #000000;
                            }

                            .jtable_c tbody td {
                                text-align: left !important;
                                vertical-align: auto !important;
                            }

                            .jtable_c td,
                            .jtable_c th {
                                padding: .75rem;
                                vertical-align: top;
                                border-top: 1px solid #f4f4f4;
                            }

                            .algo>tbody>tr:hover {
                                background-color: #ffffff;
                            }
                        </style>


                        <div class="col-md-11 col-sm-12 mt-4">
                            <div class="table-responsive ml-2">
                                <table class="table jtable_center nowrap" style="width:100%" id="tbl_incidencias_proveedor">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Unidad
                                                Responsable de Gasto</th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Fecha
                                                apertura</th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Origen</th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">ID Orden
                                            </th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Motivo
                                            </th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Estatus
                                            </th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">
                                                Solucionado</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ------Proveedores--------->
        <!-- ------Administrador--------->
        <div class="tab-pane fade" id="nav-administrador" role="tabpanel" aria-labelledby="nav-administrador-tab">
            <div class="row justify-content-md-center">
                <div class="col-12 mt-2">
                    <p class="text-center text-10 mb-4">Incidencias generadas por el Administrador</p>

                    <div class="row justify-content-md-center">
                        <div class="col-2"></div>
                        <div class="col-12 col-md-2 text-center">
                            <p class="text-1"><span class="text-15">{{ $totalesAdmin->total_incidencias }}</span> - Todas
                            </p>
                        </div>
                        <div class="col-12 col-md-2 text-center">
                            <p class="text-1"><span class="text-15">{{ $totalesAdmin->total_leves }}</span> - Leves</p>
                        </div>
                        <div class="col-12 col-md-2 text-center">
                            <p class="text-1"><span class="text-15">{{ $totalesAdmin->total_moderadas }}</span> -
                                Moderadas</p>
                        </div>
                        <div class="col-12 col-md-2 text-center">
                            <p class="text-1"><span class="text-15">{{ $totalesAdmin->total_graves }}</span> - Graves</p>
                        </div>
                        <div class="col-2"></div>
                    </div>
                    <hr>

                    <div class="row justify-content-center ml-3">
                        <section>
                            <div class="d-flex justify-content-center">
                                <form class="form-inline">
                                    <div class="col-md-auto col-sm-12 mt-1">
                                        <select class="custom-select mr-sm-2 text-2" id="origenes" name="origenes">
                                            <option selected value="" disabled>Origen</option>
                                            <option value="">Todos</option>
                                            @foreach ($origenes as $origen)
                                                <option value="{{ $origen->etapa }}"> {{ $origen->etapa }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-auto col-sm-12 mt-1">
                                        <select class="custom-select mr-sm-2 text-2" id="motivos" name="motivos">
                                            <option selected value="" disabled>Motivo</option>
                                            <option value="">Todos</option>
                                            @foreach ($motivos as $motivo)
                                                <option value="{{ $motivo->motivo }}"> {{ $motivo->motivo }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-auto col-sm-12 mt-1">
                                        <select class="custom-select mr-sm-2 text-2" id="escalas" name="escalas">
                                            <option selected value="" disabled>Escala</option>
                                            <option value="">Todos</option>
                                            <option value="leve">Leve</option>
                                            <option value="moderada">Moderada</option>
                                            <option value="grave">Grave</option>
                                        </select>
                                    </div>
                                    <div class="col-auto mt-1">
                                        <div class="form-row text-2">
                                            <label for="fecha_inicio_admin" class="mr-2">De</label>
                                            <input type="date" id="fecha_inicio_admin" name="fecha_inicio_admin">
                                        </div>
                                    </div>
                                    <div class="col-auto mt-1">
                                        <div class="form-row text-2">
                                            <label for="fecha_fin_admin" class="mr-2">Hasta</label>
                                            <input type="date" id="fecha_fin_admin" name="fecha_fin_admin">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </section>

                        <div class="col-md-11 col-sm-12 mt-4">
                            <div class="table-responsive ml-2">
                                <table class="table jtable_center nowrap" style="width:100%" id="tbl_incidencias_admin">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col"></th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">
                                                Fecha apertura
                                            </th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">ID Incidencia
                                            </th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Origen</th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">ID Origen</th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Motivo</th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Sanción</th>
                                            <th scope="col" class="sortable tab-cent text-2 font-weight-bold">Escala</th>                                            
                                        </tr>
                                    </thead>                    
                                </table>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- ------Administrador--------->
    </div>
@endsection

@section('js')
    @routes(['incidencia_proveedor'])
    <script src="{{ asset('asset/js/incidencia_proveedor.js') }}" type="text/javascript"></script>
@endsection
