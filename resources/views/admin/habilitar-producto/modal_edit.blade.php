<div class="modal fade" id="edit_producto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frm_producto">
                    <div class="container">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="grupo_revisor" class="text-gold">Convocatoria No.</label>
                                    <select class="form-select text-1" id="grupo_revisor" name="grupo_revisor" required>
                                        <option value="">Seleccione una opción</option>
                                        @foreach($grupoRevisor as $grupo)
                                            @if($habilitarProducto->grupo_revisor_id == $grupo->id_e)
                                                <option value="{{ $grupo->id_e}}" selected>{{ $grupo->convocatoria }}</option>
                                            @else
                                                <option value="{{ $grupo->id_e}}">{{ $grupo->convocatoria }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="text-1 ml-2">Las cotizaciones duran un mes y el cálculo de PMR cada tres meses.</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="form-group">
                                    <label for="precio_maximo" class="text-gold">Precio Máximo (PMR)</label>
                                    <div class="input-group">
                                      <span class="input-group-text">$</span>
                                      <input type="text" class="form-control" name="precio_maximo" id="precio_maximo" value="{{ $habilitarProducto->precio_maximo }}" required>
                                      <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <div class="row">
                            <div class="col-12 col-md-4 mz-2">
                                <div class="form-group">
                                    <label for="fecha_estudio" class="text-1 mx-3">Fecha del estudio</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control text-1" name="fecha_estudio" id="fecha_estudio" required @if($habilitarProducto->fecha_estudio) value="{{ $habilitarProducto->fecha_estudio->format('d/m/Y') }}" @endif required>
                                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6 mz-2">
                                <div class="form-group">
                                    <label for="archivo_estudio_original" class="text-1 mx-3">Estudio de precios</label>
                                    <input type="file" class="form-control text-1" id="archivo_estudio_original" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="archivo_estudio_original" @if(!$habilitarProducto->archivo_estudio_original) required @endif>
                                    @if($habilitarProducto->archivo_estudio_original)
                                        <label class="text-1 mt-3 mx-3">Archivo actual:</label> <a href="{{ asset('storage/precio-maximo/'.$habilitarProducto->archivo_estudio_original) }}" target="_blank" class="text-1">{{ $habilitarProducto->archivo_estudio_original }}</a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-md-6 mz-2">
                                <div class="form-group">
                                    <label for="archivo_estudio_publico" class="text-1 mx-3">Estudio de precios (versión pública)</label>
                                    <input type="file" class="form-control text-1" id="archivo_estudio_publico" aria-describedby="inputGroupFileAddon03" aria-label="Upload" accept=".pdf" name="archivo_estudio_publico" @if(!$habilitarProducto->archivo_estudio_publico) required @endif>
                                    @if($habilitarProducto->archivo_estudio_publico)
                                        <label class="text-1 mt-3 mx-3">Archivo actual:</label> <a href="{{ asset('storage/precio-maximo/'.$habilitarProducto->archivo_estudio_publico) }}" target="_blank" class="text-1">{{ $habilitarProducto->archivo_estudio_publico }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <p class="text-1 ml-2">Fechas límite para cargar, revisar y liberar los productos de este Contrato Marco.</p>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 mz-2">
                                <div class="form-group">
                                    <label for="fecha_formulario" class="text-1 mx-3">1. Creación de formulario</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control text-1" name="fecha_formulario" id="fecha_formulario" required @if($habilitarProducto->fecha_formulario) value="{{ $habilitarProducto->fecha_formulario->format('d/m/Y') }}" @endif required>
                                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mz-2">
                                <div class="form-group">
                                    <label for="fecha_carga" class="text-1 mx-3">2. Carga de producto</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control text-1" name="fecha_carga" id="fecha_carga" required @if($habilitarProducto->fecha_carga) value="{{ $habilitarProducto->fecha_carga->format('d/m/Y') }}" @endif required>
                                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 mz-2">
                                <div class="form-group">
                                    <label for="fecha_administrativa" class="text-1 mx-3">3. Validación adtva</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control text-1" name="fecha_administrativa" id="fecha_administrativa" required @if($habilitarProducto->fecha_administrativa) value="{{ $habilitarProducto->fecha_administrativa->format('d/m/Y') }}" @endif required>
                                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mz-2">
                                <div class="form-group">
                                    <label for="fecha_tecnica" class="text-1 mx-3">4. Validación técnica</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control text-1" name="fecha_tecnica" id="fecha_tecnica" required @if($habilitarProducto->fecha_tecnica) value="{{ $habilitarProducto->fecha_tecnica->format('d/m/Y') }}" @endif required>
                                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4 mz-2">
                                <div class="form-group">
                                    <label for="fecha_publicacion" class="text-1 mx-3">5. Publicación producto</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control text-1" name="fecha_publicacion" id="fecha_publicacion" required @if($habilitarProducto->fecha_publicacion) value="{{ $habilitarProducto->fecha_publicacion->format('d/m/Y') }}" @endif required>
                                        <span class="input-group-addon input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_habilitar_producto" id="id_habilitar_producto" value="{{ $habilitarProducto->id_e}}">
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn boton-1" id="update_producto" onclick="update_producto()">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>