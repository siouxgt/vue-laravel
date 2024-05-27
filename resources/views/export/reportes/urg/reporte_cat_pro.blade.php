<table>
	<thead>
		<tr>
			<th colspan="12" align="center">SISTEMA DE CONTRATO MARCO</th>
		</tr>
		<tr>
			<th colspan="12" align="center">REPORTE CATÁLOGO DE PRODUCTOS</th>
		</tr>
		<tr>
			<td colspan="3"><b>UNIDAD COMPRADORA:</b></td>
			<td colspan="9">{{ $reporte->urg->nombre}}</td>
		</tr>
		<tr>
			<td colspan="3"><b>FECHA DE REPORTE:</b></td>
			<td colspan="9">{{ $reporte->created_at  }}</td>
		</tr>
		<tr>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID PARTIDA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CLAVE CAMBS CDMX</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CAPÍTULO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE PUBLICACIÓN</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">VALIDACIÓN ECONÓMICA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">VALIDACIÓN TÉCNICA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">VALIDACIÓN ADMINISTRATIVA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CONTRATO MARCO(NOMBRE)</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID CONTRATO MARCO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">TOTAL PRODUCTOS POR CATALOGO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">NO. FICHA</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">VERSIÓN</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $value)
		<tr>
			<td>{{ $value->partida }}</td>
            <td>{{ $value->cabms }}</td>
            <td>{{ $value->capitulo }}</td>
            <td>{{ $value->fecha_publicacion }}</td>
            <td>{{ $value->validacion_economica }}</td>
            <td>{{ $value->validacion_tecnica }}</td>
            <td>{{ $value->validacion_administrativa }}</td>
            <td>{{ $value->nombre_cm }}</td>
            <td>{{ $value->numero_cm }}</td>
            <td>{{ $value->productos }}</td>
            <td>{{ $value->numero_ficha }}</td>
            <td>{{ $value->version }}</td>
		</tr>
		@endforeach
	</tbody>
</table>