<table>
	<thead>
		<tr>
			<th colspan="14" align="center">SISTEMA DE CONTRATO MARCO</th>
		</tr>
		<tr>
			<th colspan="14" align="center">ANALÍTICO DE CONTRATOS MARCO COMPLETO</th>
		</tr>
		<tr>
			<td colspan="3"><b>UNIDAD COMPRADORA:</b></td>
			<td colspan="11">{{ $reporte->urg->nombre}}</td>
		</tr>
		<tr>
			<td colspan="3"><b>FECHA DE REPORTE:</b></td>
			<td colspan="11">{{ $reporte->created_at  }}</td>
		</tr>
		<tr>
			<th style="background-color: #235b4e; color: #ffffff; width:100px;">ID CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">OBJETO DEL CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">TIPO DE CONTRATACIÓN</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE CREACIÓN DEL CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE MODIFICACIÓN DE CONTRATO MARCO DATOS GENERALES</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">RESPONSABLE DEL ALTA DEL CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE INGRESO DE LA URG</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE INGRESO DEL PROVEEDOR</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CAPÍTULO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">PARTIDA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">TOTAL DE URG</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">TOTAL DE  PROVEEDORES</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ESTADO DEL CONTRATO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">TOTAL DE ORDEN DE COMPRA</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $value)
		<tr>
			<td>{{ $value->objetivo }}</td>
			<td>{{ $value->tipo_contratacion }}</td>
			<td>{{ $value->fecha_creacion }}</td>
			<td>{{ $value->fecha_fin }}</td>
			<td>{{ $value->fecha_modificacion }}</td>
			<td>{{ $value->responsable }}</td>
			<td>{{ $value->fecha_urg }}</td>
			<td>{{ $value->fecha_proveedor }}</td>
			<td>{{ $value->capitulo }}</td>
			<td>{{ $value->partida }}</td>
			<td>{{ $value->total_urg }}</td>
			<td>{{ $value->total_proveedor }}</td>
			<td>{{ $value->estatus }}</td>
			<td>{{ $value->orden_compra }}</td>
		</tr>
		@endforeach
	</tbody>
</table>