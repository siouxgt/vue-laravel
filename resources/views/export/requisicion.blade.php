<table>
	<thead>
		<tr>
			<th colspan="8">COTIZACIÓN DE REQUICISIÓN EN LA PLATAFORMA CONTRATO MARCO </th>
		</tr>
	</thead>
	<tbody>
		<tr></tr>
		<tr>
			<td></td>
			<td>Unidad compradora</td>
			<td>{{ $requisicion->urg->nombre}}</td>
		</tr>
		<tr>
			<td></td>
			<td>ID Requisición</td>
			<td>{{ $requisicion->requisicion}}</td>
		</tr>
		<tr>
			<td></td>
			<td>Objeto de requisición</td>
			<td>{{ $requisicion->objeto_requisicion}}</td>
		</tr>
		<tr>
			<td></td>
			<td>Monto autorizado</td>
			<td>{{ $requisicion->monto_autorizado}}</td>
		</tr>
		<tr>
			<td></td>
			<td>Monto adjudicado</td>
			<td>{{ $requisicion->monto_adjudicado}}</td>
		</tr>
		<tr>
			<td></td>
			<td>Monto disponible</td>
			<td>{{ $requisicion->monto_disponible }}</td>
		</tr>
		<tr></tr>
		<tr>
			<td colspan="2">Claves presupuestarias</td>
			<td>Partida presupuestal</td>
			<td>Valor estimado</td>
		</tr>
		@foreach($requisicion->clave_partida as $key => $bien)
			<tr>
				<td colspan="2">{{ $bien->clave_presupuestaria }}</td>
				<td>{{ $bien->partida }}</td>
				<td>{{ $bien->valor_estimado }}</td>
			</tr>
		@endforeach
		<tr></tr>
		<tr>
			<td>#</td>
			<td> CABMSCDMX</td>
			<td>Bien y/o servicio</td>
			<td>Especificación</td>
			<td>Unidad de medida </td>
			<td>Cantidad</td>
			<td>PMR</td>
			<td>Subtotal PMR</td>
			<td>IVA PMR</td>
			<td> Total PMR</td>
		</tr>
		@php 
			$totalCantidad = 0; 
			$totalPmr = 0; 
			$totalSub = 0; 
			$totalIva = 0; 
			$totalTotal = 0; 

		@endphp 
		@foreach($bienServicio as $key => $bien)
		<tr>
			<td>{{ $key+1 }}</td>
			<td>{{ $bien->cabms }}</td>
			<td>{{ $bien->descripcion }}</td>
			<td>{{ $bien->especificacion }}</td>
			<td>{{ $bien->unidad_medida }}</td>
			<td>{{ $bien->cantidad }}</td>
			<td>{{ $bien->precio_maximo }}</td>
			<td>{{ $bien->subtotal }}</td>
			<td>{{ $bien->iva }}</td>
			<td>{{ $bien->total }}</td>
		</tr>
		@php
			$totalCantidad += $bien->cantidad; 
			$totalPmr += floatval($bien->precio_maximo); 
			$totalSub += floatval($bien->subtotal); 
			$totalIva += floatval($bien->iva); 
			$totalTotal += floatval($bien->total); 
		@endphp
		@endforeach
		<tr>
			<td colspan="4"></td>
			<td>Totales:</td>
			<td>{{ $totalCantidad }}</td>
			<td>{{ $totalPmr }}</td>
			<td>{{ $totalSub }}</td>
			<td>{{ $totalIva }}</td>
			<td>{{ $totalTotal }}</td>
		</tr>
	</tbody>
</table>