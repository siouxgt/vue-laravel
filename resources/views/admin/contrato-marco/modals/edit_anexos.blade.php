<div class="modal fade" id="edit_anexos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Adjuntar documentos (Modificar)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="frm_acm_edit" id="frm_acm_edit" enctype="multipart/form-data" method="POST">
                        @method('PUT')
                        <div class="row my-3">
                            <div class="form-row align-items-center">
                                <div class="col-sm-12 my-1">
                                    <p>Nombre documento</p>
                                    <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Nombre
                                        documento</label>
                                    <select class="custom-select mr-sm-2" id="nom_doc" name="nom_doc" required>
                                        <option value="0" disabled="" selected="">Seleccione</option>
                                        @foreach ($documentos_disponibles as $item)
                                            <option value="{{ $item }}"
                                                @if ($acm->nombre_documento == $item) selected='selected' @endif>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row align-items-center">
                                <div class="col-sm-12 my-1">
                                    <div class="form-group">
                                        <label for="arc_original_a">Documento original (su archivo actual)</label>
                                        <input type="text" class="form-control" id="arc_original_a"
                                            name="arc_original_a" aria-describedby="inputGroupFileAddon03" disabled
                                            value="{{ $acm->archivo_original }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row align-items-center">
                                <div class="col-sm-12 my-1">
                                    <div class="form-group">
                                        <label for="arc_original">Documento original (tamaño maximo aceptado: 30
                                            MB)</label>
                                        <input type="file" class="form-control" id="arc_original" name="arc_original"
                                            aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row align-items-center">
                                <div class="col-sm-12 my-1">
                                    <div class="form-group">
                                        <label for="arc_publico_a">Versión pública (su archivo actual)</label>
                                        <input type="text" class="form-control" id="arc_publico_a"
                                            name="arc_publico_a" aria-describedby="inputGroupFileAddon03" disabled
                                            value="{{ $acm->archivo_publico }}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-row align-items-center">
                                <div class="col-sm-12 my-1">
                                    <div class="form-group">
                                        <label for="arc_publico">Versión pública (tamaño maximo aceptado: 30 MB)</label>
                                        <input type="file" class="form-control" id="arc_publico"
                                            aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf"
                                            name="arc_publico">
                                    </div>
                                </div>
                            </div>

                            <div class="contenedor-barra" id="contenedor-barra">
                                <!-- barra-->
                                <div class="barra-progreso" id="barra-estado">
                                    <span id="mi-span"></span>
                                </div>
                                <div id="cargando"></div>
                            </div>

                            <input type="hidden" id="id_acm" name="id_acm" value="{{ $acm->id }}">
                            <input type="hidden" id="contrato_marco_id" name="contrato_marco_id"
                                value="{{ $acm->contrato_marco_id }}">
                        </div>

                        <div class="modal-footer" id="mis-botones">
                            <button type="button" class="btn boton-1" id="btn-actualizar-anexo">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
