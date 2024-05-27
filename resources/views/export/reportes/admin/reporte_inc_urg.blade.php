<table>
	<thead>
		<tr>
			<th colspan="10" align="center">DESGLOSE DE INCIDENCIA</th>
		</tr>
		<tr>
			<th colspan="10" align="center">SISTEMA DE CONTRATO MARCO</th>
		</tr>
		<tr>
			<th colspan="10" align="center">INFORME DE INCIDENCIAS Y REPORTES DE LA URG, DURANTE EL PROCESO DEL FLUJO DE COMPRA DE CONTRATO MARCO</th>
		</tr>
		<tr>
			<td colspan="3"><b>UNIDAD COMPRADORA:</b></td>
			<td colspan="7">{{ $reporte->urg->nombre}}</td>
		</tr>
		<tr>
			<td colspan="3"><b>FECHA DE REPORTE:</b></td>
			<td colspan="7">{{ $reporte->created_at  }}</td>
		</tr>
		<tr>
           	<th style="background-color: #235b4e; color: #ffffff; width:100px;">ID DE IDENTIFICACIÓN</th>
	        <th style="background-color: #235b4e; color: #ffffff; width:100px;">URG</th>
	        <th style="background-color: #235b4e; color: #ffffff; width:100px;">ETAPA</th>
	        <th style="background-color: #235b4e; color: #ffffff; width:100px;">ID ETAPA</th>
	        <th style="background-color: #235b4e; color: #ffffff; width:100px;">MOTIVO</th>
	        <th style="background-color: #235b4e; color: #ffffff; width:100px;">DESCRIPCIÓN</th>
	        <th style="background-color: #235b4e; color: #ffffff; width:100px;">CLAVE DE LA URG</th>
	        <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE LA INCIDENCIA</th>
	        <th style="background-color: #235b4e; color: #ffffff; width:100px;">TIPO DE LLAMADA DE ATRNCIÓN</th>
	        <th style="background-color: #235b4e; color: #ffffff; width:100px;">USUARIO QUIEN GENERA LA INCIDENCIA</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $value)
		<tr>
			<td>{{ $value->id_incidencia }}</td>
            <td>{{ $value->nombre }}</td>
            <td>{{ $value->etapa }}</td>
            <td>{{ $value->etapa_id }}</td>
            <td>{{ $value->motivo }}</td>
            <td>{{ $value->descripcion }}</td>
            <td>{{ $value->ccg }}</td>
            <td>{{ $value->fecha_creacion }}</td>
            <td>{{ $value->sancion }}</td>
            <td>{{ $value->usuario }}</td>
		</tr>
		@endforeach
	</tbody>
</table>