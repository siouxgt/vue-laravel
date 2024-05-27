<div class="modal fade" id="add_urg_cm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Agregar URG participante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <ul id="alerta_guardado_ucm"></ul>
                    <form class="form-group text-1" id="frmUCM">
                        <input type="hidden" id="id_cm" name="id_cm" value="2">
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="id_urg">URG participante</label>
                                    <select class="form-control text-1" id="id_urg" name="id_urg">
                                        <option disabled="" selected="" value="0">Seleccione</option>
                                        <?php
                                        for ($i = 0; $i < count($urgs); $i++) {
                                            echo '<option value=' . $urgs[$i]->id . '>' . $urgs[$i]->nombre . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="fecha_firma" class="text-1">Fecha de firma</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" name="fecha_firma" id="fecha_firma">
                                        <span class="input-group-addon input-group-text" id="fecha_firma"><i class="fa fa-calendar" id="fecha_firma"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="terminos_especificos">Firma terminos especificos</label>
                                    <input type="file" class="form-control" id="terminos_especificos" name="terminos_especificos" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="numero_archivo_adhesion">Numero archivo adhesión</label>
                                    <input type="text" class="form-control text-1" id="numero_archivo_adhesion" name="numero_archivo_adhesion" required>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn boton-1" id="btn_guardar_ucm">Guardar</button>
            </div>
        </div>
    </div>
</div>