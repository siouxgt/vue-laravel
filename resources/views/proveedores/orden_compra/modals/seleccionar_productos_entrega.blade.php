<div class="modal fade" id="seleccionar_productos_entrega" data-backdrop="static" data-keyboard="false"
    aria-labelledby="ConfirmacionOrdenCompraLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header badge-light">
                <h5 class="modal-title text-rojo" id="ConfirmacionOrdenCompraLabel">Confirmación Orden de compra</h5>
                <button type="button" class="close text-rojo" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-1"><strong>1. ¿Cuándo se entregará el pedido?</strong></p>
                @php
                    $carbon = new \Carbon\Carbon();
                    $fecha_hoy = $carbon->now();
                    $fecha_hoy = $fecha_hoy->format('Y-m-d');
                @endphp
                <form class="form text-2" id="frm_productos_entrega" method="POST"
                    action="{{ route('orden_compra_proveedores.guardar_confirmacion') }}">
                    @csrf
                    <div class="form-group mt-4">
                        <label for="fecha_entrega" class="mr-2">Fecha de entrega</label>
                        <input type="date"
                            @if ($quien == 5) onmousedown="this.showPicker()" id="fecha_entrega" name="fecha_entrega" min="{{ $fecha_hoy }}" required @else value="{{ $ocp[0]->fecha_entrega->format('Y-m-d') }}" disabled @endif>
                    </div>

                    <hr class="mz-2">

                    <p class="text-1">
                        <strong @if ($quien == 5) id="cantidad_productos_seleccionados" @endif>
                            2. Seleccionaste @if ($quien == 5) 0 de
                                {{ $countTodosProducto }}
                            @else
                                {{ $contProductoAceptados }} de {{ $countTodosProducto }} @endif
                            producto(s) para entregar.
                        </strong>
                    </p>
                    <p class="text-2 text-justify">
                        A continuación, procede a seleccionar los productos que sí entregarás.
                        Ten en cuenta que los productos que no selecciones se considerarán como rechazados
                        y no se incluirán en la orden de compra confirmada.
                    </p>

                    <div>
                        <table class="table mt-2 justify-content-md-center ">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <input type="checkbox" class="form-check-input"
                                            @if ($quien == 5) id="chk_producto_seleccionar_todos" @else disabled @if ($countTodosProducto === $contProductoAceptados) checked @endif
                                            @endif>
                                    </th>
                                    <th scope="col" class="tab-cent text-1 font-weight-bold">Todos</th>
                                    <th scope="col" class="sortable tab-cent text-1 font-weight-bold">CLAVECDMX</th>
                                    <th scope="col-4" class="text-1 font-weight-bold">Producto</th>
                                    <th scope="col" class="tab-cent text-1 font-weight-bold">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="tabla_contenido">
                                @foreach ($productos as $key => $item)
                                    <tr>
                                        <td class="text-1">
                                            <input type="checkbox" class="form-check-input"
                                                @if ($quien == 5) id="chk_producto{{ $key }}" name="chk_producto[]" value="{{ $item->id_e }}" @else disabled @if ($item->estatus === 1) checked @endif
                                                @endif>
                                        </td>
                                        <td class="tab-cent text-1">{{ $key + 1 }}</td>
                                        <td class="tab-cent text-1">{{ $item->cabms }}</td>
                                        <td class="text-2"><a href="{{ route('proveedor_fp.show', [$item->id_pfp]) }}_"
                                                Target="_blank"
                                                class="text-gold font-weight-light"><u>{{ strtoupper($item->nombre) }}</u></a>
                                        </td>
                                        <td class="tab-cent text-1">{{ $item->cantidad }} {{ $item->medida }}(s)</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr class="mz-2">

                    <p class="text-1"><strong>3. Productos rechazados</strong></p>
                    <p class="text-2 text-justify">Si rechazaste la entrega de algunos productos, indica la razón. El
                        comprador recibirá esta información. El rechazo
                        de productos no genera incidencias.</p>

                    <div class="form-group mt-4" style="width: 250px;">
                        <label class="text-1" for="motivo_rechazo_producto">Motivo del rechazo de productos</label>
                        <select class="form-control"
                            @if ($quien == 5) id="motivo_rechazo_producto" name="motivo_rechazo_producto" @else disabled @endif>
                            <option value="0" selected>Selecciona el motivo del rechazo</option>
                            <option value="Sin stock suficiente" @if ($ocp[0]->motivo_rechazo === 'Sin stock suficiente') selected @endif>Sin
                                stock suficiente</option>
                            <option value="Unidad de medida incorrecta"
                                @if ($ocp[0]->motivo_rechazo === 'Unidad de medida incorrecta') selected @endif>Unidad de medida incorrecta</option>
                            <option value="Otro" @if ($ocp[0]->motivo_rechazo === 'Otro') selected @endif>Otro</option>
                        </select>
                    </div>

                    <hr class="mt-3 mb-4">

                    <div class="form-group">
                        <label class="text-1" for="txt_a_descripcion_rechazo_producto">Describe la situación</label>
                        <textarea class="form-control" id="txt_a_descripcion_rechazo_producto"
                            @if ($quien == 5) name="txt_a_descripcion_rechazo_producto" @else disabled @endif
                            placeholder="Describe el motivo de tu rechazo del/los producto(s)." rows="3" maxlength="1000">{{ $ocp[0]->descripcion_rechazo }}</textarea>
                    </div>
                    <p class="float-right text-2" id="alerta_cantidad_caracteres" style="margin-top: -0.8rem;"
                        title="1000 (mil) caracteres es lo máximo que se te permite en la descripción de la situación">
                        0/1000</p>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn boton-12"
                    @if ($quien == 5) id="btn_generar_acuse" @else disabled @endif>Generar
                    Acuse</button>
            </div>
        </div>
    </div>
</div>
