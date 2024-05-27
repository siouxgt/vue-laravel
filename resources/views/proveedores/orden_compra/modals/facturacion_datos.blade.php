<div class="modal fade" id="modal_facturacion_datos" tabindex="-1" role="dialog" aria-labelledby="modal_facturacion_datos"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title text-rojo" id="exampleModalLongTitle">Datos de facturación</h5>
                <button type="button" class="close text-rojo-titulo" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-1">Razón social</p>
                <p class="text-1 font-weight-bold mb-2">{{ $datosFacturacion[0]->razon_social }}</p>

                <p class="text-1 mt-2">RFC</p>
                <p class="text-1 font-weight-bold mb-2">{{ $datosFacturacion[0]->rfc_fiscal }}</p>

                <p class="text-1 mt-2">Domicilio fiscal</p>
                <p class="text-1 font-weight-bold mb-2">
                    {{ $datosFacturacion[0]->domicilio_fiscal }}
                </p>

                <p class="text-1 mt-2">Método de pago</p>
                <p class="text-1 mb-2"><strong>{{ $datosFacturacion[0]->metodo_pago }}</strong></p>

                <p class="text-1 mt-2">Forma de pago</p>
                <p class="text-1 font-weight-bold mb-2">{{ $datosFacturacion[0]->forma_pago }}</p>

                <p class="text-1 mt-2">Uso del CFDI</p>
                <p class="text-1 font-weight-bold mb-2">{{ $datosFacturacion[0]->uso_cfdi }}</p>
            </div>
        </div>
    </div>
</div>
