<table>
	<thead>
		<tr>
			<th colspan="5" align="center">SISTEMA DE CONTRATO MARCO</th>
		</tr>
		<tr>
			<th colspan="5" align="center">REPORTE DIRECTORIO DE UNIDADES COMPRADORAS</th>
		</tr>
		<tr>
			<td colspan="3"><b>UNIDAD COMPRADORA:</b></td>
			<td colspan="2">{{ $reporte->urg->nombre}}</td>
		</tr>
		<tr>
			<td colspan="3"><b>FECHA DE REPORTE:</b></td>
			<td colspan="2">{{ $reporte->created_at  }}</td>
		</tr>
		<tr>
			<th style="background-color: #235b4e; color: #ffffff; width:100px;">ID</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">URG(UNIDAD RESPONSABLE DE GASTO)</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">CORREO ELECTRÓNICO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">TELÉFONO</th>
            <th style="background-color: #235b4e; color: #ffffff; width:100px;">FECHA DE CREACIÓN DE CUENTA</th>
		</tr>
	</thead>
	<tbody>
		@foreach($data as $value)
		<tr>
			<td>{{ $value->id }}</td>
			<td>{{ $value->ccg }} - {{ $value->nombre }}</td>
			<td>{{ $value->email }}</td>
			<td>{{ $value->telefono }}</td>
			<td>{{ $value->fecha_creacion }}</td>
		</tr>
		@endforeach
	</tbody>
</table>