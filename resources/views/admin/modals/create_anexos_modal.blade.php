<div class="modal fade" id="add_anexo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button"class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>
            <form class="form-inline my-3" id="frm_anexo" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row col-12 my-3 p-2">
                        <label for="exampleFormControlInput1" class="mx-3"> Nombre documento</label>
                        <select name="nombre" id="nombre" class="form-control" required>
                            <option value="">Selecciones una opción</option>
                            <option value="Dictamen">Dictamen</option>
                            <option value="Acta de selección de proveedores">Acta de selección de proveedores</option>
                            <option value="Oto">Otro</option>
                        </select>
                    </div>
                    <div class="form-group m-2 my-3">
                        <label for="exampleFormControlFile1">Documento original</label>
                        <input type="file" class="form-control" id="archivo_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="archivo_original" required>
                    </div>
                    <div class="form-group m-2 my-3">
                        <label for="exampleFormControlFile1">Versión pública</label>
                        <input type="file" class="form-control" id="archivo_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="archivo_publica" required>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn boton-1" onclick="anexosSave();">Guardar</button>
            </div>
        </div>
    </div>
</div>