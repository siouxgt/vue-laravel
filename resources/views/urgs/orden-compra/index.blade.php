@extends('layouts.urg')

	@section('content')
		<div class="hr">
			<h1 class="m-2 px-3">Órdenes de compra</h1>
    	<p class="text-2 px-4">En esta página encontrarás las compras que has realizado en Contrato Marco. Para ver el detalle de tu compra, da clic en el icono de la columna “Ver más”.</p>
	  </div>

		<div class="container col-md-8">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-4 d-flex mt-1">
          <div class="col-1">
            <span class="badge badge-pill badge-gris-1">{{ $todasCabms->todas }}</span>
          </div>
          <div class="col-11">
            <p class="text-1 ml-2 font-weight-bold">Total CABMSCDMX</p>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 d-flex mt-1">
          <div class="col-1">
            <span class="badge badge-pill badge-secondary">{{ $cabmsConfirmadas->aceptadas }}</span>
          </div>
          <div class="col-11">
            <p class="text-1 ml-2 font-weight-bold">Total CABMSCDMX Confirmadas</p>
          </div>
        </div>
        <div class="col-12 col-md-12 col-lg-4 d-flex mt-1">
          <div class="col-1">
            <span class="badge badge-pill badge-red-1">{{ $cabmsRechazadas->rechazadas }}</span>
          </div>
          <div class="col-11">
            <p class="text-1 ml-2 font-weight-bold">Total CABMSCDMX Rechazadas</p>
          </div>
        </div>
      </div>
    </div>
    <hr class="mx-5">

    <div class="row elemtos">
			<div class="col-12 col-lg-2 col-md-2 col-sm-8  offset-md-5">
        <p class="boton-11 rounded mt-1 mb-1">Total Órdenes de compra:<span class="text-9 font-weight-bold ml-1">{{ $totalOC }}</span></p>
			</div>
		</div>

		<div class="container-fluid my-5">
			<table class="table my-5 justify-content-md-center" id="table_orden_compra">
				<thead>
					<tr>
						<th scope="col"></th>
						<th scope="col" class="sortable tab-cent text-1 font-weight-bold">Id orden</th>
						<th scope="col" class="sortable tab-cent text-1 font-weight-bold">Fecha</th>
						<th scope="col" class="sortable tab-cent text-1 font-weight-bold">Requisición</th>
            <th scope="col" class="tab-cent text-1 font-weight-bold">Proveedores</th>
            <th scope="col" class="tab-cent text-1 font-weight-bold">CABMSCDMX</th>
            <th scope="col" class="sortable tab-cent text-1 font-weight-bold">CABMSCDMX Confirmadas</th>
            <th scope="col" class="sortable tab-cent text-1 font-weight-bold">CABMSCDMX Rechazadas</th>
            <th scope="col" class="sortable tab-cent text-1 font-weight-bold">Total de compra</th>
						<th scope="col" class="tab-cent text-1 font-weight-bold">Ver más</th>
						<th scope="col" class="tab-cent text-1 font-weight-bold">Acuse</th>
					</tr>
				</thead>
			</table>
		</div>	

	@endsection
	@section('js')
        @routes(['ordenCompra','solicitudCompra','tiendaUrg'])
        <script src="{{ asset('asset/js/orden_compra_urg.js') }}" type="text/javascript"></script>
  @endsection