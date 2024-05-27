<table>
	<thead>
		<tr>
			<th colspan="9" align="center">SISTEMA DE CONTRATO MARCO</th>
		</tr>
		<tr>
			<th colspan="9" align="center">REPORTE DE PRECIOS CLAVES CABMS POR CONTRATO MARCO</th>
		</tr>
		<tr>
			<td colspan="3"><b>UNIDAD COMPRADORA:</b></td>
			<td colspan="6">{{ $reporte->urg->nombre }}</td>
		</tr>
		<tr>
			<td colspan="3"><b>FECHA DE REPORTE:</b></td>
			<td colspan="6">{{ $reporte->created_at  }}</td>
		</tr>
		<tr>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID PARTIDA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CAPÍTULO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CABMS CDMX</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">NOMBRE CONTRATO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">DESCRIPCIÓN DEL BIEN</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">PRECIO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE PUBLICACION</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $value)
		<tr>
			<td>{{ $value->partida }}</td>
            <td>{{ $value->capitulo }}</td>
            <td>{{ $value->cabms }}</td>
            <td>{{ $value->numero_cm }}</td>
            <td>{{ $value->nombre_cm }}</td>
            <td>{{ $value->descripcion_producto }}</td>
            <td>${{ number_format($value->precio_unitario,2) }}</td>
            <td>{{ $value->proveedor }}</td>
            <td>{{ $value->fecha_creacion }}</td>
		</tr>
		@endforeach
	</tbody>
</table>