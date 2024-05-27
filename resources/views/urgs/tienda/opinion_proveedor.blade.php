@extends('layouts.urg')

	@section('content')
		  <div class="row">
		      <p class="mt-3 ml-5 mb-4 d-flex align-items-center">
		          <a href="javascript: void(0);" onclick="history.back();" class="gold-3"><i class="fa-solid fa-arrow-left gold"></i>Regresar</a>
		        </p>
		  </div>

		  <div class="separator mb-3"></div>

		  <div class="text-1">
		      <h1 class="m-2 p-3 mt-1">OPINIONES DEL PROVEEDOR</h1>
		      <nav aria-label="breadcrumb">
		          <ol class="breadcrumb text-2">
		              <li class="breadcrumb-item"><a href="{{ route('tienda_urg.index') }}">Inicio</a></li>
		              <li class="breadcrumb-item"><a href="{{ route('tienda_urg.ver_tienda') }}">Tienda</a></li>
		              {{-- <li class="breadcrumb-item"><a href="{{ route('tienda_urg.show', ['tienda_urg' => $producto->id_e] ) }}">{{ $producto->nombre_producto}}</a></li> --}}
		              <li class="breadcrumb-item active" aria-current="page">Opiniones de {{ $proveedor->nombre }}</li>
		          </ol>
		      </nav>
		  </div>

		  <div class="row mt-3 d-flex align-items-center">
		      <div class="col-md-1 col-sm-12 text-right">
		          {{-- <img src="{{ asset('storage/img-producto-pfp/'.$proveedor->imagen) }}" class="imag-carrito-2 border" alt="/"> --}}
		      </div>
		  </div>

		  <div class="col-md-2 col-sm-12 mb-3">
		        <label class="my-1 mr-2" for="estrellas">Ordernar por</label>
		        <select class="custom-select my-1 mr-sm-2" id="estrellas" name="estrellas" onclick="filtroProveedor('{{$proveedor->id_e}}')">
		            <option value='0'>Selecciona una opción...</option>
		            <option value="1">1 estrella</option>
		            <option value="2">2 estrellas</option>
		            <option value="3">3 estrellas</option>
		            <option value="4">4 estrellas</option>
		            <option value="5">5 estrellas</option>
		        </select>
		  </div>
		  
		

		<!-- -------opiniones---------- -->
		<div class="section mt-3 mx-5">
		   
		  <p class="text-1 font-weight-bold">Opiniones de URG</p>

		  <div class="row">
		    <div class="col-md-3 col-sm-6">
		      	<p class="text-11 ml-2 mt-2">@if($calificacionTotal != 0) {{ $calificacionTotal/count($opiniones) }} @else 0 @endif /5</p>
		      	<div class="col-sm-4 col-md-8 col-gl-6 mt-2 justify-content-start">
			       	@for($i = 1; $i <= 5; $i++ )
	                    @if($calificacionTotal != 0)
	                        @php 
	                            $restante = (($calificacionTotal / count($opiniones)) - intval($calificacionTotal / count($opiniones))) *100;
	                        @endphp
	                        @if($i <= intval($calificacionTotal / count($opiniones)))
	                            <i class='fa-solid fa-star estrella active'></i>
	                            @if($restante >= 50 && $i == intval($calificacionTotal / count($opiniones)))
	                                <i class='fa-solid fa-star-half-stroke estrella active'></i>
	                                @php $i++; @endphp
	                            @endif
	                        @else
	                            <i class="fa-solid fa-star estrella"></i>
	                        @endif
	                    @else
	                        <i class="fa-solid fa-star estrella"></i>
	                    @endif
	                @endfor
		      	</div>
		      	<div class="mt-2">
		        	<p class="text-2">Basado en {{ count($opiniones) }} opiniones</p>
		      	</div>

		    	<div class="row mt-4">
	            	<div class="col-7">
	              	<p class="text-2">Comunicación</p>
	            	</div>
		            <div class="col-5 d-flex justify-content-start">
		              @for($i = 1; $i <= 5; $i++ )
	                    @if($comunicacionTotal != 0)
	                        @php 
	                            $restante = (($comunicacionTotal / count($opiniones)) - intval($comunicacionTotal / count($opiniones))) *100;
	                        @endphp
	                        @if($i <= intval($comunicacionTotal / count($opiniones)))
	                            <i class='fa-solid fa-star estrella active'></i>
	                            @if($restante >= 50 && $i == intval($comunicacionTotal / count($opiniones)))
	                                <i class='fa-solid fa-star-half-stroke estrella active'></i>
	                                @php $i++; @endphp
	                            @endif
	                        @else
	                            <i class="fa-solid fa-star estrella"></i>
	                        @endif
	                    @else
	                        <i class="fa-solid fa-star estrella"></i>
	                    @endif
	                @endfor
		            </div>
	          	</div>

	          	<div class="row mt-4">
	            	<div class="col-7">
	              	<p class="text-2">Calidad/Precio</p>
	            	</div>
		            <div class="col-5 d-flex justify-content-start">
		              @for($i = 1; $i <= 5; $i++ )
	                    @if($calidadTotal != 0)
	                        @php 
	                            $restante = (($calidadTotal / count($opiniones)) - intval($calidadTotal / count($opiniones))) *100;
	                        @endphp
	                        @if($i <= intval($calidadTotal / count($opiniones)))
	                            <i class='fa-solid fa-star estrella active'></i>
	                            @if($restante >= 50 && $i == intval($calidadTotal / count($opiniones)))
	                                <i class='fa-solid fa-star-half-stroke estrella active'></i>
	                                @php $i++; @endphp
	                            @endif
	                        @else
	                            <i class="fa-solid fa-star estrella"></i>
	                        @endif
	                    @else
	                        <i class="fa-solid fa-star estrella"></i>
	                    @endif
	                @endfor
		            </div>
	          	</div>

	          	<div class="row mt-4">
	            	<div class="col-7">
	              	<p class="text-2">Tiempo de entrega</p>
	            	</div>
		            <div class="col-5 d-flex justify-content-start">
		              @for($i = 1; $i <= 5; $i++ )
	                    @if($tiempoTotal != 0)
	                        @php 
	                            $restante = (($tiempoTotal / count($opiniones)) - intval($tiempoTotal / count($opiniones))) *100;
	                        @endphp
	                        @if($i <= intval($tiempoTotal / count($opiniones)))
	                            <i class='fa-solid fa-star estrella active'></i>
	                            @if($restante >= 50 && $i == intval($tiempoTotal / count($opiniones)))
	                                <i class='fa-solid fa-star-half-stroke estrella active'></i>
	                                @php $i++; @endphp
	                            @endif
	                        @else
	                            <i class="fa-solid fa-star estrella"></i>
	                        @endif
	                    @else
	                        <i class="fa-solid fa-star estrella"></i>
	                    @endif
	                @endfor
		            </div>
	          	</div>

	          	<div class="row mt-4">
	            	<div class="col-7">
	              	<p class="text-2">Mercancía en buen estado</p>
	            	</div>
		            <div class="col-5 d-flex justify-content-start">
		              @for($i = 1; $i <= 5; $i++ )
	                    @if($mercanciaTotal != 0)
	                        @php 
	                            $restante = (($mercanciaTotal / count($opiniones)) - intval($mercanciaTotal / count($opiniones))) *100;
	                        @endphp
	                        @if($i <= intval($mercanciaTotal / count($opiniones)))
	                            <i class='fa-solid fa-star estrella active'></i>
	                            @if($restante >= 50 && $i == intval($mercanciaTotal / count($opiniones)))
	                                <i class='fa-solid fa-star-half-stroke estrella active'></i>
	                                @php $i++; @endphp
	                            @endif
	                        @else
	                            <i class="fa-solid fa-star estrella"></i>
	                        @endif
	                    @else
	                        <i class="fa-solid fa-star estrella"></i>
	                    @endif
	                @endfor
		            </div>
	          	</div>

	          	<div class="row mt-4">
	            	<div class="col-7">
	              	<p class="text-2">Facturas carectas</p>
	            	</div>
		            <div class="col-5 d-flex justify-content-start">
		              @for($i = 1; $i <= 5; $i++ )
	                    @if($facturasTotal != 0)
	                        @php 
	                            $restante = (($facturasTotal / count($opiniones)) - intval($facturasTotal / count($opiniones))) *100;
	                        @endphp
	                        @if($i <= intval($facturasTotal / count($opiniones)))
	                            <i class='fa-solid fa-star estrella active'></i>
	                            @if($restante >= 50 && $i == intval($facturasTotal / count($opiniones)))
	                                <i class='fa-solid fa-star-half-stroke estrella active'></i>
	                                @php $i++; @endphp
	                            @endif
	                        @else
	                            <i class="fa-solid fa-star estrella"></i>
	                        @endif
	                    @else
	                        <i class="fa-solid fa-star estrella"></i>
	                    @endif
	                @endfor
		            </div>
	          	</div>

	          	<div class="row mt-4">
	            	<div class="col-7">
	              	<p class="text-2">Proceso de compra</p>
	            	</div>
		            <div class="col-5 d-flex justify-content-start">
		              @for($i = 1; $i <= 5; $i++ )
	                    @if($procesoTotal != 0)
	                        @php 
	                            $restante = (($procesoTotal / count($opiniones)) - intval($procesoTotal / count($opiniones))) *100;
	                        @endphp
	                        @if($i <= intval($procesoTotal / count($opiniones)))
	                            <i class='fa-solid fa-star estrella active'></i>
	                            @if($restante >= 50 && $i == intval($procesoTotal / count($opiniones)))
	                                <i class='fa-solid fa-star-half-stroke estrella active'></i>
	                                @php $i++; @endphp
	                            @endif
	                        @else
	                            <i class="fa-solid fa-star estrella"></i>
	                        @endif
	                    @else
	                        <i class="fa-solid fa-star estrella"></i>
	                    @endif
	                @endfor
		            </div>
	          	</div>

		    </div>

		    <div class="row col-md-8 col-sm-6 border-left ml-3" id="comentarios">
			    @if($opiniones != [])	
			    	@foreach($opiniones as $opinion)
				      	<div class="col-sm-9 col-md-4 col-lg-2 mt-4 d-flex justify-content-start">
					        @for($i = 1; $i <= 5; $i++)
					        	@if($opinion->general)
						        	@if($i <= $opinion->general)
						        		<i class='fa-solid fa-star estrella active'></i>
						        	@else
			                        	<i class="fa-solid fa-star estrella"></i>
		                    		@endif
			                    @else
		                        	<i class="fa-solid fa-star estrella"></i>
					        	@endif
					        @endfor
					    </div>
					    <div class="col-sm-12 col-md-8 col-lg-10 mt-4">
					       	<div>
					       		<p class="text-1">
					           		{{ $opinion->comentario }}
					       		</p>
					       	</div>
					       	<div class="mt-3">
					       		<p class="text-1 font-weight-bold">
					           		{{ $opinion->nombre }}
					       		</p>
					       		<p class="text-2">{{ $opinion->fecha_creacion }}</p>
					    	</div>
					    	<hr>
					    </div>
				    @endforeach
				@else 
    				<p class="text-1">Sin Opiniones</p>
    			@endif
		    </div>
		  </div>
		</div>
	@endsection
	@section('js')
		@routes(['tiendaUrg'])
		<script src="{{ asset('asset/js/opiniones.js') }}" type="text/javascript"></script>
	@endsection