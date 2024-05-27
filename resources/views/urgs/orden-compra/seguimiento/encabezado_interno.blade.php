<div class="row my-5 d-flex justify-content-center hr">
    <div class="col-8 text-center">
        <h1 class="text-1">{{ session()->get('nombreProveedor') }}</h1>
        <p class="text-14 mb-2">{{ $tituloEtapa }}</p>
        <p class="text-1 mb-2">ID ORDEN DE COMPRA:<a class="text-gold ml-2" href="{{ route('orden_compra.show', ['orden_compra' => session()->get('ordenCompraId')]) }}"> {{ session()->get('ordenCompraReqId') }} </a></p>
        <a href="{{ route('orden_compra_urg.index', ['id' => session()->get('ordenCompraEstatus')] ) }}" class="text-goldoc">
            <i class="fa-solid fa-arrow-left text-gold"></i>
            Regresar
        </a>
    </div>
</div>