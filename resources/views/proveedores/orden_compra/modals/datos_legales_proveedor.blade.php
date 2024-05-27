<div class="modal fade" id="datos_legales_proveedor" data-backdrop="static" data-keyboard="false" aria-labelledby="DatosLegalesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header badge-light">
                <h5 class="modal-title text-rojo" id="DatosLegalesLabel">Datos legales y fiscales</h5>
                <button type="button" class="close text-rojo" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row cajasElementos">
                    <div class="col">
                        <form>
                            <p class="text-3 mb-3">Representante legal</p>
                            <div class="form-group">
                                <label for="#">Persona</label>
                                <input class="form-control" type="text" value="{{ $proveedor->persona }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="#">RFC</label>
                                <input class="form-control" type="text" value="{{ $proveedor->rfc }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="#">Nombre completo</label>
                                <input class="form-control" type="text" value="{{ $proveedor->nombre_legal }} {{ $proveedor->primer_apellido_legal }} {{ $proveedor->segundo_apellido_legal }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="#">Domicilio</label>
                                <input class="form-control px-3" type="text" value="{{ $proveedor->tipo_vialidad }} {{ $proveedor->vialidad }}, NÚM. EXT. {{ $proveedor->numero_exterior }}, @if($proveedor->numero_interior != null) NÚM. INT. {{ $proveedor->numero_interior }}, @endif {{ $proveedor->colonia }}, C.P. {{ $proveedor->codigo_postal }}, {{ $proveedor->alcaldia }}, {{ $proveedor->entidad_federativa }}, {{ $proveedor->pais }}" readonly>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="#">Número fíjo</label>
                                    <input class="form-control" type="text" value="{{ $proveedor->telefono_legal }}" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="#">Extensión</label>
                                    <input class="form-control" type="text" value="{{ $proveedor->extension_legal }}" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="#">Número celular</label>
                                    <input class="form-control" type="text" value="{{ $proveedor->celular_legal }}" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn boton-12" id="btn_cerrar_datos_legales_proveedor" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>