<div class="modal fade" id="edit_urg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>
            <div class="modal-body">
                <ul id="save_msgList"></ul>
                <form id="frm_urg" enctype="multipart/form-data" method="POST">

                    <div class="container">
                        <div class="row align-items-end my-3">
                            <div class="col-sm-12 col-md">
                                <div class="form-group ccg-1">
                                    <label for="ccg">Clave del Centro Gestor</label>
                                    <input type="text" class="form-control tex-2" name="ccg" id="ccg"
                                        value="{{ $urg->ccg }}">
                                </div>
                            </div>

                            {{-- Construccion de arreglo con items para select  --}}
                            @php
                                // listado
                                $tipoUrg = [
                                    'DEPENDENCIA',
                                    'ÓRGANO DESCONCENTRADO',
                                    'ADMINISTRACIÓN PARAESTATAL',
                                    'ALCALDÍA',
                                    'ORGANISMO AUTÓNOMO',
                                ];
                                //Indice
                                $indice = 1;
                            @endphp
                            <div class="col-sm-12 col-md-4 mr-5">
                                
                                    <label for="tipo">Tipo de URG</label>
                                    <select class="form-select mr-3 text-2" id="tipo" name="tipo" required>
                                        <option value="0" disabled="" selected="">Seleccione</option>
                                        {{-- Construccion de las opciones (tipo de urg) con blade --}}
                                        @foreach ($tipoUrg as $item)
                                            <option value="{{ $indice }}"
                                                @if ($urg->tipo == $indice) selected='selected' @endif>
                                                {{ $item }}</option>
                                            @php
                                                $indice++;
                                            @endphp
                                        @endforeach
                                    </select>
                                
                            </div>
                            <div class="col-sm-12 col-md-2 text-align-center px-3">
                                <div class="ml-4">
                                    <label for="formGroupExampleInput">Activo</label>
                                    <div class="custom-control custom-switch">
                                        <label class="switch">
                                            <input type="checkbox" name="estatus" id="estatus" value="1"
                                                @if ($urg->estatus) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2 text-align-center px-3">
                                <div class="ml-4">
                                    <label for="validadora">URG validadora</label>
                                    <div class="custom-control custom-switch">
                                        <label class="switch">
                                            <input type="checkbox" name="validadora" id="validadora" value="1"
                                                @if ($urg->validadora) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row my-3">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="nombre_">Unidad responsable de gasto (URG)</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre"
                                        value="{{ $urg->nombre }}" readonly="">
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="direccion">Domicilio URG</label>
                                    <input type="text" class="form-control" name="direccion" id="direccion"
                                        value="{{ $urg->direccion }}" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>



                    </div>


                    <div class="row my-3">
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="fecha_adhesion">Monto de actuación</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="input-group date">
                                <input type="number" class="form-control text-1" name="monto_actuacion"
                                    id="monto_actuacion" value="{{ $urg->monto_actuacion }}">
                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-12 col-sm-4">
                            <div class="form-group">
                                <label for="fecha_adhesion">Adhesión a Contrato Marco</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="input-group date">
                                <input type="text" class="form-control" name="fecha_adhesion" id="fecha_adhesion"
                                    value="{{ date('d/m/Y', strtotime($urg->fecha_adhesion)) }}">
                                <span class="input-group-addon input-group-text" id="basic-addon1"><i
                                        class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col-12 col-sm-2">
                            <div class="form-group">
                                <label for="fecha_adhesion">Archivo actual</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-10">
                            <div class="form-group">
                                <input type="text" class="form-control" name="rutarc" id="rutarc"
                                    value="{{ $urg->archivo }}" disabled>
                                <input type="hidden" id="id" name="id" value="{{ $urg->id_e }}">
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-12 col-sm-2">
                            <div class="form-group">
                                <label for="fecha_adhesion">Nuevo archivo</label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-10">
                            <div class="form-group">
                                <input type="file" class="form-control text-2" id="archivo" name="archivo"
                                    aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf">
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton-1" id="store_urg"
                    onclick="urg_update();">Actualizar</button>
            </div>
        </div>
    </div>
</div>
</div>
