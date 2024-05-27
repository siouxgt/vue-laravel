<div class="modal fade" id="edit_anexo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close">
                    {{-- <span aria-hidden="true">&times;</span> --}}
                </button>
            </div>
            <form class="form-inline my-3" id="frm_edit" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row col-12 p-2">
                        <label for="exampleFormControlInput1" class="mx-3"> Nombre documento</label>
                        <select name="nombre" id="nombre" class="form-control">
                            <option value="{{ $anexo->nombre }}">{{ $anexo->nombre}}</option>
                            <option value="Dictamen">Dictamen</option>
                            <option value="Acta de selección de proveedores">Acta de selección de proveedores </option>
                            <option value="Oto">Otro</option>
                        </select>
                    </div>
                    <div class="form-group m-2">
                        <label>Documento actual: {{ $anexo->archivo_original }}</label>
                    </div>
                    <div class="form-group m-2">
                        <label for="exampleFormControlFile1">Documento original</label>
                        <input type="file" class="form-control" id="archivo_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="archivo_original">
                    </div>
                     <div class="form-group m-2">
                        <label>Documento actual: {{ $anexo->archivo_publica}}</label>
                    </div>
                    <div class="form-group m-2">
                        <label for="exampleFormControlFile1">Versión pública</label>
                        <input type="file" class="form-control" id="archivo_publica" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="archivo_publica">
                    </div>
                </div>
                <input type="hidden" name="id_anexo" id="id_anexo" value="{{ $anexo->id_e }}">
            </form>
            <div class="modal-footer">
                <button type="button" class="btn boton-1" onclick="anexosUpdate();">Actualizar</button>
            </div>
        </div>
    </div>
</div>