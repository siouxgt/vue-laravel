@forelse($opiniones as $opinion)
  	<div class="col-sm-9 col-md-4 col-lg-2 mt-4 d-flex justify-content-start">
        @for($i = 1; $i <= 5; $i++)
        	@if($opinion->calificacion)
	        	@if($i <= $opinion->calificacion)
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
    </div>
@empty
	<p class="text-1">Sin Opiniones</p>
@endforelse