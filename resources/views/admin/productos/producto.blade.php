@foreach($productos as $key => $producto)
	@php 
		$fotos = [$producto->foto_uno,$producto->foto_dos,$producto->foto_tres,$producto->foto_cuatro,$producto->foto_cinco,$producto->foto_seis]; 
		for($i = 0; $i <= count($fotos); $i++){
			if($fotos[$i] != null){
				$ruta = $fotos[$i];
				break;
			}
		}
	@endphp
	
	<div class="col-12 col-md-4 col-lg-2 mt-3 mt-3 mb-4">
        <div class="row d-flex align-items-center">
            <div class="col-12 overflow-string">
                <h5 class="text-gold-4 ml-2" title="{{$producto->cabms}} - {{$producto->descripcion }}"> {{ $producto->cabms }}  -  {{ $producto->descripcion }} </h5>
            </div>
        </div>
    	<div>
		    <div class="border rounded">
		    	<a href="{{ route('producto_admin.show', $producto->id_e) }}">
			        <div class="row p-2">
			            @if ($producto->nuevo)
			                <p class="badge-secondary ml-3">Nuevo</p>
			            @else
			                <div class="mt-3"> </div>
			            @endif
					</div>
			        <div class="text-center">
						<img class="imag-card text-center" src="{{ asset('storage/img-producto-pfp/' . $ruta) }}" alt='Foto...'>
			        </div>
			        <div class="p-3">
			        	<p class="text-2 text-truncate">Proveedor:  {{ ucfirst(strtolower($producto->proveedor)) }} </p>
			            <p class="text-2 text-truncate">Marca:  {{ ucfirst(strtolower($producto->marca)) }} </p>
			            <p class="text-truncate text-gold mt-2" title="{{ strtoupper($producto->nombre_producto) }}"> {{ strtoupper($producto->nombre_producto) }} </p>
			            <div class="text-2 text-truncate">
			                Tamaño: {{ ucfirst(strtolower($producto->tamanio)) }}
			            </div>
			            <div class="text-1">
			                <strong>$ {{number_format($producto->precio_unitario, 2) }}</strong> <span class="ml-1">x 1 {{ $producto->medida}} </span>
			            </div >
			        </div >
			        <div class='separator mb-3'></div>
			        <div class='m-1 ml-3 mb-4'>
			        	@for($i = 1; $i <= 5; $i++ )
			        		@if($producto->calificacion)
			        			@php 
                    				$restante = (($producto->calificacion / $producto->total_evaluaciones) - intval($producto->calificacion / $producto->total_evaluaciones)) *100;
                				@endphp
			        			@if($i <= ceil($producto->calificacion / $producto->total_evaluaciones))
				            		<i class='fa-solid fa-star estrella active'></i>
				            		@if($restante >= 50 && $i == intval($producto->calificacion / $producto->total_evaluaciones))
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
			    </a>
		    </div>
		</div>
    </div>	
@endforeach