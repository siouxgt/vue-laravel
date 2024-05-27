@extends('layouts.admin')

    @section('content')
        @include('admin.contrato-marco.submenu')
        <!-- datos generales y anexos -->
        <div class="container">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link mz-2 active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                        <h4 class="text-activo">URG</h4>
                    </button>
                </div>
            </nav>
            <div class="tab-content border" id="nav-tabContent">
                <!-- datos generales -->
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <h2 class="titl-1">1. Habilita URGs</h2>
                    <p class="text-1">Para seleccionar a las Unidades participantes, debes contar con el documento “Acuerdo de Adhesión” por cada URG..</p>
                    <div class="separator"></div>


                    <div class="row ">
                        <div class="col-12 col-md-12 m-3">
                            <button type="button" class="btn btn-white boton-1 boton-add btn-block col-lg-5 col-md-8 p-1 float-end" id="btnAgregarUCM" style="width: auto;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <span>Agregar URGs</span>
                            </button>
                        </div>
                    </div>
                    <div class="separator"> </div>
                    <br>
                    <table class="table justify-content-md-center mb-3" id="tbl_ucm">
                        <input type="hidden" name="id_cm" id="id_cm" value="{{ session('contrato') }}">
                        <thead>
                            <tr>
                                <th scope="col" class="sortable">#</th>
                                <th scope="col" class="sortable">Clave</th>
                                <th scope="col" class="sortable">Unidad Responsable de Gasto (URG)</th>
                                <th scope="col" class="sortable">Fecha de firma</th>
                                <th scope="col" class="tab-cent">Términos específicos</th>
                                <th scope="col" class="tab-cent">Ver más</th>
                                <th scope="col" class="tab-cent">Editar</th>
                                <th scope="col" class="tab-cent">Inhabilitar</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
        </div>
        <hr>
        @if(!$contrato->liberado)
            <div class="container">
                <div class="col-12 float-right" id="liberar">
                    <button class="btn m-2 boton-1" type="button" onclick="liberar()">Liberar Contrato Marco</button>
                </div>
            </div>
        @endif
    @endsection
    @section('js')
        @routes(['contratoMarcoUrg', 'urg','contratosMarco','submenu'])
        <script src="{{ asset('asset/js/cm_urg.js') }}" type="text/javascript"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @endsection