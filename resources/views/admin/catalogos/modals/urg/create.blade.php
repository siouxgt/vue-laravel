<div class="modal fade" id="add_urg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Agregar URG</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>
            <div class="modal-body">

                <ul id="save_msgList"></ul>

                <form id="frm_urg" enctype="multipart/form-data" method="POST">
                    <div class="container align-items-end">
                        <div class="row align-items-end my-3">
                            <div class="col-sm-12 col-md-4">
                                <div class="ccg-1 ">
                                    <label for="ccg">Clave del Centro Gestor</label>
                                    <input type="text" class="form-control" name="ccg" id="ccg" required minlength="6" maxlength="6">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 ">
                                
                                    <label for="tipo">Tipo de URG</label>
                                    <select class="form-select text-2" id="tipo" name="tipo" aria-label="Default select example" required>
                                        <option value="0" disabled="" selected="">Seleccione</option>
                                        <option value="1">DEPENDENCIA</option>
                                        <option value="2">ÓRGANO DESCONCENTRADO</option>
                                        <option value="3">ADMINISTRACIÓN PARAESTATAL</option>
                                        <option value="4">ALCALDÍA</option>
                                        <option value="5">ORGANISMO AUTÓNOMO</option>
                                    </select>
                                
                            </div>
                            <div class="col-sm-6 align-self-center col-md-2 align-items-end my-3">
                                
                                    <label for="formGroupExampleInput">Activo</label>
                                    <div class="custom-control custom-switch align-self-center">
                                        <label class="switch ">
                                            <input type="checkbox" name="estatus" id="estatus" value="1" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                            </div>
                            <div class="col-sm-6 align-self-center col-md-2 align-items-end my-3">
                                
                                    <label for="validadora">URG validadora</label>
                                    <div class="custom-control custom-switch align-self-center">
                                        <label class="switch">
                                            <input type="checkbox" name="validadora" id="validadora" value="1">
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                            </div>
                        </div>

                        <div class="row align-items-center justify-content-center my-3">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="nombre">Unidad responsable de gasto (URG)</label>
                                    <input type="text" class="form-control" name="nombre" id="nombre" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-12 col-sm-12 ">
                                <div class="form-group">
                                    <label for="direccion">Domicilio URG</label>
                                    <select class="form-select text-2" id="direccion" name="direccion" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                       {{--  <div class="row" id="global">
                            <div id="miscroll" class="col-12 col-sm-12 scroll container">
                            </div>
                        </div> --}}
                        <hr>


                        <div class="row my-3">
                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    <label for="fecha_adhesion">Monto de actuación</label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="input-group date">
                                    <input type="number" class="form-control text-1" name="monto_actuacion" id="monto_actuacion" required>
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
                                <div class="input-group date hoyant">
                                    <input type="text" class="form-control text-1" name="fecha_adhesion" id="fecha_adhesion">
                                    <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row align-items-center my-3">
                            <div class="col-sm-12 my-1">
                                <div class="form-group">
                                    <input type="file" class="form-control text-2" id="archivo" name="archivo" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" required="">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn boton-1 create_urg" id="create_urg">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>