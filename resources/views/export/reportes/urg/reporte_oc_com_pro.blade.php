<table>
	<thead>
		<tr>
			<th colspan="19" align="center">SISTEMA DE CONTRATO MARCO</th>
		</tr>
		<tr>
			<th colspan="19" align="center">REPORTE DE ORDEN DE COMPRA COMPLETO POR PROVEEDOR</th>
		</tr>
		<tr>
			<td colspan="3"><b>UNIDAD QUE GENERÓ EL REPORTE:</b></td>
			<td colspan="16">{{ $reporte->urg->nombre}}</td>
		</tr>
		<tr>
			<td colspan="3"><b>PROVEEDOR:</b></td>
			<td colspan="16">{{ $reporte->proveedor}}</td>
		</tr>
		<tr>
			<td colspan="3"><b>FECHA DE REPORTE:</b></td>
			<td colspan="16">{{ $reporte->created_at  }}</td>
		</tr>
		<tr>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID ORDEN DE COMPRA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px:">ID REQUISICIÓN</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">URG(UNIDAD RESPONSABLE DE GASTO)</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CLAVE CABMS CDMX</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">DESCRIPCIÓN DEL BIEN</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">UNIDAD DE MEDIDA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">PRECIO UNITARIO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CANTIDAD</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">MONTO TOTAL DE LA ORDEN DE COMPRA CON IVA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">MONTO TOTAL DE LA ORDEN DE COMPRA SIN IVA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CAPÍTULO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ESTATUS</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">RFC PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">TIPO DE CONTRATO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">NOMBRE CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE CREACIÓN DE LA ORDEN DE COMPRA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">REPRESENTANTE LEGAL</th>
		</tr>
	</thead>
	<tbody>
		@php 
            $total = 0;
            $totalUrg = [];
        @endphp
		@foreach($data as $key => $value)
		<tr>
			<td>{{ $value->orden_compra }}</td>
            <td>{{ $value->requisicion }}</td>
            <td>{{ $value->ccg }} - {{ $value->nombre }}</td>
            <td>{{ $value->cabms }}</td>
            <td>{{ $value->descripcion_producto }}</td>
            <td>{{ $value->tamanio }}</td>
            <td>${{ number_format($value->precio,2) }}</td>
            <td>{{ $value->cantidad }}</td>
            <td>${{ number_format($value->total_iva,2) }}</td>
            <td>${{ number_format($value->total,2) }}</td>
            <td>{{ $value->capitulo }}</td>
            <td>{{ $value->estatus }}</td>
            <td>{{ $value->proveedor }}</td>
            <td>{{ $value->rfc }}</td>
            <td>{{ $value->tipo_contrato }}</td>
            <td>{{ $value->numero_cm }}</td>
            <td>{{ $value->nombre_cm }}</td>
            <td>{{ $value->fecha_creacion }}</td>
            <td>{{ $value->nombre_legal }} {{ $value->primer_apellido_legal }} {{ $value->segundo_apellido_legal }}</td>
            @php 
            	$total = $total + $value->total_iva;
            	$totalOc = $key + 1;
            	$totalUrg[$key] = $value->ccg;
            @endphp
		</tr>
		@endforeach
	</tbody>
	<tfoot>
		<tr></tr>
		<tr>
			<td>Resumen:</td>
		</tr>
		<tr>
			<td>Total de OC</td>
			<td>{{ $totalOc }}</td>
		</tr>
		<tr>
			<td>Valor total estimado</td>
			<td>${{ number_format($total,2) }}</td>
		</tr>
		<tr>
			<td>TOTAL DE URG</td>
			<td>{{ count(array_count_values($totalUrg)) }}</td>
		</tr>
	</tfoot>
</table>