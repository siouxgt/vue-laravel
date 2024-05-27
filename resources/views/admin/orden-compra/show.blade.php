@extends('layouts.admin')
    @section('content')
        <div class="row">
            <div class="nav nav-tabs mt-5" id="nav-tab" role="tablist">
                <a href="{{ route('orden_compra_admin.index')}}" class="text-gold ml-5"><i class="fa-solid fa-arrow-left text-gold ml-1"></i> Regresar</a>
                <a class="nav-item nav-link active ml-3 text-1" id="nav-home-tab" href="#nav-home" >Orden compra</a>
            </div>

            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="row  d-flex justify-content-center">
                    <div class="col-sm-12 col-md-4 text-center mt-3">
                        <p class="text-rojo-titulo">ORDEN DE COMPRA: {{ $ordenCompra->orden_compra }}</p>
                        <p class="text-2">El seguimiento a tus paquetes y estatus se realiza por proveedor. <br>
                            En el icono de la columna “Seguimiento”, realiza las acciones requeridas.</p>
                        <input type="hidden" id="orden_compra_id" value="{{ $ordenCompra->id_e }}">
                    </div>
                </div>

                <div class="row d-flex justify-content-center p-5">
                    <div class="col  mt-3 d-flex">
                        <div class="col-1">
                            <span class="badge badge-pill badge-secondary">0</span>
                        </div>
                        <div class="col-10">
                            <p class="text-1 ml-2 font-weight-bold">Confirmadas</p>
                        </div>
                    </div>
                    <div class="col  mt-3 d-flex">
                        <div class="col-1">
                            <span class="badge badge-pill badge-gris-1">0</span>
                        </div>
                        <div class="col-10">
                            <p class="text-1 ml-2 font-weight-bold">Entregadas</p>
                        </div>
                    </div>
                    <div class="col  mt-3 d-flex">
                        <div class="col-1">
                            <span class="badge badge-pill badge-warning">0</span>
                        </div>
                        <div class="col-10">
                            <p class="text-1 ml-2 font-weight-bold">Sustitución</p>
                        </div>
                    </div>
                    <div class="col  mt-3 d-flex">
                        <div class="col-1">
                            <span class="badge badge-pill badge-gris-1">0</span>
                        </div>
                        <div class="col-10">
                            <p class="text-1 ml-2 font-weight-bold">Aceptadas</p>
                        </div>
                    </div>
                    <div class="col  mt-3 d-flex">
                        <div class="col-1">
                            <span class="badge badge-pill badge-gris-1">0</span>
                        </div>
                        <div class="col-10">
                            <p class="text-1 ml-2 font-weight-bold">Facturadas</p>
                        </div>
                    </div>
                    <div class="col  mt-3 d-flex">
                        <div class="col-1">
                            <span class="badge badge-pill badge-gris-1">0</span>
                        </div>
                        <div class="col-10">
                            <p class="text-1 ml-2 font-weight-bold">Pagadas</p>
                        </div>
                    </div>
                    <div class="col  mt-3 d-flex">
                        <div class="col-1">
                            <span class="badge badge-pill badge-gris-1">0</span>
                        </div>
                        <div class="col-10">
                            <p class="text-1 ml-2 font-weight-bold">Evaluadas</p>
                        </div>
                    </div>
                    <div class="col mt-3 d-flex">
                        <div class="col-1">
                            <span class="badge badge-pill badge-gris-1">0</span>
                        </div>
                        <div class="col-10">
                            <p class="text-1 ml-2 font-weight-bold">Finalizadas</p>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>

        <div class="row ml-1">
            <div class="col-12">
                <div class="form-group">
                    <div class="col-sm-8 col-ml-2 col-lg-2 ml-3">
                        <label for="etapa" class="text-2 mx-3">Etapa</label>
                        <select class="form-control text-1" id="etapa" onclick="buscar()">
                            <option value="">Selecciona una opcion...</option>
                            <option value="Confirmación">Confirmación</option>
                            <option value="Contrato">Contrato</option>
                            <option value="Envío">Envío</option>
                            <option value="Entrega">Entrega</option>
                            <option value="Facturación">Facturación</option>
                            <option value="Pago">Pago</option>
                            <option value="Encuesta">Encuesta</option>
                            <option value="Finalizada">Finalizada</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <table class="table justify-content-md-center bg-light" id="table_orden">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col"></th>
                            <th scope="col" class="sortable text-1 font-weight-bold">Proveedor</th>
                            <th scope="col" class="sortable tab-cent text-1 font-weight-bold">Etapa</th>
                            <th scope="col" class="sortable tab-cent text-1 font-weight-bold">Estatus</th>
                            <th scope="col" class="sortable tab-cent text-1 font-weight-bold">Vencimiento</th>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">Incidencias</th>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">Acuse</th>
                            <th scope="col" class="tab-cent text-1 font-weight-bold">Seguimiento</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


    @endsection
    @section('js')
        @routes(['ordenCompra','ordenCompraAdmin'])
        <script src="{{ asset('asset/js/orden_compra_show_admin.js') }}" type="text/javascript"></script>
    @endsection