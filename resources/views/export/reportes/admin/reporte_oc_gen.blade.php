<table>
	<thead>
		<tr>
			<th colspan="9" align="center">SISTEMA DE CONTRATO MARCO</th>
		</tr>
		<tr>
			<th colspan="9" align="center">REPORTE DE ORDEN DE COMPRA GENERAL</th>
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
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID ORDEN DE COMPRA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID REQUISICIÓN</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">URG(UNIDAD RESPONSABLE DE GASTO)</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">MONTO TOTAL DE LA ORDEN DE COMPRA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CAPÍTULO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ESTATUS</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">RFC PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE ORDEN DE COMPRA</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $value)
		<tr>
			<td>{{ $value->orden_compra }}</td>
            <td>{{ $value->requisicion }}</td>
            <td>{{ $value->ccg }} - {{ $value->nombre }}</td>
            <td>${{ number_format($value->total,2) }}</td>
            <td>{{ $value->capitulo }}</td>
            <td>{{ $value->estatus }}</td>
            <td>{{ $value->proveedor }}</td>
            <td>{{ $value->rfc }}</td>
            <td>{{ $value->fecha_creacion }}</td>
		</tr>
		@endforeach
	</tbody>
</table>