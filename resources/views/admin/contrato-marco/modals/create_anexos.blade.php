<div class="modal fade" id="add_anexos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Adjuntar documentos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="form_subir" enctype="multipart/form-data" id="form_subir">
                        @csrf
                        <div class="row my-4">
                            
                                <div class="col-sm-12 my-1">
                                    <label for="nom_doc">Nombre documento</label>
                                    <select class="custom-select mr-sm-2" id="nom_doc" name="nom_doc" required>
                                        <option value="0" disabled="" selected="">Seleccione</option>
                                        @foreach ($anexos_disponibles as $key => $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endforeach                                        
                                    </select>
                                </div>
                            
                            
                                <div class="col-sm-12 my-1">
                                    <div class="form-group">
                                        <label for="arc_original">Documento original (tamaño maximo aceptado: 30 MB)</label>
                                        <input type="file" class="form-control" id="arc_original" name="arc_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" required>
                                    </div>
                                </div>
                            
                            
                                <div class="col-sm-12 my-1">
                                    <div class="form-group">
                                        <label for="arc_publico">Versión pública (tamaño maximo aceptado: 30 MB)</label>
                                        <input type="file" class="form-control" id="arc_publico" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="arc_publico" required>
                                    </div>
                                </div>
                            

                            <div class="contenedor-barra" id="contenedor-barra">
                                <div class="barra-progreso" id="barra-estado">
                                    <span id="mi-span"></span>
                                </div>
                                <div id="cargando"></div>
                            </div>                            
                        </div>

                        <div class="modal-footer" id="mis-botones">                            
                            <button type="button" class="btn boton-1" disabled>Cancelar</button>
                            <button type="button" class="btn boton-1" id="btn-guardar-anexo">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>