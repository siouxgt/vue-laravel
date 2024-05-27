<div class="row my-5 d-flex justify-content-center hr">
	<div class="col-8 text-center">
		<h1 class="text-14">{{ $ordenCompraEstatus->proveedor->nombre }}</h1>
		<p class="text-1 mb-2">ID ORDEN DE COMPRA:<span class="text-gold ml-2"> {{ $ordenCompraEstatus->ordenCompra->orden_compra }}</span></p>
    <a href="{{ route('orden_compra_admin.show', ['id' => session()->get('ordenCompraId')]) }}" class="text-goldoc" >
          <i class="fa-solid fa-arrow-left text-gold"></i>Regresar
    </a>
  </div>
</div>